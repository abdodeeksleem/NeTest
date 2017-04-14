<?php

/**
 * Created by PhpStorm.
 * User: andreas
 * Date: 15/12/2015
 * Time: 10:41 ΠΜ
 */

class email_generic {

    private $email_user_support;
    private $email_user_support_pass;
    private $email_user_noreply;
    private $email_user_noreply_pass;
    private $email_user_documents;
    private $email_admin_error;
    private $portal_url;
    private $Company_Name;
    private $trading_platfotrm_url;
    private $smtp_server;
    private $smtp_port;
    private $smtp_protocol;
    private $default_site_lang;


    function __construct() {

        $this->init();

    }

    private function init(){

        //!Get the options from Venture Plugin Settings
        global $wpdb;
        $table_name = 'wp_venture_plugin_settings';
        $option = $wpdb->get_results("select option_value FROM $table_name WHERE option_category='email'", ARRAY_A );
        $data=json_decode($option['0']['option_value'],true);

        $this->email_user_support=$data['email_user_support'];
        $this->email_user_support_pass=$data['email_user_support_pass'];
        $this->email_user_noreply=$data['email_user_noreply'];
        $this->email_user_noreply_pass=$data['email_user_noreply_pass'];
        $this->email_user_documents='andreash@medialink.com.cy';
        $this->email_admin_error='andreash@medialink.com.cy';
        $this->Company_Name=$data['company_name'];
        $this->trading_platfotrm_url=$data['platform_url'];
        $this->portal_url=$data['portal_url'];
        $this->smtp_port=$data['smtp_port'];
        $this->smtp_protocol=$data['smtp_protocol'];
        $this->smtp_server=$data['smtp_server'];
        $this->default_site_lang="ar";

    }


    public function send_welcome_lead_email($Data){

        $country= $Data["country"];
        $Email=$Data["email"];
        $FirstName=$Data["firstName"];
        $LastName=$Data["lastName"];

        //!Build the registration according to default language and user registration page
        if($this->default_site_lang!==$Data['reg_lang'])
            $url_register=$Data['refg_lang']."/registration?id=".$Data['AccountId'];
        else
            $url_register="registration?id=".$Data['AccountId'];

        //we are going to handle it as text-html format
        $template = file_get_contents($_SERVER ['DOCUMENT_ROOT'] . '/wp-content/plugins/Venture/Email/email_templates/lead_welcome_tpl_' . $country . '.tpl');

        if (empty($template)) {
            $template = file_get_contents($_SERVER ['DOCUMENT_ROOT'] .'/wp-content/plugins/Venture/Email/email_templates/lead_welcome_tpl_EN.tpl');
        }

        $template = str_replace('{$customer->FirstName}', $FirstName, $template);
        $template = str_replace('{$customer->LastName}', $LastName, $template);
        $template = str_replace('{$customer->email}', $Email, $template);
        $template = str_replace('{$customer->portalsite}', $this->portal_url, $template);
        $template = str_replace('{$customer->portalsite_name}', $this->Company_Name, $template);
        $template = str_replace('{$customer->support_email}', $this->email_user_support, $template);
        $template = str_replace('{$customer->portal_registration}', $this->portal_url.$url_register, $template);


        //!Prepare the necessary details
        $email_data['email_from']=$this->email_user_noreply;
        $email_data['email_pass']=$this->email_user_noreply_pass;
        $email_data['template']=$template;
        $email_data['email_to']=$Email;
        $email_data['subject']='Lead confirmation in '.$this->Company_Name;
        //!Calling the swift transport
        $this->send_email($email_data);

    }

    /**
     * @param $Data
     * Send Welcome Email on Portal User Creation
     */


    public function send_welcome_email($Data){

        $country= $Data["country"];
        $Email=$Data["email"];
        $FirstName=$Data["firstName"];
        $LastName=$Data["lastName"];
        $Password=$Data["Password"];

        //we are going to handle it as text-html format
        $template = file_get_contents($_SERVER ['DOCUMENT_ROOT'] . '/wp-content/plugins/Venture/Email/email_templates/welcome_tpl_' . $country . '.tpl');

        if (empty($template)) {
            $template = file_get_contents($_SERVER ['DOCUMENT_ROOT'] .'/wp-content/plugins/Venture/Email/email_templates/welcome_tpl_EN.tpl');
        }

        $template = str_replace('{$customer->FirstName}', $FirstName, $template);
        $template = str_replace('{$customer->LastName}', $LastName, $template);
        $template = str_replace('{$customer->email}', $Email, $template);
        $template = str_replace('{$customer->password}', $Password, $template);
        $template = str_replace('{$customer->portalsite}', $this->portal_url, $template);
        $template = str_replace('{$customer->portalsite_name}', $this->Company_Name, $template);
        $template = str_replace('{$customer->support_email}', $this->email_user_support, $template);

        //!Prepare the necessary details
        $email_data['email_from']=$this->email_user_noreply;
        $email_data['email_pass']=$this->email_user_noreply_pass;
        $email_data['template']=$template;
        $email_data['email_to']=$Email;
        $email_data['subject']='Thank You For Registering '.$this->Company_Name;

        //!Calling the swift transport
        $this->send_email($email_data);

    }


