<?php

/**
 * Created by PhpStorm.
 * User: andreas
 * Date: 28/01/2016
 * Time: 9:27 ΜΜ
 */


class VentureController
{

    private $config=array();
    private $bu_name='';
    /**
     * the constructor
     */

    public function __construct()
    {

        $this->init();

    }



    /**
     * init our Soap Service to CRM
     */
    private function init()
    {
        $DOCUMENT_ROOT = $_SERVER ['DOCUMENT_ROOT'];
        require_once($DOCUMENT_ROOT . '/wp-load.php');

        if(is_user_logged_in()) {
            global $current_user;
            $user_email = $current_user->user_email;
            $user_data=$this->get_user_details($user_email);
            $this->bu_name=$user_data['business_unit'];
        }else{

            //!Get the right Bussiness Unit
            if(!empty($_POST['reg_lang']))
                $lang_code=$_POST['reg_lang'];
            else
                $lang_code=ICL_LANGUAGE_CODE;

            //!Get the options from Venture Plugin Settings
            $this->bu_name='bu_'.$lang_code;
        }

        //!Get the right Business Unit
        global $config;
        $this->config=$config[$this->bu_name];

    }


    /**
     * Create Lead Function
     */
    public function create_lead($data)
    {
        //! Check if User Exist as 'Client' in Portal
        $exist = $this->check_user_details($data['email']);

        if (empty($exist)) {
            $result['Code'] = '1';
            $result['Message'] = 'Duplicate Customer .Please login with your details .';
            $result = json_encode($result);
            return $result;
        }

        //! Check if user Exist as 'Lead' in Portal
        $data_return=$this->execute_select($data['email'],'leads');
        if($data_return[0]['converted']=='0' && !empty($data_return[0]['email'])){
            $result_array['AccountId'] = $data_return[0]['account_id'];
            $result_array['Code'] = 'Success';
            $result_array['Message'] = 'Lead Already Exist';
            $result = json_encode($result_array);
            return $result;

        }


//! This Global config will be change and added as part of base class

        $country = $data['countryId'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $phoneCountryCode = $data['phoneCountryCode'];
        $phoneAreaCode = ( isset($data['phoneAreaCode']) ? $data['phoneAreaCode'] : '0000') ;
        $phoneNumber = $data['phoneNumber'];
        $email = $data['email'];
        $affiliate=$data['affid'];
        $cxd=$data['cxd'];

        try {
            $countryId = new guid();
            $countryId = $country;
            $ownerUserId = new guid();
            $ownerUserId = $this->config['ownerUserId'];

            $leadAccountRegistrationRequest = new LeadAccountRegistrationRequest();
            $leadAccountRegistrationRequest->CountryOfCitizenshipId = $countryId;
            $leadAccountRegistrationRequest->CountryId = $countryId;
            $leadAccountRegistrationRequest->FirstName = $firstName;
            $leadAccountRegistrationRequest->LastName = $lastName;
            $leadAccountRegistrationRequest->Email = $email;
            $leadAccountRegistrationRequest->PhoneAreaCode = $phoneAreaCode;
            $leadAccountRegistrationRequest->PhoneCountryCode = $phoneCountryCode;
            $leadAccountRegistrationRequest->PhoneNumber = $phoneNumber;

            $leadAccountRegistrationRequest->AdditionalInfo = new DynamicAttributeInfo();
            $leadAccountRegistrationRequest->EnvironmentInfo = new EnvironmentInfo();
            $leadAccountRegistrationRequest->MarketingInfo = new MarketingInfo();
            $leadAccountRegistrationRequest->MarketingInfo->Affiliate=$affiliate;
            $leadAccountRegistrationRequest->MarketingInfo->AffiliateTransactionId=$cxd;


            $registerLeadAccount = new RegisterLeadAccount();

            $registerLeadAccount->ownerUserId = $ownerUserId;
            $registerLeadAccount->organizationName = $this->config['organization'];
            $registerLeadAccount->businessUnitName = $this->config['businessUnitName'];
            $registerLeadAccount->leadAccountRegistrationRequest = $leadAccountRegistrationRequest;
            $leverateCrm = getCrm($this->config);

            $registerLeadAccountResponse = $leverateCrm->RegisterLeadAccount($registerLeadAccount);
            $accountRegistrationResult = $registerLeadAccountResponse->RegisterLeadAccountResult;

            $ResultInfo = new ResultInfo();
            $ResultInfo = $accountRegistrationResult->Result;

            $result = $accountRegistrationResult->AccountId;
            $success = $ResultInfo->Code;
            $message = $ResultInfo->Message;

            $result_array['AccountId'] = $accountRegistrationResult->AccountId;
            $result_array['Code'] = $ResultInfo->Code;
            $result_array['Message'] = $ResultInfo->Message;

            //!Create Lead for the Portal if we have success Registration
            //!Parameter Account added on data
            if ($result_array['Code'] == 'Success') {
                $data['AccountId'] = $result_array['AccountId'];
                $result['AccountId']= $result_array['AccountId'];
                $this->insert_lead($data);
                $this->email_service($data,'lead_creation');
                if($cxd!='') {
                    file_get_contents('http://tracking.orient-network.com/aff_lsr?&transaction_id=' . $cxd);
                }
            }


            $result = json_encode($result_array);
            return $result;

        } catch (Exception $e) {
            //!Case of Exception

            //!Monitor Get the error
            $error_log['service'] = 'create_lead';
            $error_log['request'] = json_encode((array)$registerLeadAccount);
            $error_log['response'] = 'Caught exception: ' . $e;
            $this->log_error($error_log);

            //!Custom Error Code 99 for our Integration
            $ResultInfo = new ResultInfo();
            $ResultInfo->Code = '99';
            $ResultInfo->Message = 'Caught exception: ' . $e;
            $result = json_encode((array)$ResultInfo);
            return $result;
        }
    }


    /**
     * Check if User Exists as Client in Portal
     *
     */

    private function check_user_details($email)
    {
        $user = get_user_by('email', $email);
        //!Unique Users for Portal
        if (!empty($user)) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * Check if User Exists as Lead in Portal
     * 1st Step of Registration
     */

    private function insert_lead($data)
    {

        global $wpdb;

        $sql = $wpdb->insert(
            'leads', array(
                'first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'email' => $data['email'],
                'account_id' => $data['AccountId'],
                'country' => $data['countryId'],
                'phone_ccode' =>  $data['phoneCountryCode'],
                'phone' => $data['phoneNumber'],
                'reg_lang' =>$data['reg_lang'],
                'business_unit'=>$this->bu_name

            ));

        $wpdb->query($sql);

    }


    /**
     * 3rd step Real Registration
     *
     */

    public function convert_lead_to_client($data)
    {

        $exist = $this->check_user_details($data['email']);

        if (empty($exist)) {
            $result['Code'] = '1';
            $result['Message'] = 'Duplicate Customer';
            $result = json_encode($result);
            return $result;
        }

        //! This Global config will be change and added as part of base class

        $groupName = 'Leverate';
        $trading_platform_id = $this->config['tradingPlatforms']['REAL-SIRIX']['id'];
        $owner_user_id_conf = $this->config['ownerUserId'];


        $country = $data['countryId'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $phoneCountryCode = $data['phoneCountryCode'];
        $phoneAreaCode = ( isset($data['phoneAreaCode']) ? $data['phoneAreaCode'] : '0000') ;
        $phoneNumber = $data['phoneNumber'];
        $email = $data['email'];
        $DateOfBirth = $data['DateOfBirth'];
        $address1 = $data['address1'];
        $address2 = $data['address2'];
        $AverageTradeSize = $data['AverageTradeSize'];
        $City = $data['towncity'];
        $State = $data['State'];
        $ZipCode = $data['ZipCode'];
        $password = $data['Password'];
        $CfdTradingExperience = $data['CfdTradingExperience'];
        $EstimatedAnnualIncome = $data['EstimatedAnnualIncome'];
        $EstimatedNetWorth = $data['EstimatedNetWorth'];
        $HasDemoExperience = ('1' == $data['HasDemoExperience']) ? true : false;
        $MobileNumber = $data['MobileNumberCCode'] . $data['MobileNumber'];
        $NumberOfTimesTradedInPastYear = $data['NumberOfTimesTradedInPastYear'];

        $SecuritiesTradingExperience = $data['SecuritiesTradingExperience'];
        $CurrenciesTradingExperience = $data['CurrenciesTradingExperience'];
        $FuturesTradingExperience = $data['FuturesTradingExperience'];
        $OptionsTradingExperience = $data['OptionsTradingExperience'];


        //!Check  logged in Account Id
        if (isset($data['account_id']) && !empty($data['account_id'])) {
            $AccountId = $data['AccountId'];
        } else {
            $AccountId = '00000000-0000-0000-0000-000000000000';
        }

        try {
            $countryId = new guid();
            $countryId = $country;
            $ownerUserId = new guid();
            $ownerUserId = $owner_user_id_conf;

            $RealAccountRegistrationRequest = new RealAccountRegistrationRequest();

            //!Adding the fields for our 3 step Registration(EXTRA FIELDS FOR KYC)
            $RealAccountRegistrationRequest->Address1 = $address1;
            $RealAccountRegistrationRequest->Address2 = $address2;
            $RealAccountRegistrationRequest->AverageTradeSize = $AverageTradeSize;
            $RealAccountRegistrationRequest->CfdTradingExperience = $CfdTradingExperience;
            $RealAccountRegistrationRequest->CurrenciesTradingExperience = $CurrenciesTradingExperience;
            $RealAccountRegistrationRequest->DateOfBirth = $DateOfBirth;
            $RealAccountRegistrationRequest->EstimatedAnnualIncome = $EstimatedAnnualIncome;
            $RealAccountRegistrationRequest->EstimatedNetWorth = $EstimatedNetWorth;
            $RealAccountRegistrationRequest->FuturesTradingExperience = $FuturesTradingExperience;
            $RealAccountRegistrationRequest->HasDemoExperience = $HasDemoExperience;
            $RealAccountRegistrationRequest->MobileNumber = $MobileNumber;
            $RealAccountRegistrationRequest->NumberOfTimesTradedInPastYear = $NumberOfTimesTradedInPastYear;
            $RealAccountRegistrationRequest->OptionsTradingExperience = $OptionsTradingExperience;
            $RealAccountRegistrationRequest->Password = $password;
            $RealAccountRegistrationRequest->SecuritiesTradingExperience = $SecuritiesTradingExperience;
            $RealAccountRegistrationRequest->State = $State;
            $RealAccountRegistrationRequest->ZipCode = $ZipCode;
            $RealAccountRegistrationRequest->City = $City;
            $RealAccountRegistrationRequest->AcceptTermsAndConditions = true;


            $RealAccountRegistrationRequest->TradingPlatformId = $trading_platform_id;
            $RealAccountRegistrationRequest->GroupName = $groupName;
            $RealAccountRegistrationRequest->CountryId = $countryId;
            $RealAccountRegistrationRequest->FirstName = $firstName;
            $RealAccountRegistrationRequest->LastName = $lastName;
            $RealAccountRegistrationRequest->PhoneCountryCode = $phoneCountryCode;
            $RealAccountRegistrationRequest->PhoneAreaCode = $phoneAreaCode;
            $RealAccountRegistrationRequest->PhoneNumber = $phoneNumber;
            $RealAccountRegistrationRequest->Email = $email;
            $RealAccountRegistrationRequest->Password = $password;
            $RealAccountRegistrationRequest->LoggedInAccountId = $AccountId;
            $RealAccountRegistrationRequest->PlaceOfBirth = '';

            $RealAccountRegistrationRequest->AdditionalInfo = new DynamicAttributeInfo();
            $RealAccountRegistrationRequest->EnvironmentInfo = new EnvironmentInfo();
            $RealAccountRegistrationRequest->MarketingInfo = new MarketingInfo();

            $RegisterRealAccount = new RegisterRealAccount();

            $RegisterRealAccount->ownerUserId = $ownerUserId;
            $RegisterRealAccount->organizationName = $this->config['organization'];
            $RegisterRealAccount->businessUnitName = $this->config['businessUnitName'];
            $RegisterRealAccount->realAccountRegistrationRequest = $RealAccountRegistrationRequest;

            $leverateCrm = getCrm($this->config);

            $registerRealAccountResponse = $leverateCrm->RegisterRealAccount($RegisterRealAccount);
            $result = $registerRealAccountResponse->RegisterRealAccountResult;

            $data['AccountId'] = $result->AccountId;
            $data['MainTradingAccountName'] = $result->TradingPlatformAccountName;
            $data['MainPlatformAccountType'] = $result->TradingPlatformAccountType;


            $result_return['Code'] = $result->Result->Code;
            $result_return['Message'] = $result->Result->Message;
            $result = json_encode($result_return);


            //!Create WP User for the Portal if we have success Registration
            if ($result_return['Code'] == 'Success' || $result_return['Code'] == 'SuccessWithDuplicates') {

                //! Create WP user Action 1
                $this->create_wp_user($data);

                //! Login The Account Into System Action 2
                $this->login_user($email, $password);

                //! Send Emails (portal+account) Action 3
                $this->email_service($data, 'real_registration_email');


            }

            return $result;

        } catch (Exception $e) {

            //!Case of Exception
            //!Custom Error Code 99 for our Integration
            $ResultInfo = new ResultInfo();
            $ResultInfo->Code = '99';
            $ResultInfo->Message = 'Caught exception: ' . $e;
            $result = json_encode((array)$ResultInfo);
            $error_log['service'] = 'Convert_to_Real';
            $error_log['request'] = json_encode((array)$RealAccountRegistrationRequest);
            $error_log['response'] = $leverateCrm->soapClient->__getLastResponseHeaders();
            $this->log_error($error_log);
            return $result;
        }

    }


    private function email_service($data, $email_action)
    {

        //!Get the class of email - Need to add it in construct
        require_once($_SERVER ['DOCUMENT_ROOT'] . '/wp-content/plugins/Venture/Email/email_generic.php');
        $email_instance = new email_generic();

        switch ($email_action) {

            case "real_registration_email":
                $email_instance->send_welcome_email($data);
                $email_instance->send_TPAccount_email($data);
                break;

            case "send_forgot_email" :
                $email_instance->send_forgot_email($data);
                break;

            case "upload_file_account" :
                $email_instance->send_docs_notification_email($data);
                break;

            case "lead_creation" :
                $email_instance->send_welcome_lead_email($data);
                break;
        }
    }


    private function log_error($data)
    {

        global $wpdb;

        $sql = $wpdb->insert(
            'error_logs', array(
                'service' => $data['service'],
                'response' => $data['response'],
                'request' => $data['request']
            ));

        $wpdb->query($sql);
    }


    private function create_wp_user($data)
    {

        $mainTPAcccountName = $data['MainTradingAccountName'];
        $mainTPaccount_type = $data['MainPlatformAccountType'];

        $country = $data['countryId'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $phoneCountryCode = $data['phoneCountryCode'];
        $phoneNumber = $data['phoneNumber'];
        $email = $data['email'];
        $account_id = $data['AccountId'];
        $City = $data['towncity'];
        $State = $data['State'];
        $ZipCode = $data['ZipCode'];
        $password = $data['Password'];
        $address1 = $data['address1'];
        $DateOfBirth = $data['DateOfBirth'];

        $userdata = array(
            'user_login' => $email, // username
            'first_name' => $firstName,
            'user_email' => $email,
            'user_pass' => $password,
            'role' => 'real'
        );


        $newuser = wp_insert_user($userdata);
        $wp_user = new WP_User ($newuser);
        $wp_user->set_role('real');

        global $wpdb;

        $sql = $wpdb->insert(
            'customers', array(
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'account_id' => $account_id,
                'main_tp_account' => $mainTPAcccountName,
                'phone_ccode' => $phoneCountryCode,
                'phone_number' => $phoneNumber,
                'country' => $country,
                'address1' => $address1,
                'state' => $State,
                'city' => $City,
                'post_code' => $ZipCode,
                'business_unit' =>  $this->bu_name
            ));


        $wpdb->query($sql);

        return true;
    }


    public function login_user($email, $password)
    {

        $uid = wp_authenticate($email, $password);

        if ($uid) {

            $creds = array();
            $creds ['user_login'] = $email;
            $creds ['user_password'] = $password;
            $creds ['remember'] = true;
            $autologin_user = wp_signon($creds, false);

            if (!is_wp_error($autologin_user)) {

                $result['Code'] = 'Success';
                $result['Message'] = '';
                $result = json_encode($result);
                return $result;

            } else {

                $result['Code'] = '0';
                $result['Message'] = 'Authentication Failure. Incorrect Username or Password.';
                $result = json_encode($result);
                return $result;

            }

        } else {
            $result['Code'] = '0';
            $result['Message'] = 'Authentication Failure. Incorrect Username or Password.';
            $result = json_encode($result);
            return $result;
        }

    }


    private function get_user_details($email)
    {

        global $wpdb;

        $table_name = 'customers';
        $user = $wpdb->get_row("select * FROM $table_name WHERE  email = '$email'", ARRAY_A);

        //!Unique Users for Portal
        if (!empty($user['email'])) {
            return $user;
        } else {
            return true;
        }

    }

    private function execute_select($email, $table_name)
    {

        global $wpdb;
        $true = $wpdb->get_results("select * FROM $table_name WHERE  email = '$email'", ARRAY_A);
        //!Unique Users for Portal
        if (!empty($true)) {
            return $true;
        } else {
            return true;
        }
    }

    private function execute_insert($fields_insert, $table_name)
    {

        global $wpdb;
        $sql = $wpdb->insert($table_name, $fields_insert);
        $wpdb->query($sql);

    }

    private function execute_sql_update($table_name, $array_updated, $array_condition)
    {

        global $wpdb;
        $sql = $wpdb->update($table_name, $array_updated, $array_condition);
        $wpdb->query($sql);

    }


    public function portal_forgot_password($data)
    {

        //!Validation for Email.
        if (filter_var($data['username'], FILTER_VALIDATE_EMAIL)) {

            $email = $data['username'];

            //!Verify that is a client in portal
            $exist = $this->get_user_details($email);

            if (empty($exist)) {
                $result['Code'] = '0';
                $result['Message'] = 'Please Check your Email. If you think is correct contact Site Administrator';
                $result = json_encode($result);
                return $result;
            }

            $token = md5($email);

            //!Save token to table crm_users
            global $wpdb;

            $sql = $wpdb->update(
                'customers',
                array(
                    'token' => $token
                ),
                array('email' => $email)
            );


            $wpdb->query($sql);

            //Data that will be attached to email
            $Data["email"] = $email;
            $Data["firstName"] = $exist['first_name'];
            $Data["lastName"] = $exist['last_name'];
            $Data["token"] = $token;

            $this->email_service($Data, 'send_forgot_email');

            $result['Code'] = 'Success';
            $result['Message'] = 'An email has been sent to your account. In case you do not receive this email within the next 5 minutes, please contact our support team.';
            $result = json_encode($result);
            return $result;

        } else {

            $result['Code'] = '0';
            $result['Message'] = 'Please Check your Email. If you think is correct contact Site Administrator';
            $result = json_encode($result);
            return $result;
        }
    }

    public function portal_reset_password($data)
    {

        //!Get user by token and email
        $user = $this->get_user_details($data['email']);

        if (!empty($user['email']) && $user['token'] == $data['account_token'] && !empty($data['password'])) {

            $email = $user['email'];
            $new_password = $data['password'];

            global $wpdb;
            $user_results = $wpdb->get_results($wpdb->prepare("SELECT *  FROM wp_users WHERE  user_login = %s", $email));
            $user_id = $user_results [0]->ID;

            //!Not to Change admin code from this form
            if (!empty($user_id) && ($user_id !== '1')) {

                wp_set_password($new_password, $user_id);

                //!Set the token to null
                $this->execute_sql_update('customers', array('token' => ''), array('email' => $email));

                $result['Code'] = 'Success';
                $result['Message'] = 'Password Changed Successfully. You will be redirected to login in : ';
                $result = json_encode($result);
                return $result;

            }

        }

        $result['Code'] = '0';
        $result['Message'] = 'Error Occured while trying to process your Request . Please Contact Our Support team.';
        $result = json_encode($result);
        return $result;
    }


    public function get_account_details($data)
    {

        try {


            $email = $data['email'];
            $ownerUserId = new guid();
            $ownerUserId = $this->config['ownerUserId'];
            $request = new AccountDetailsRequest();
            $request->FilterType = 'Email';

            $getAccountDetails = new GetAccountDetails();
            $getAccountDetails->ownerUserId = $ownerUserId;
            $getAccountDetails->organizationName = $this->config['organization'];
            $getAccountDetails->businessUnitName = $this->config['businessUnitName'];
            $getAccountDetails->accountDetailsRequest = $request;

            $leverateCrm = getCrm($this->config);

            $response = new GetAccountDetailsResponse();
            $response = $leverateCrm->GetAccountDetails($getAccountDetails);
            $result = $response->GetAccountDetailsResult;

            $ResultInfo = new ResultInfo();
            $ResultInfo = $result->Result;

            $result = $result->AccountsInfo;
            $success = $ResultInfo->Code;
            $message = $ResultInfo->Message;


            $ResultInfo = $result->Result;
            $result = json_encode((array)$ResultInfo);
            return $result;


        } catch (Exception $e) {

            //!Case of Exception

            //!Custom Error Code 99 for our Integration
            $ResultInfo = new ResultInfo();
            $ResultInfo->Code = '99';
            $ResultInfo->Message = 'Caught exception: ' . $e;
            $result = json_encode((array)$ResultInfo);

            $error_log['service'] = 'get_tp_account_details';
            $error_log['request'] = json_encode(array('email' => $email));
            $error_log['response'] = $leverateCrm->soapClient->__getLastResponseHeaders();

            $this->log_error($error_log);

        }

        return $result;

    }

    private function create_transaction_id($user_id, $prefix = 'DEP')
    {

        require_once('pass_generator.php');
        $unique_char = PasswordGenerator::getAlphaNumericPassword(8);

        //!TRANSACTION PREFIX + USER ID + UNIQUE CHAR
        $uniqueID = $prefix . $user_id . $unique_char;

        return $uniqueID;
    }

    public function portal_update_userinformation($data)
    {

        //!Get User by email
        global $current_user;
        $user_email = $current_user->user_email;

        if ($user_email !== $data['email']) {

            $result['Code'] = '0';
            $result['Message'] = 'Error Occured. Please Contact Site Administrator';
            $result = json_encode($result);
            return $result;

        }

        //!Update User Information On CRM
        $response = $this->update_crm_account_details($data);

        if (!empty($response)) {

            //!Unset the Values that we do not want
            unset($data['account_id']);
            unset($data['submit']);
            unset($data['user_country_id']);
            unset($data['countryId']);

            //!Update the Data on Wordpress Site
            $this->execute_sql_update('customers', $data, array('email' => $data['email']));

            //!For each account update details
            $result['Code'] = 'Success';
            $result['Message'] = 'Your details has been updated Successfully.';
            $result = json_encode($result);
            return $result;

        }

        $result['Code'] = '0';
        $result['Message'] = 'Error Occured. Please Contact Site Administrator';
        $result = json_encode($result);
        return $result;

    }

    public function create_withdraw_monetary_transaction($data){

        $tradingPlatformAccountId = $data['TPaccountNameWithdrawal'];
        $amount = $data['amount'];


        //!Get User by email
        global $current_user;
        $email = $current_user->user_email;

        //!Set the Case Title and Description
        $description = 'User with email : ' . $email . ' Create Withdrawal Request with Amount : ' . $amount;


        try {

            $leverateCrm = getCrm($this->config);

            $info = new MonetaryTransactionRequestInfo();
            $info->Amount = $amount;
            $info->TradingPlatformAccountId = $tradingPlatformAccountId;
            $info->PaymentInfo = new CashPaymentInfo();
            $info->OriginalAmount = null;
            $info->OriginalCurrency = null;

            $dynamicAttributeInt = new DynamicAttributeInfo();
            $dynamicAttributeInt->Name = 'lv_withdrawalreason';
            $dynamicAttributeInt->DynamicAttributeType = 'Picklist';
            $dynamicAttributeInt->Value = new SoapVar(3, XSD_INT, "int", "http://www.w3.org/2001/XMLSchema");

            $dynamicAttributeString = new DynamicAttributeInfo();
            $dynamicAttributeString->Name = 'lv_internalcomment';
            $dynamicAttributeString->DynamicAttributeType = 'String';
            $dynamicAttributeString->Value = new SoapVar($description, XSD_STRING, "string", "http://www.w3.org/2001/XMLSchema");

            $dynamicAttributeBit = new DynamicAttributeInfo();
            $dynamicAttributeBit->Name = 'lv_managementapproval';
            $dynamicAttributeBit->DynamicAttributeType = 'Bit';
            $dynamicAttributeBit->Value = new SoapVar(false, XSD_BOOLEAN, "boolean", "http://www.w3.org/2001/XMLSchema");


            $request = new WithdrawalMonetaryTransactionRequest();
            $request->WithdrawalHasDocuments=false;
            $request->WithdrawalPaymentDetails='Testing Withdrawal New Functionality';
            $request->MonetaryTransactionRequestInfo = $info;
            $request->AdditionalAttributes = array($dynamicAttributeInt, $dynamicAttributeString, $dynamicAttributeBit);



            $query = new CreateMonetaryTransaction();
            $query->ownerUserId = $this->config['ownerUserId'];
            $query->organizationName = $this->config['organization'];
            $query->businessUnitName = $this->config['businessUnitName'];
            $query->monetaryTransactionRequest = $request;

            $response = $leverateCrm->CreateMonetaryTransaction($query);

            $ResultInfo = new ResultInfo();
            $ResultInfo = $response->CreateMonetaryTransactionResult->Result;

            $result = json_encode((array)$ResultInfo);

            return $result;

        } catch (Exception $e) {

            $error_log['service'] = 'create_withdrawal_monetary';
            $error_log['request'] = json_encode((array)$request);
            $error_log['response'] = $leverateCrm->soapClient->__getLastResponseHeaders();

            $this->log_error($error_log);

            $result['Code'] = '0';
            $result['Message'] = 'Error Occured. Please Contact Site Administrator';
            $result = json_encode($result);
            return $result;

        }
    }

    private function update_crm_account_details($data)
    {



        try {

            $leverateCrm = getCrm($this->config);
            $request = new UpdateAccountDetailsRequest();

            $request->AccountId = $data['account_id'];
            $request->FirstName = $data['first_name'];
            $request->LastName = $data['last_name'];
            $request->CountryId = $data['countryId'];
            $request->Address1 = $data['address1'];
            $request->Address2 = $data['address2'];
            $request->City=$data['city'];
            $request->State=$data['state'];
            $request->ZipCode = $data['post_code'];
            $request->PhoneCountryCode = $data['phone_ccode'];
            $request->PhoneNumber = $data['phone_number'];


            $details = new UpdateAccountDetails();
            $details->ownerUserId = $this->config['ownerUserId'];
            $details->organizationName = $this->config['organization'];
            $details->businessUnitName = $this->config['businessUnitName'];

            $details->updateAccountDetailsRequest = $request;

            $response = $leverateCrm->UpdateAccountDetails($details);

            $ResultInfo = new ResultInfo();
            $ResultInfo = $response->UpdateAccountDetailsResult->Result;
            $accountInfo = $response->UpdateAccountDetailsResult->AccountInfo;

            $result = $ResultInfo->RequestId;
            $success = $ResultInfo->Code;
            $message = $ResultInfo->Message;

            $ResultInfo = $result->Result;
            $result = json_encode((array)$ResultInfo);

            return true;

        } catch (Exception $e) {

            $error_log['service'] = 'update_crm_account_details';
            $error_log['request'] = json_encode((array)$request);
            $error_log['response'] = $leverateCrm->soapClient->__getLastResponseHeaders();

            $this->log_error($error_log);
            return false;
        }

    }

    public function upload_file_account($data)
    {




        try {

            $leverateCrm = getCrm($this->config);
            $request = new UploadFile();
            $request->ownerUserId = $this->config['ownerUserId'];
            $request->organizationName = $this->config['organization'];
            $request->businessUnitName = $this->config['businessUnitName'];

            $user = $this->get_user_details($data['email']);

            //!upload Data
            $request->accountId = $user['account_id'];
            $request->fileName = $data['file_name'];
            $request->fileContent = $data['file_content'];

            $response = $leverateCrm->UploadFile($request);

            if ($response->UploadFileResult->Code != 'Success') {

                return false;

            } else {

                $data_to_insert = array(
                    'email' => $data['email'],
                    'document_type' => $data['document_type'],
                    'file_name' => $data['file_name']
                );

                $this->execute_insert($data_to_insert, 'customer_documents');
                $this->email_service($data, 'upload_file_account');
                return true;
            }


        } catch (Exception $e) {


            $error_log['service'] = 'upload_document_file';

            $data_upload['email'] = $data['email'];
            $data_upload['file_name'] = $data['file_name'];
            $data_upload['exception'] = $e;

            $error_log['request'] = json_encode($data_upload);
            $error_log['response'] = $leverateCrm->soapClient->__getLastResponseHeaders();

            $this->log_error($error_log);


            return false;
        }
    }

    public function forgot_TP_password($data)
    {

        $tradingPlatformAccountName = $data['TradingPlatformAccountName'];
        $email = $data['email_forgot'];



        try {

            $ownerUserId = new guid();
            $ownerUserId = $this->config['ownerUserId'];
            $forgotPassword = new ForgotYourPassword();
            $forgotPassword->ownerUserId = $ownerUserId;
            $forgotPassword->organizationName = $this->config['organization'];
            $forgotPassword->businessUnitName = $this->config['businessUnitName'];
            $forgotPassword->tradingPlatformAccountName = $tradingPlatformAccountName;
            $forgotPassword->email = $email;

            $leverateCrm = getCrm($this->config);

            $forgotPasswordResponse = new ForgotYourPasswordResponse();
            $forgotPasswordResponse = $leverateCrm->ForgotYourPassword($forgotPassword);
            $forgotPasswordResult = $forgotPasswordResponse->ForgotYourPasswordResult;

            $ResultInfo = new ResultInfo();
            $ResultInfo = $forgotPasswordResponse->ForgotYourPasswordResult;

            $result = json_encode((array)$ResultInfo);
            return $result;

        } catch (Exception $e) {


            $error_log['service'] = 'forgot_tpaccount_password';
            $error_log['request'] = json_encode((array)$forgotPassword);
            $error_log['response'] = $leverateCrm->soapClient->__getLastResponseHeaders();

            $this->log_error($error_log);

            $result['Code'] = '0';
            $result['Message'] = 'Error Occured. Please Contact Site Administrator';
            $result = json_encode($result);
            return $result;

        }
    }


    public function reset_TP_password($data)
    {



        $tradingPlatformAccountName = $data['TradingPlatformAccountName'];
        $tradingPlatformAccountOldPassword = $data['oldPassword'];
        $tradingPlatformAccountNewPassword = $data['newPassword'];

        try {

            $request = new ChangePassword();
            $request->ownerUserId = $this->config['ownerUserId'];
            $request->organizationName = $this->config['organization'];
            $request->businessUnitName = $this->config['businessUnitName'];
            $request->tradingPlatformAccountName = $tradingPlatformAccountName;
            $request->tradingPlatformAccountOldPassword = $tradingPlatformAccountOldPassword;
            $request->tradingPlatformAccountNewPassword = $tradingPlatformAccountNewPassword;

            $leverateCrm = getCrm($this->config);

            $response = new ChangePasswordResponse();
            $response = $leverateCrm->ChangePassword($request);
            $ResultInfo = $response->ChangePasswordResult;

            $result = json_encode((array)$ResultInfo);
            return $result;

        } catch (Exception $e) {

            $error_log['service'] = 'reset_tpaccount_password';
            $error_log['request'] = json_encode((array)$request);
            $error_log['response'] = $leverateCrm->soapClient->__getLastResponseHeaders();

            $this->log_error($error_log);

            $result['Code'] = '0';
            $result['Message'] = 'Error Occured. Please Contact Site Administrator';
            $result = json_encode($result);
            return $result;

        }

    }


    public function get_tpaccount_history($data)
    {

        $accountId = $data['TradingPlatformAccountName'];
        $start_date = $data['start_date_history'];
        $end_date = $data['end_date_history'];



        try {

            $leverateCrm = getCrm($this->config);

            $request = new GetTradingHistory();

            $request->ownerUserId = $this->config['ownerUserId'];
            $request->organizationName = $this->config['organization'];
            $request->businessUnitName = $this->config['businessUnitName'];
            $request->tradingPlatformAccountId = $accountId;
            $request->startTime = $start_date;
            $request->endTime = $end_date;
            $request->maxRows = 30;

            $response = $leverateCrm->GetTradingHistory($request);

            $ResultInfo = new ResultInfo();
            $ResultInfo = $response->GetTradingHistoryResult->Result;

            $closedPositionInfo = $response->GetTradingHistoryResult->ClosedPositions;


            if ($ResultInfo->Code !== 'Success') {

                $result = json_encode((array)$ResultInfo);
                return $result;
            }

            //!Get the Closed positions data

            $return_positions = $response->GetTradingHistoryResult->ClosedPositions->ClosedPositionInfo;
            $result = json_encode((array)$return_positions);
            return $result;


        } catch (Exception $e) {

            $error_log['service'] = 'get_tp_account_history';
            $error_log['request'] = json_encode((array)$request);
            $error_log['response'] = $leverateCrm->soapClient->__getLastResponseHeaders();

            $this->log_error($error_log);

            $result['Code'] = '0';
            $result['Message'] = 'Error Occured. Please Contact Site Administrator';
            $result = json_encode($result);
            return $result;
        }
    }


    public function create_withdrawal($data)
    {

        $tradingPlatformAccountName = $data['TPaccountNameWithdrawal'];
        $amount = $data['amount'];
        $currencyId = $data['currencyId'];

        //!Get User by email
        global $current_user;
        $email = $current_user->user_email;

        $user_detail = $this->get_user_details($email);
        $accountId = $user_detail['account_id'];

        //!Set the Case Title and Description
        $caseTitle = 'Withdrawal Request User : ' . $email;
        $description = 'User with email : ' . $email . ' Create Withdrawal Request with Amount : ' . $amount;




        try {

            $leverateCrm = getCrm($this->config);
            $details = new WithdrawalRequest();

            //!Passing Arguments
            $details->AccountId = $accountId;
            $details->Amount = $amount;
            $details->CaseTitle = $caseTitle;
            $details->CurrencyId = $currencyId;
            $details->Description = $description;
            $details->TradingPlatformAccountName = $tradingPlatformAccountName;

            $details->WithdrawalMethod = 'Cash';

            $request = new CreateWithdrawalRequest();
            $request->ownerUserId = $this->config['ownerUserId'];
            $request->organizationName = $this->config['organization'];
            $request->businessUnitName = $this->config['businessUnitName'];
            $request->withdrawalRequest = $details;

            $response = $leverateCrm->CreateWithdrawalRequest($request);
            $ResultInfo = new ResultInfo();
            $ResultInfo = $response->CreateWithdrawalRequestResult;

            $result = json_encode((array)$ResultInfo);

            return $result;

        } catch (Exception $e) {

            $error_log['service'] = 'create_withdrawal';
            $error_log['request'] = json_encode((array)$request);
            $error_log['response'] = $leverateCrm->soapClient->__getLastResponseHeaders();

            $this->log_error($error_log);

            $result['Code'] = '0';
            $result['Message'] = 'Error Occured. Please Contact Site Administrator';
            $result = json_encode($result);
            return $result;

        }
    }


    public function get_user_docs()
    {

        //!Get User by email
        global $current_user;
        $user_email = $current_user->user_email;

        $result = $this->execute_select($user_email, 'customer_documents');

        $count = 0;
        foreach ($result as $document) {
            $data_return['doc_id'] = $count;
            $data_return['doc_id']['email'] = $document['email'];
            $data_return['doc_id']['file_name'] = $document['file_name'];
            $data_return['doc_id']['date_uploaded'] = $document['date_uploaded'];
            $count++;
        }

        if ($count > 0) {
            $result_json = json_encode($result);
            return $result_json;
        }

        return false;
    }


    public function register_additional_account($data)
    {

        //!Get User by email
        global $current_user;
        $user_email = $current_user->user_email;
        $user = $this->get_user_details($user_email);


        //! This Global config will be change and added as part of base class

        //!Configure the Group According to platform and Currency !//
        $platform_name=$data['platform'];
        $base_currency=$data['currencyId'];
        $trading_platform_id = $this->config['tradingPlatforms'][$platform_name]['id'];
        $groups=$this->get_trading_platform_group($platform_name,$base_currency);
        $groupName=$groups[0]['group_name'];
        //! End of this configuration !!//


        $owner_user_id_conf = $this->config['ownerUserId'];
        $AccountId = $user['account_id'];
        $email = $user['email'];

        $country = $data['countryId'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $phoneCountryCode = $data['phoneCountryCode'];
        $phoneAreaCode = ( isset($data['phoneAreaCode']) ? $data['phoneAreaCode'] : '0000') ;
        $phoneNumber = $data['phoneNumber'];
        $password = $data['Password'];

        try {

            $countryId = new guid();
            $countryId = $country;
            $ownerUserId = new guid();
            $ownerUserId = $owner_user_id_conf;

            $RealAccountRegistrationRequest = new RealAccountRegistrationRequest();
            $RealAccountRegistrationRequest->Password = $password;
            $RealAccountRegistrationRequest->AcceptTermsAndConditions = true;
            $RealAccountRegistrationRequest->TradingPlatformId = $trading_platform_id;
            $RealAccountRegistrationRequest->GroupName = $groupName;
            $RealAccountRegistrationRequest->CountryId = $countryId;
            $RealAccountRegistrationRequest->FirstName = $firstName;
            $RealAccountRegistrationRequest->LastName = $lastName;
            $RealAccountRegistrationRequest->PhoneCountryCode = $phoneCountryCode;
            $RealAccountRegistrationRequest->PhoneAreaCode = $phoneAreaCode;
            $RealAccountRegistrationRequest->PhoneNumber = $phoneNumber;
            $RealAccountRegistrationRequest->Email = $email;
            $RealAccountRegistrationRequest->LoggedInAccountId = $AccountId;
            $RealAccountRegistrationRequest->AdditionalInfo = new DynamicAttributeInfo();
            $RealAccountRegistrationRequest->EnvironmentInfo = new EnvironmentInfo();
            $RealAccountRegistrationRequest->MarketingInfo = new MarketingInfo();

            $RegisterRealAccount = new RegisterRealAccount();
            $RegisterRealAccount->ownerUserId = $ownerUserId;
            $RegisterRealAccount->organizationName = $this->config['organization'];
            $RegisterRealAccount->businessUnitName = $this->config['businessUnitName'];
            $RegisterRealAccount->realAccountRegistrationRequest = $RealAccountRegistrationRequest;

            $leverateCrm = getCrm($this->config);

            $registerRealAccountResponse = $leverateCrm->RegisterRealAccount($RegisterRealAccount);
            $result = $registerRealAccountResponse->RegisterRealAccountResult;


            $data['MainTradingAccountName'] = $result->TradingPlatformAccountName;
            $data['MainPlatformAccountType'] = $result->TradingPlatformAccountType;

            $result_return['Code'] = $result->Result->Code;
            $result_return['Message'] = $result->Result->Message;



            if ($result_return['Code'] == 'Success' || $result_return['Code'] == 'SuccessWithDuplicates') {
                //! Send Emails (portal+account) Action 3
                $this->email_service($data, 'additional_account_created');
                $result_return['Message'] = $result->Result->Message.' Trading Platform Account Name : '.$result->TradingPlatformAccountName;
            }
            $result = json_encode($result_return);
            return $result;

        } catch (Exception $e) {

            //!Case of Exception
            //!Custom Error Code 99 for our Integration
            $ResultInfo = new ResultInfo();
            $ResultInfo->Code = '99';
            $ResultInfo->Message = 'Error Occured While Create Additional Account';
            $result = json_encode((array)$ResultInfo);

            $error_log['service'] = 'create_additional_account';
            $error_log['request'] = json_encode((array)$RealAccountRegistrationRequest);
            $error_log['response'] = $e->getMessage();

            $this->log_error($error_log);

            return $result;
        }

    }

    private function get_trading_platform_group($platform_name,$base_currency=''){

        $sql="SELECT * FROM forex_groups where platform_name='$platform_name' AND currency_id='$base_currency';";

        return $this->execute_sql_select($sql);
    }

    private function execute_sql_select($sql){

        global $wpdb;
        $results = $wpdb->get_results($sql, ARRAY_A);

        if (!empty($results)) {
            return $results;
        } else {
            return false;
        }

    }


    public function register_real_account_1step($data)
    {

        //! Check if User Exist as Client in Portal
        $exist = $this->check_user_details($data['email']);

        if (empty($exist)) {
            $result['Code'] = '1';
            $result['Message'] = 'Duplicate Customer .Please login with your details .';
            $result = json_encode($result);
            return $result;
        }


        //!Check if is Lead in order to Convert it with Account ID
        if (empty($data['account_id'])) {

            $emaillead = $data['email'];
            $sql = "SELECT * FROM leads where email='$emaillead' and converted='0' ";
            $lead_data = execute_select($sql);
            if (!empty($lead_data))
                $data['account_id'] = $lead_data[0]['account_id'];
        }

        //!Configure the Group According to platform and Currency !//
        $platform_name=$data['platform'];
        $base_currency=$data['currencyId'];
        $trading_platform_id = $this->config['tradingPlatforms'][$platform_name]['id'];
        $groups=$this->get_trading_platform_group($platform_name,$base_currency);
        $groupName=$groups[0]['group_name'];
        //! End of this configuration !!//

        $owner_user_id_conf = $this->config['ownerUserId'];
        $convert_lead=(!empty($data['account_id'])?true:false);
        $AccountId = (!empty($data['account_id'])?$data['account_id']:'00000000-0000-0000-0000-000000000000');
        $email = $data['email'];
        $country = $data['countryId'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $phoneCountryCode = $data['phoneCountryCode'];
        $phoneAreaCode = ( isset($data['phoneAreaCode']) ? $data['phoneAreaCode'] : '0000') ;
        $phoneNumber = $data['phoneNumber'];
        $password = $data['Password'];

        try {

            $countryId = new guid();
            $countryId = $country;
            $ownerUserId = new guid();
            $ownerUserId = $owner_user_id_conf;

            $RealAccountRegistrationRequest = new RealAccountRegistrationRequest();
            $RealAccountRegistrationRequest->Password = $password;
            $RealAccountRegistrationRequest->AcceptTermsAndConditions = true;
            $RealAccountRegistrationRequest->TradingPlatformId = $trading_platform_id;
            $RealAccountRegistrationRequest->GroupName = $groupName;
            $RealAccountRegistrationRequest->CountryId = $countryId;
            $RealAccountRegistrationRequest->FirstName = $firstName;
            $RealAccountRegistrationRequest->LastName = $lastName;
            $RealAccountRegistrationRequest->PhoneCountryCode = $phoneCountryCode;
            $RealAccountRegistrationRequest->PhoneAreaCode = $phoneAreaCode;
            $RealAccountRegistrationRequest->PhoneNumber = $phoneNumber;
            $RealAccountRegistrationRequest->Email = $email;
            $RealAccountRegistrationRequest->LoggedInAccountId = $AccountId;
            $RealAccountRegistrationRequest->AdditionalInfo = new DynamicAttributeInfo();
            $RealAccountRegistrationRequest->EnvironmentInfo = new EnvironmentInfo();
            $RealAccountRegistrationRequest->MarketingInfo = new MarketingInfo();

            $RegisterRealAccount = new RegisterRealAccount();
            $RegisterRealAccount->ownerUserId = $ownerUserId;
            $RegisterRealAccount->organizationName = $this->config['organization'];
            $RegisterRealAccount->businessUnitName = $this->config['businessUnitName'];
            $RegisterRealAccount->realAccountRegistrationRequest = $RealAccountRegistrationRequest;


            $leverateCrm = getCrm($this->config);
            $registerRealAccountResponse = $leverateCrm->RegisterRealAccount($RegisterRealAccount);
            $result = $registerRealAccountResponse->RegisterRealAccountResult;

            $data['AccountId'] = $result->AccountId;
            $data['MainTradingAccountName'] = $result->TradingPlatformAccountName;
            $data['MainPlatformAccountType'] = $result->TradingPlatformAccountType;

            $result_return['Code'] = $result->Result->Code;
            $result_return['Message'] = $result->Result->Message;
            $result = json_encode($result_return);

            //!Create WP User for the Portal if we have success Registration
            if ($result_return['Code'] == 'Success') {

                //! Create WP user Action 1
                $this->create_wp_user($data);

                //! Login The Account Into System Action 2
                $this->login_user($email, $password);

                //! Send Emails (portal+account) Action 3
                $this->email_service($data, 'real_registration_email');

                if(!empty($convert_lead))
                    $this->execute_sql_update('leads',array('converted' =>'1'), array('email' => $email));

            }

            return $result;

        } catch (Exception $e) {

            //!Case of Exception
            //!Custom Error Code 99 for our Integration
            $ResultInfo = new ResultInfo();
            $ResultInfo->Code = '99';
            $ResultInfo->Message = 'Error Occured While Create Additional Account';
            $result = json_encode((array)$ResultInfo);

            $error_log['service'] = 'create_additional_account';
            $error_log['request'] = json_encode((array)$RealAccountRegistrationRequest);
            $error_log['response'] = $e->getMessage();

            $this->log_error($error_log);

            return $result;
        }

    }

    public function create_create_creditcard_deposit($email, $amount, $error_code, $data){

        $transaction=$this->get_transaction($data['merchantTransactionId'],'wp_payment_status');
        $tradingPlatformAccountId = $transaction[0]['tpaccount_id'];

        $amount = $data['amount'];



        try {

            $leverateCrm = getCrm($this->config);
            $info = new MonetaryTransactionRequestInfo();
            $info->Amount = $amount;
            $info->TradingPlatformAccountId = $tradingPlatformAccountId;
            $info->PaymentInfo = new CashPaymentInfo();
            $info->OriginalAmount = null;
            $info->OriginalCurrency = null;
            $dynamicAttributeInt = new DynamicAttributeInfo();
            $dynamicAttributeInt->Name = 'lv_withdrawalreason';
            $dynamicAttributeInt->DynamicAttributeType = 'Picklist';
            $dynamicAttributeInt->Value = new SoapVar(3, XSD_INT, "int", "http://www.w3.org/2001/XMLSchema");
            $dynamicAttributeString = new DynamicAttributeInfo();
            $dynamicAttributeString->Name = 'lv_internalcomment';
            $dynamicAttributeString->DynamicAttributeType = 'String';
            $dynamicAttributeString->Value = new SoapVar("some string", XSD_STRING, "string", "http://www.w3.org/2001/XMLSchema");
            $dynamicAttributeBit = new DynamicAttributeInfo();
            $dynamicAttributeBit->Name = 'lv_managementapproval';
            $dynamicAttributeBit->DynamicAttributeType = 'Bit';
            $dynamicAttributeBit->Value = new SoapVar(true, XSD_BOOLEAN, "boolean", "http://www.w3.org/2001/XMLSchema");
            $request = new DepositRequest();

            $request->IsCancellationTransaction =  $data['IsCancellationTransaction'] ;
            $request->ShouldAutoApprove = $data['ShouldAutoApprove'];
            $request->UpdateTPOnApprove = $data['UpdateTPOnApprove'];


            $request->MonetaryTransactionRequestInfo = $info;
            $request->AdditionalAttributes = array($dynamicAttributeInt, $dynamicAttributeString, $dynamicAttributeBit);
            $query = new CreateMonetaryTransaction();
            $query->ownerUserId = $this->config['ownerUserId'];
            $query->organizationName = $this->config['organization'];
            $query->businessUnitName = $this->config['businessUnitName'];
            $query->monetaryTransactionRequest = $request;
            $response = $leverateCrm->CreateMonetaryTransaction($query);

            $ResultInfo = new ResultInfo();
            $ResultInfo = $response->CreateMonetaryTransactionResult->Result;
            $result_return['Code'] = $ResultInfo->Code;
            $result_return['Message'] = $ResultInfo->Message;
            $result_return=json_encode($result_return);

            $error_log['service']='create_deposit';
            $error_log['request']=json_encode((array)$request);
            $error_log['response']=$result_return;

            $this->log_error($error_log);

            return $result_return;

        } catch (Exception $e) {

            //!Case of Exception
            //!Custom Error Code 99 for our Integration
            $result_return['Code'] = '99';
            $result_return['Message'] = 'Error while creating Deposit . Contact our Support Team ';
            $result = json_encode($result_return);

            $error_log['service']='create_additional_account';
            $error_log['request']=json_encode((array)$request);
            $error_log['response']=$e->getMessage();

            $this->log_error($error_log);

            return $result;
        }
    }

    private function get_transaction($id, $table_name)
    {
        global $wpdb;
        $true = $wpdb->get_results("select * FROM $table_name WHERE  transaction_id = '$id'", ARRAY_A);
        if (!empty($true)){
            return $true;
        } else {
            return true;
        }
    }

    public function login_user_with_tp_account($account_name,$password_2){


        $tradingPlatformAccountName = $account_name;
        $password = $password_2;

        try {

            $ownerUserId = new guid();
            $ownerUserId = $this->config['ownerUserId'];

            $loginAccount = new LoginAccount();
            $loginAccount->ownerUserId = $ownerUserId;
            $loginAccount->organizationName = $this->config['organization'];
            $loginAccount->businessUnitName = $this->config['businessUnitName'];
            $loginAccount->tradingPlatformAccountName = $tradingPlatformAccountName;
            $loginAccount->tradingPlatformAccountPassword = $password;

            $leverateCrm = getCrm($this->config);
            $loginAccountResponse = new LoginAccountResponse();
            $loginAccountResponse = $leverateCrm->LoginAccount($loginAccount);
            $loginResponse = $loginAccountResponse->LoginAccountResult;

            $ResultInfo = new ResultInfo();
            $ResultInfo = $loginResponse->Result;

            $result = $loginResponse->AccountId;
            $success = $ResultInfo->Code;
            $message = $ResultInfo->Message;

            if($success =='Success'){

                $AccountId=$loginResponse->AccountId;
                //!Get the user from Account ID
                $sql="SELECT email from customers where account_id='$AccountId'";
                $row=execute_select($sql);

                if(!empty($row)){
                    $email=$row[0]['email'];
                    $sql="SELECT * from wp_users where user_email='$email'";
                    $wp_user=execute_select($sql);

                    if (!empty($wp_user)) {
                        $this->authenticate_user($wp_user[0]['ID'], $wp_user[0]['user_email']);
                        $result_array['Code'] = 'Success';
                        $result_array['Message'] = '';
                        $result_json = json_encode($result_array);
                        return $result_json;
                    }
                }

            }else {
                $result_array['Code'] = '0';
                $result_array['Message'] = $message;
                $result_json = json_encode($result_array);
                return $result_json;
            }


    }catch (Exception $e) {

            //!Case of Exception
            //!Custom Error Code 99 for our Integration
            $result_return['Code'] = '99';
            $result_return['Message'] = 'Error Occured . Please try to resubmit.';
            $result_json = json_encode($result_return);

            $error_log['service']='authenticate_user_tp';
            $error_log['request']=json_encode((array)$loginAccount);
            $error_log['response']=$e->getMessage();

            $this->log_error($error_log);

            return $result_json;
        }

        $result_array['Code'] = '0';
        $result_array['Message'] = 'Authentication Failure. Incorrect Username or Password.';
        $result_json = json_encode($result_array);
        return $result_json;
}


    public  function authenticate_user($id, $name){

        if($id !=='1'&&! empty($id)) {
            $user = get_user_by("email", $name );
            wp_set_auth_cookie($user->ID);
            wp_set_current_user($id);
            wp_set_auth_cookie($id);
        }

    }
}
?>