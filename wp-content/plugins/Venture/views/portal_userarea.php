
<div id="tabs">
<ul class="columns four">
    <li><a href="#account-info"><?php echo __("Account Information","form")?></a></li>
    <li><a class="link-docs"  href="#documents"><?php echo __("Upload your Documents","form")?></a></li>
    <li><a href="#forgot-password"><?php echo __("Forgot Trading Platform Account Password","form")?></a></li>
    <li><a href="#reset-password"><?php echo __("Reset Trading Platform Account Password","form")?></a></li>
    <li><a href="#trading-accounts"><?php echo __("Trading Accounts","form")?></a></li>
    <li><a href="#trading-history"><?php echo __("Get trading history","form")?></a></li>
    <li><a href="#withdrawal"><?php echo __("Withdrawal","form")?></a></li>
    <li><a href="#deposit"><?php echo __("Deposit Funds","form")?></a></li>
    <li><a href="#request-additional-account"><?php echo __("Request Additional Account","form")?></a></li>
    <li><a class="ex-link" href="/trade"><?php echo __("Trade Now","form")?></a></li>
</ul>

<div id="account-info" class="columns eight">

    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" name="userinformation-form" id="userinformation-form" autocomplete="off">
                <div class="form-title"><?php echo __("Account Information","form")?></div>
                <div id="accountinfo" class="error-wrap"></div>
                <div class="form-group">
                    <label for="inputUserName" class="columns four control-label"><?php echo __("First Name","form")?></label>
                    <div class="columns eight">
                        <input type="text" class="form-control" id="inputUserName" name="first_name" value="<?php echo $data['first_name']?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputUserLastName" class="columns four control-label"><?php echo __("Last Name","form")?></label>
                    <div class="columns eight">
                        <input type="text" class="form-control" id="inputUserLastName" name="last_name" value="<?php echo $data['last_name']?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputUserEmail" class="columns four control-label"><?php echo __("Email","form")?></label>
                    <div class="columns eight">
                        <input type="email" class="form-control" id="inputUserEmail" name="email" readonly="readonly" value="<?php echo $data['email']?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputUserAddress1" class="columns four control-label"><?php echo __("Main Address","form")?></label>
                    <div class="columns eight">
                        <input type="text" class="form-control" id="inputUserAddress1" name="address1" value="<?php echo $data['address1']?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputUserAddress2" class="columns four control-label"><?php echo __("Alternative Address","form")?></label>
                    <div class="columns eight">
                        <input type="text" class="form-control" id="inputUserAddress2" name="address2" value="<?php echo $data['address2']?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputUserCity" class="columns four control-label"><?php echo __("City","form")?></label>
                    <div class="columns eight">
                        <input type="text" class="form-control" id="inputUserCity" name="city" value="<?php echo $data['city']?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputUserCity" class="columns four control-label"><?php echo __("State","form")?></label>
                    <div class="columns eight">
                        <input type="text" class="form-control" id="inputUserState" name="state" value="<?php echo $data['state']?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputUserZipCode" class="columns four control-label"><?php echo __("Zip Code","form")?></label>
                    <div class="columns eight">
                        <input type="text" class="form-control" id="inputUserZipCode" name="post_code" value="<?php echo $data['post_code']?>" />
                    </div>
                </div>


                <div class="form-group">
                    <label for="countryId" class="columns four control-label"><?php echo __("Country","form")?></label>
                    <div class="columns eight">
                        <select id="countryId" name="countryId" class="form-control">
                            <?php foreach ($countries as $country): ?>
                                <option value="<?php echo $country->Id;?>"><?php echo $country->Name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputUserPhoneCode" class="columns four control-label"><?php echo __("Phone code","form")?></label>
                    <div class="columns eight">
                        <input type="text" class="form-control" id="inputUserPhoneCode" name="phone_ccode" value="<?php echo $data['phone_ccode']?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputUserPhone" class="columns four control-label"><?php echo __("Phone Number","form")?></label>
                    <div class="columns eight">
                        <input type="text" class="form-control" id="inputUserPhone" name="phone_number" value="<?php echo $data['phone_number']?>" />
                    </div>
                </div>

                <input type="hidden" id="user_country_id" name="user_country_id" value="<?php echo $data['country']?>" />
                <input type="hidden" id="account_id" name="account_id" value="<?php echo $data['account_id']?>" />

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                        <button type="submit" id="userinformation-btn" name="submit" class="btn btn-default" value="edit-userinformation"><?php echo __("Update","form")?></button>
                        <div class="col-sm-offset-3 col-sm-10 ajax_loader"></div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<div id="documents" class="columns eight">
    <div class="panel panel-default">
        <div class="panel-body">
            <p>
                <?php echo __("In order to complete your registration you have to provide a proof of address and id or passport documents .
                Note that documents must be clear and translated to english language.","form")?>
            </p>
            <form action="/upload-document/" class="dropzone form-horizontal" id="my-dropzone" >
                <div class="panel panel-default columns twelve">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="inputDocumentType" class="columns four control-label"><?php echo __("Choose The Type of your Document before you Upload","form")?></label>
                            <div class="columns eight">
                                <select id="inputDocumentType" name="document_type" class="form-control">
                                    <option value="Passport"><?php echo __("Passport","form")?></option>
                                    <option value="Identity"><?php echo __("Identity","form")?></option>
                                    <option value="Proof of Address"><?php echo __("Proof of Address","form")?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <table id="docs_table" border="0" cellspacing="1" cellpadding="1">
            </table>
        </div>
    </div>
</div>

<div id="forgot-password" class="columns eight">
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" name="forgot-tpaccount-password" id="forgot-tpaccount-password" autocomplete="off">
                <div class="form-title"><?php echo __("Forgot Password","form")?></div>
                <div id="forgotmsg" class="error-wrap"></div>
                <div class="form-group">
                    <label for="inputTradingPlatformAccountName" class="columns four control-label"><?php echo __("Choose your Trading platform account","form")?></label>
                    <div class="columns eight">
                        <select id="inputTradingPlatformAccountName" name="TradingPlatformAccountName" class="form-control">
                            <?php foreach($accountsinfo as $account){
                                if($account->AccountType->Name!=="Lead")

                                    foreach($account->TradingPlatformAccounts as $tpaccountinfo){
                                        if(is_numeric($tpaccountinfo->Name)){?>
                                            <option value="<?php echo $tpaccountinfo->Name;?>"><?php echo $tpaccountinfo->Name; ?></option><?php
                                            $account=true;
                                        }
                                    }
                                if(isset($account)&&!empty($account))
                                    foreach($account->TradingPlatformAccounts->TradingPlatformAccountInfo as $tpaccountinfo):?>
                                        <option value="<?php echo $tpaccountinfo->Name;?>"><?php echo $tpaccountinfo->Name; ?></option>
                                    <?php endforeach;
                            }?>
                        </select>
                    </div>
                </div>

                <input type="hidden" id="email_forgot" name="email_forgot" value="<?php echo $data['email']?>" />

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                        <button type="submit" class="btn btn-default" name="submit" id="forgot-tpaccount-btn" value="forgot_tpaccount_password"><?php echo __("Submit","form")?></button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<div id="reset-password" class="columns eight">
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" name="reset-tpaccount-password" id="reset-tpaccount-password" autocomplete="off">
                <div class="form-title"><?php echo __("Reset Password","form")?></div>
                <div id="resetmsg" class="error-wrap"></div>
                <div class="form-group">
                    <label for="inputTradingPlatformAccountName" class="columns four control-label"><?php echo __("Choose your Trading platform account","form")?></label>
                    <div class="columns eight">
                        <select id="inputTradingPlatformAccountName" name="TradingPlatformAccountName" class="form-control">
                            <?php foreach($accountsinfo as $account){
                                if($account->AccountType->Name!=="Lead")

                                    foreach($account->TradingPlatformAccounts as $tpaccountinfo){
                                        if(is_numeric($tpaccountinfo->Name)){?>
                                            <option value="<?php echo $tpaccountinfo->Name;?>"><?php echo $tpaccountinfo->Name; ?></option><?php
                                            $account=true;
                                        }
                                    }
                                if(isset($account)&&!empty($account))
                                    foreach($account->TradingPlatformAccounts->TradingPlatformAccountInfo as $tpaccountinfo):?>
                                        <option value="<?php echo $tpaccountinfo->Name;?>"><?php echo $tpaccountinfo->Name; ?></option>
                                    <?php endforeach;
                            }?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword" class="columns four control-label"><?php echo __("Old Password","form")?></label>
                    <div class="columns eight">
                        <input type="password" class="form-control" id="oldPassword" name="oldPassword" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="columns four control-label"><?php echo __("New Password","form")?></label>
                    <div class="columns eight">
                        <input type="password" class="form-control" id="newPassword" name="newPassword" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                        <button type="submit" class="btn btn-default" name="submit" id="reset-tpaccount-btn" value="reset_tpaccount_password"><?php echo __("Submit","form")?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="trading-accounts" class="columns eight">
    <table id="trading_accounts_table" class="panel-table">
        <thead>
        <tr>
            <td><?php echo __("Account Number","form")?></td>
            <td><?php echo __("Account Currency","form")?></td>
            <td><?php echo __("Account Type","form")?></td>
        </tr>
        </thead>

        <?php foreach($accountsinfo as $account){
            if($account->AccountType->Name!=="Lead")
                foreach($account->TradingPlatformAccounts as $tpaccountinfo){
                    if(is_numeric($tpaccountinfo->Name)){?>
                        <tr><td><?php echo $tpaccountinfo->Name?></td>
                        <td><?php echo $tpaccountinfo->BaseCurrency->Code;?></td>
                        <td><?php echo ((strpos($tpaccountinfo->TradingPlatform->Name,'SIRIX') !== false)?$tpaccountinfo->TradingPlatform->Type.'-SIRIX':$tpaccountinfo->TradingPlatform->Type.'-MT') ;?></td>
                        </tr><?php
                        $account=true;
                    }
                }
            if(isset($account)&&!empty($account))
                foreach($account->TradingPlatformAccounts->TradingPlatformAccountInfo as $tpaccountinfo):?>
                    <tr><td><?php echo $tpaccountinfo->Name?></td>
                        <td><?php echo $tpaccountinfo->BaseCurrency->Code;?></td>
                        <td><?php echo ((strpos($tpaccountinfo->TradingPlatform->Name,'SIRIX') !== false)?$tpaccountinfo->TradingPlatform->Type.'-SIRIX':$tpaccountinfo->TradingPlatform->Type.'-MT') ;?></td>
                    </tr>
                <?php endforeach;
        }?>
    </table>
</div>

<div id="trading-history" class="columns eight">
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" name="get-tpaccount-history" id="get-tpaccount-history" autocomplete="off">
                <div class="form-group">
                    <div class="form-title"><?php echo __("Get Trading History","form")?></div>
                    <div id="historymsg" class="error-wrap"></div>
                    <label for="inputTradingPlatformAccountName" class="columns four control-label"><?php echo __("Choose your Trading platform account","form")?></label>
                    <div class="columns eight">
                        <select id="inputTradingPlatformAccountName" name="TradingPlatformAccountName" class="form-control">
                            <?php foreach($accountsinfo as $account){
                                if($account->AccountType->Name!=="Lead")

                                    foreach($account->TradingPlatformAccounts as $tpaccountinfo){
                                        if(is_numeric($tpaccountinfo->Name)){?>
                                            <option value="<?php echo $tpaccountinfo->Id;?>"><?php echo $tpaccountinfo->Name; ?></option><?php
                                            $account=true;
                                        }
                                    }
                                if(isset($account)&&!empty($account))
                                    foreach($account->TradingPlatformAccounts->TradingPlatformAccountInfo as $tpaccountinfo):?>
                                        <option value="<?php echo $tpaccountinfo->Id;?>"><?php echo $tpaccountinfo->Name; ?></option>
                                    <?php endforeach;
                            }?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputHistoryStart" class="columns four control-label"><?php echo __("From Date","form")?></label>
                    <div class="columns eight">
                        <input type="date" class="form-control" id="inputHistoryStart" name="start_date_history" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputHistoryEnd" class="columns four control-label"><?php echo __("To Date","form")?></label>
                    <div class="columns eight">
                        <input type="date" class="form-control" id="inputHistoryEnd" name="end_date_history" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                        <button type="submit" class="btn btn-default" name="submit" id="gethistory-tpaccount-btn" value="get_tpaccount_history"><?php echo __("Submit","form")?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table id="records_table" class="panel-table"></table>
</div>

<div id="withdrawal" class="columns eight">
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" name="create-withdrawal" id="create-withdrawal" autocomplete="off">
                <div class="form-group">
                    <div class="form-title"><?php echo __("Withdrawal Funds","form")?></div>
                    <div id="withdrawalmsg" class="error-wrap"></div>
                    <label for="inputTradingPlatformAccountName" class="columns four control-label"><?php echo __("Choose your Trading platform account","form")?></label>
                    <div class="columns eight">
                        <select id="inputTPAccountNameWithdrawal" name="TPaccountNameWithdrawal" class="form-control">
                            <?php
                            foreach($accountsinfo as $account){
                                if($account->AccountType->Name!=="Lead")

                                    foreach($account->TradingPlatformAccounts as $tpaccountinfo){
                                        if(is_numeric($tpaccountinfo->Name)&&($tpaccountinfo->TradingPlatform->Type!=='Demo')){?>
                                            <option value="<?php echo $tpaccountinfo->Id;?>"><?php echo $tpaccountinfo->Name.'|'.$tpaccountinfo->BaseCurrency->Code; ; ?></option><?php
                                            $account=true;
                                        }
                                    }
                                if(isset($account)&&!empty($account))
                                    foreach($account->TradingPlatformAccounts->TradingPlatformAccountInfo as $tpaccountinfo) {
                                        if (($tpaccountinfo->TradingPlatform->Type !== 'Demo')) {?>
                                            <option value="<?php echo $tpaccountinfo->Id; ?>"><?php echo $tpaccountinfo->Name.'|'.$tpaccountinfo->BaseCurrency->Code; ; ?></option>
                                        <?php
                                        }
                                    }
                            }?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAmount" class="columns four control-label"><?php echo __("Amount to Withdrawal","form")?></label>
                    <div class="columns eight">
                        <input type="text" class="form-control" id="inputAmount" name="amount" />
                    </div>
                </div>
                <!--                <div class="form-group">-->
                <!--                    <label for="currencyId" class="columns four control-label">--><?php //echo __("Currency","form")?><!--</label>-->
                <!--                    <div class="columns eight">-->
                <!--                        <select name="currencyId" class="form-control">-->
                <!--                            --><?php //foreach ($currencies as $currency): ?>
                <!--                                <option value="--><?php //echo $currency->Id;?><!--">--><?php //echo $currency->Name; ?><!--</option>-->
                <!--                            --><?php //endforeach; ?>
                <!--                        </select>-->
                <!--                    </div>-->
                <!--                </div>-->
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                        <button type="submit" class="btn btn-default" name="submit" id="create-withdrawal-btn" value="create_withdrawal"><?php echo __("Submit","form")?></button>
                        <div class="col-sm-offset-3 col-sm-10 ajax_loader"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="deposit" class="columns eight">
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" name="create-deposit" id="create-deposit" autocomplete="off">
                <div class="form-group">
                    <div class="form-title">Deposit Funds</div>
                    <div id="depositmsg" class="error-wrap"></div>
                    <label for="inputTPAccountNameDeposit" class="columns four control-label"><?php echo __("Choose your Trading platform account","form")?></label>
                    <div class="columns eight">
                        <select id="inputTPAccountNameDeposit" name="inputTPAccountNameDeposit" class="form-control">
                            <?php foreach($accountsinfo as $account){
                                if($account->AccountType->Name!=="Lead")

                                    foreach($account->TradingPlatformAccounts as $tpaccountinfo){
                                        if(is_numeric($tpaccountinfo->Name)&&($tpaccountinfo->TradingPlatform->Type =='Real')){?>
                                            <option value="<?php echo $tpaccountinfo->Name.'|'.$tpaccountinfo->BaseCurrency->Code.'|'.$tpaccountinfo->Id;?>"><?php echo $tpaccountinfo->Name.'|'.$tpaccountinfo->BaseCurrency->Code; ?></option><?php
                                            $account=true;
                                        }
                                    }
                                if(isset($account)&&!empty($account))
                                    foreach($account->TradingPlatformAccounts->TradingPlatformAccountInfo as $tpaccountinfo) {
                                        if (($tpaccountinfo->TradingPlatform->Type == 'Real')) {
                                            ?>
                                            <option value="<?php echo $tpaccountinfo->Name . '|' . $tpaccountinfo->BaseCurrency->Code . '|' . $tpaccountinfo->Id; ?>"><?php echo $tpaccountinfo->Name . '|' . $tpaccountinfo->BaseCurrency->Code; ?></option>
                                        <?php
                                        }
                                    }
                            }?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAmountDeposit" class="columns four control-label"><?php echo __("Amount to Deposit","form")?></label>
                    <div class="columns eight">
                        <input type="text" class="form-control" id="inputAmountDeposit" name="AmountDeposit" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputUserEmail" class="columns four control-label"><?php echo __("Email","form")?></label>
                    <div class="columns eight">
                        <input type="email" class="form-control" id="inputUserEmail" name="email" readonly="readonly" value="<?php echo $data['email']?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputUserAddress1Deposit" class="columns four control-label"><?php echo __("Main Address","form")?></label>
                    <div class="columns eight">
                        <input type="text" class="form-control" id="inputUserAddress1Deposit" name="address1Deposit" value="<?php echo $data['address1']?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputUserCityDeposit" class="columns four control-label"><?php echo __("City","form")?></label>
                    <div class="columns eight">
                        <input type="text" class="form-control" id="inputUserCityDeposit" name="cityDeposit" value="<?php echo $data['city']?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputUserCityDeposit" class="columns four control-label"><?php echo __("State","form")?></label>
                    <div class="columns eight">
                        <input type="text" class="form-control" id="inputUserStateDeposit" name="stateDeposit" value="<?php echo $data['state']?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputUserZipCodeDeposit" class="columns four control-label"><?php echo __("Zip Code","form")?></label>
                    <div class="columns eight">
                        <input type="text" class="form-control" id="inputUserZipCodeDeposit" name="post_codeDeposit" value="<?php echo $data['post_code']?>" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="columns twelve">
                        <p  class="form-control" style="text-align:center" > <?php echo __("Your Credit card will be charged by PS*ettemad.com, support number: +","form")?></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                        <button type="submit" class="btn btn-default" name="submit" id="create-deposit-btn" value="create_deposit"><?php echo __("Next Step","form")?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="request-additional-account" class="columns eight">
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" name="additional-account" id="additional-account" autocomplete="off">
                <div class="form-title"><?php echo __("Request Additional Account","form")?></div>
                <div id="additionalmsg" class="error-wrap"></div>
                <div class="form-group">
                    <label for="inputEmail" class="columns five control-label"><?php echo __("Email","form")?></label>
                    <div class="columns seven">
                        <input type="email" class="form-control" id="inputEmail" name="email" readonly="readonly"  value="<?php echo $data['email']?>"  />
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="columns five control-label"><?php echo __("Password","form")?></label>
                    <div class="columns seven">
                        <input type="password" class="form-control" id="inputPassword" name="Password" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputFirstName" class="columns five control-label"><?php echo __("First name","form")?></label>
                    <div class="columns seven">
                        <input type="text" class="form-control" id="inputFirstName" name="firstName" value="<?php echo $data['first_name']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputLastName" class="columns five control-label"><?php echo __("Last name","form")?></label>
                    <div class="columns seven">
                        <input type="text" class="form-control" id="inputLastName" name="lastName" value="<?php echo $data['last_name']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="countryId" class="columns five control-label"><?php echo __("Country","form")?></label>
                    <div class="columns seven">
                        <select name="countryId" class="form-control">
                            <?php foreach ($countries as $country): ?>
                                <option value="<?php echo $country->Id;?>"><?php echo $country->Name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="columns five control-label"><?php echo __("Phone number","form")?></label>
                    <div class="columns seven">
                        <div class="row">
                            <div class="columns four">
                                <input type="text" class="form-control" id="inputPhoneCountryCode" name="phoneCountryCode" value="<?php echo $data['phone_ccode']?>"/>
                            </div>
                            <div class="columns eight">
                                <input type="text" class="form-control" id="inputPhoneNumber" name="phoneNumber" value="<?php echo $data['phone_number']?>"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="currencyId" class="columns five control-label"><?php echo __("Choose Base Currency","form")?></label>
                    <div class="columns seven">
                        <select name="currencyId" class="form-control">
                            <?php foreach ($currencies as $currency): ?>
                                <option value="<?php echo $currency['currency_id'];?>"><?php echo $currency['currency_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="platform" class="columns five control-label"><?php echo __("Choose Trading Platform","form")?></label>
                    <div class="columns seven">
                        <select name="platform" class="form-control">
                            <?php foreach ($platforms as $platform): ?>
                                <option value="<?php echo $platform;?>"><?php echo $platform; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="columns twelve">
                        <button type="submit" name="submit"  id="create-account-additional" value="additional-account" class="btn btn-default"><?php echo __("Request Additional Account","form")?></button>
                    </div>
                </div>
                <div class="form-group">
                    <div class=" ajax_loader"></div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>