    public function send_TPAccount_email($data){

        $Email=$data['email'];
        $AccountId=$data['MainTradingAccountName'];
        $AccounPassword=$data['Password'];
        $Firstname=$data['firstName'];
        $LastName=$data['lastName'];

        //we are going to handle it as text-html format
        $template = file_get_contents($_SERVER ['DOCUMENT_ROOT'] . '/wp-content/plugins/Venture/Email/email_templates/TPaccount_creation.tpl');

        $template = str_replace('{$customer->email}', $Email, $template);
        $template = str_replace('{$customer->AccountId}', $AccountId, $template);
        $template = str_replace('{$customer->AccountPassword}', $AccounPassword, $template);
        $template = str_replace('{$customer->FirstName}', $Firstname, $template);
        $template = str_replace('{$customer->LastName}', $LastName, $template);
        $template = str_replace('{$customer->Platform_Url}', $this->trading_platfotrm_url, $template);
        $template = str_replace('{$customer->website_url}', $this->portal_url, $template);
        $template = str_replace('{$customer->support_email}', $this->email_user_support, $template);
        $template = str_replace('{$customer->website_name}', $this->Company_Name, $template);


        //!Prepare the necessary details
        $email_data['email_from']=$this->email_user_noreply;
        $email_data['email_pass']=$this->email_user_noreply_pass;
        $email_data['template']=$template;
        $email_data['email_to']=$Email;
        $email_data['subject']='Your Trading platform Account Created Successfully';


        //!Calling the swift transport
        $this->send_email($email_data);
    }




    public function send_forgot_email($Data){

        $Email=$Data["email"];
        $FirstName=$Data["firstName"];
        $LastName=$Data["lastName"];
        $token=$Data["token"];

        //we are going to handle it as text-html format
        $template = file_get_contents($_SERVER ['DOCUMENT_ROOT'] . '/wp-content/plugins/Venture/Email/email_templates/forgot_password.tpl');

        $template = str_replace('{$customer->FirstName}', $FirstName, $template);
        $template = str_replace('{$customer->LastName}', $LastName, $template);
        $template = str_replace('{$customer->email}', $Email, $template);
        $template = str_replace('{$customer->hash}', $token, $template);
        $template = str_replace('{$customer->website_url}', $this->portal_url, $template);
        $template = str_replace('{$customer->portalsite_name}', $this->Company_Name, $template);
        $template = str_replace('{$customer->support_email}', $this->email_user_support, $template);

        //!Prepare the necessary details
        $email_data['email_from']=$this->email_user_noreply;
        $email_data['email_pass']=$this->email_user_noreply_pass;
        $email_data['template']=$template;
        $email_data['email_to']=$Email;
        $email_data['subject']='Request for Forgot Password';

        //!Calling the swift transport
        $this->send_email($email_data);

    }


    public function send_docs_notification_email($data){


        $email=$data['email'];
        $AccountId=$data['AccountId'];
        $AccounPassword=$data['Password'];
        $Firstname=$data['firstName'];
        $LastName=$data['lastName'];

        //we are going to handle it as text-html format
        $template = file_get_contents($_SERVER ['DOCUMENT_ROOT'] . '/wp-content/plugins/Venture/Email/email_templates/notification_docs_email.tpl');

        $template = str_replace('{$customer->email}', $email, $template);
        $template = str_replace('{$customer->AccountId}', $AccountId, $template);
        $template = str_replace('{$customer->AccountPassword}', $AccounPassword, $template);
        $template = str_replace('{$customer->FirstName}', $Firstname, $template);
        $template = str_replace('{$customer->LastName}', $LastName, $template);

        //!Prepare the necessary details
        $email_data['email_from']=$this->email_user_noreply;
        $email_data['email_pass']=$this->email_user_noreply_pass;
        $email_data['template']=$template;
        $email_data['email_to']=$this->email_user_documents;
        $email_data['file_path']=$data['tmp_path'];
        $email_data['file_name']= $data['file_name'];
        $email_data['subject']='User with email : ' .$email . ' upload document .';

        //!Calling the swift transport
        $this->send_email($email_data);

    }


    public function send_test_email($data){

        $template = file_get_contents($_SERVER ['DOCUMENT_ROOT'] . '/wp-content/plugins/Venture/Email/email_templates/test_email_settings.tpl');

        $template = str_replace('{$customer->portalsite_name}', $this->Company_Name, $template);
        $template = str_replace('{$customer->website_url}', $this->portal_url, $template);
        $template = str_replace('{$customer->Platform_Url}', $this->trading_platfotrm_url, $template);
        $template = str_replace('{$customer->support_email}', $this->email_user_support, $template);
        //!Prepare the necessary details
        $email_data['email_from']=$this->email_user_noreply;
        $email_data['email_pass']=$this->email_user_noreply_pass;
        $email_data['template']=$template;
        $email_data['email_to']=$data['email_to_test'];
        $email_data['subject']='Test Email Configuration Settings';

        //!Calling the swift transport
        $this->send_email($email_data);

    }

    public function send_deposit_notification_mail($data2,$data){

        //!Check crm status

        if(in_array($data2['http_code'],array('Success'))){

            $crm_details='Deposit was succesfully created on your CRM with Status : '. $data2['deposit_status'];

        }else{
            $crm_details='Deposit was not created on your CRM because the status from PSP was failed';
        }

        $array=json_decode($data,true);
        $table_html= '<table style="background-color: #fff; color: #555555; font-family: Arial; font-weight: normal; font-size: 12px; width: 600px; margin: 20px auto; border: 1px solid #7d95af; border-collapse: collapse;text-align: center " cellpadding="0" cellspacing="0"><caption>Transaction Details</caption> <tbody>';
        $table_html=$table_html.  '<tr>';
        $table_html=$table_html.  '<td>Solid Transaction id</td>';
        $table_html=$table_html.  '<td>Payment Type</td>';
        $table_html=$table_html.  '<td>Payment Brand</td>';
        $table_html=$table_html.  '<td>Amount</td>';
        $table_html=$table_html.  '<td>Currency</td>';
        $table_html=$table_html.  '<td>Merchant Transaction Id</td>';
        $table_html=$table_html.  '</tr>';
        $table_html=$table_html.  '<tr>';
        $table_html=$table_html.  '<td>' . $array['id'] . '</td>';
        $table_html=$table_html.  '<td>' . $array['paymentType'] . '</td>';
        $table_html=$table_html.  '<td>' . $array['paymentBrand'] . '</td>';
        $table_html=$table_html.  '<td>' . $array['amount'] . '</td>';
        $table_html=$table_html.  '<td>' . $array['currency'] . '</td>';
        $table_html=$table_html.  '<td>' . $array['merchantTransactionId'] . '</td>';
        $table_html=$table_html.  '</tr>';
        $table_html=$table_html.  ' </tbody></table> ';

        $table_html=$table_html.  '<table style="background-color: #fff; color: #555555; font-family: Arial; font-weight: normal; font-size: 12px; width: 600px; margin: 20px auto; border: 1px solid #7d95af; border-collapse: collapse;text-align: center " cellpadding="0" cellspacing="0"><caption>Solid Payments Result</caption><tbody>';
        $row=$array['result'] ;
        $table_html=$table_html.  '<tr>';
        $table_html=$table_html.  '<td>Code</td>';
        $table_html=$table_html.  '<td>Description</td>';
        $table_html=$table_html.  '</tr>';
        $table_html=$table_html.  '<tr>';
        $table_html=$table_html.  '<td>' . $row['code'] . '</td>';
        $table_html=$table_html.  '<td>' . $row['description'] . '</td>';
        $table_html=$table_html.  '</tr>';
        $table_html=$table_html.  '  </tbody></table>';


        $table_html=$table_html.  '<table style="background-color: #fff; color: #555555; font-family: Arial; font-weight: normal; font-size: 12px; width: 600px; margin: 20px auto; border: 1px solid #7d95af; border-collapse: collapse;text-align: center " cellpadding="0" cellspacing="0"><caption>Customer Details</caption><tbody>';
        $row=$array['customer'] ;
        $table_html=$table_html.  '<tr>';
        $table_html=$table_html.  '<td>Name</td>';
        $table_html=$table_html.  '<td>Surname</td>';
        $table_html=$table_html.  '<td>Email</td>';
        $table_html=$table_html.  '<td>Ip</td>';
        $table_html=$table_html.  '</tr>';
        $table_html=$table_html.  '<tr>';
        $table_html=$table_html.  '<td>' . $row['givenName'] . '</td>';
        $table_html=$table_html.  '<td>' . $row['surname'] . '</td>';
        $table_html=$table_html.  '<td>' . $row['email'] . '</td>';
        $table_html=$table_html.  '<td>' . $row['ip'] . '</td>';
        $table_html=$table_html.  '</tr>';
        $table_html=$table_html.  '  </tbody></table>';

        $table_html=$table_html.  '<table style="background-color: #fff; color: #555555; font-family: Arial; font-weight: normal; font-size: 12px; width: 600px; margin: 20px auto; border: 1px solid #7d95af; border-collapse: collapse;text-align: center " cellpadding="0" cellspacing="0"><caption>Solid Risk Code</caption><tbody>';
        $row=$array['risk'] ;
        $table_html=$table_html.  '<tr>';
        $table_html=$table_html.  '<td>score</td>';
        $table_html=$table_html.  '</tr>';
        $table_html=$table_html.  '<tr>';
        $table_html=$table_html.  '<td>' . $row['score'] . '</td>';
        $table_html=$table_html.  '</tr>';
        $table_html=$table_html.  ' </tbody></table>';

        $table_html=$table_html.  '<table style="background-color: #fff; color: #555555; font-family: Arial; font-weight: normal; font-size: 12px; width: 600px; margin: 20px auto; border: 1px solid #7d95af; border-collapse: collapse;text-align: center " cellpadding="0" cellspacing="0"><caption>CRM Status</caption><tbody>';
        $table_html=$table_html.  '<tr>';
        $table_html=$table_html.  '<td>Status Description</td>';
        $table_html=$table_html.  '</tr>';
        $table_html=$table_html.  '<tr>';
        $table_html=$table_html.  '<td>' . $crm_details . '</td>';
        $table_html=$table_html.  '</tr>';
        $table_html=$table_html.  ' </tbody></table>';


        $template = file_get_contents($_SERVER ['DOCUMENT_ROOT'] . '/wp-content/plugins/Venture/Email/email_templates/deposit_notification.tpl');
        $template = str_replace('{$customer->deposit_details}', $table_html, $template);


        $template = str_replace('{$customer->portalsite}', $data2['portal_site'], $template);
        $template = str_replace('{$customer->portalsite_name}', $data2['portal_site'], $template);
        $template = str_replace('{$customer->crmstatus}', $crm_details, $template);
        $template = str_replace('{$customer->firstname}', $data2['firstname'], $template);
        $template = str_replace('{$customer->lastname}', $data2['lastname'], $template);
        $template = str_replace('{$customer->email}', $data2['email'], $template);

        //!Prepare the necessary details
        $email_data['email_from']=$this->email_user_noreply;
        $email_data['email_pass']=$this->email_user_noreply_pass;
        $email_data['template']=$template;
        $email_data['email_to']= $this->email_admin_error;
        $email_data['subject']='Deposit Notification ';

        //!Calling the swift transport
        $this->send_email($email_data);
    }




    private function send_email($email_data){

        try {

            require_once($_SERVER ['DOCUMENT_ROOT'] . '/wp-content/plugins/Venture/Email/swiftmailer/lib/swift_required.php');
            $transport = Swift_SmtpTransport::newInstance($this->smtp_server, $this->smtp_port, $this->smtp_protocol)
                ->setUsername($email_data['email_from'])
                ->setPassword($email_data['email_pass']);

            // Create the Mailer using your created Transport
            $mailer = Swift_Mailer::newInstance($transport);

            // Create the message
            $message = Swift_Message::newInstance()
                // Give the message a subject
                ->setSubject($email_data['subject'])

                // Set the From address with an associative array
                ->setFrom(array($email_data['email_from'] => $this->Company_Name))
                // Set the To addresses with an associative array
                //! We need to add the email that customer fill in the form

                //!Testing Email!//
                //->setTo(array($email_data['email_to']))
                ->setTo(array($email_data['email_to']))

                // Give it a body
                ->setBody($email_data['template'], 'text/html');

            // Optionally add any attachments
            if (isset($email_data['file_path'])&& !empty($email_data['file_path'])) {
                $message->attach(Swift_Attachment::fromPath($email_data['file_path'])
                    ->setFilename($email_data['file_name']));
            }

            // Send the message
            $result = $mailer->send($message);

            //!Also result need to be updated in our systems in order to know if the email was send correctly!/


            //! We will catch the email when something is wrong on exception  . !//
        }catch ( Exception $e ) {
            $message_error = $e->getMessage ();
            //!Set the Error on Database or Log file

        }

    }
}