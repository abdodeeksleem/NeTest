<?php
/**
 * Created by PhpStorm.
 * User: andreas H.
 * Date: 25/01/2016
 * Time: 3:30 ΜΜ
 */


// mt_toplevel_page() displays the page content for the custom Test Toplevel menu
function mt_toplevel_page() {

    $message='';
    $message_test='';

    if(isset($_POST['submit']) && $_POST['submit']=='email_conf' ){
        update_email_settings($_POST);
        $message='Settings Updated Successfully';
    }

    if(isset($_POST['submit']) && $_POST['submit']=='email_test_conf' ){
        send_test_email($_POST);
        $message_test='Email Send . Please Check your Email to see if you receive the test Email.';
    }

//!Get from Database Settings
    global $wpdb;
    $table_name = 'wp_venture_plugin_settings';
    $option = $wpdb->get_results("select option_value FROM $table_name WHERE option_category='email'", ARRAY_A );
    $data=json_decode($option['0']['option_value'],true);

    ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" name="email-conf-form" id="email-conf-form" autocomplete="off">
                <div class="form-title">Outgoing Mail Configuration</div>
                <div class="error-wrap"><?php echo $message?></div>

                <div class="form-group">
                    <label for="inputCompanyName" class="columns five control-label">Company Name (It will be appear on Email) :</label>
                    <div class="columns seven">
                        <input type="text" class="form-control" id="inputCompanyName" name="company_name" value="<?php echo $data['company_name'] ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputTPUrl" class="columns five control-label">Platform URL (It will be appear on Email Account Creation) :</label>
                    <div class="columns seven">
                        <input type="text" class="form-control" id="inputTPUrl" name="platform_url" value="<?php echo $data['platform_url'] ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPortalUrl" class="columns five control-label">Portal URL (It will be appear on Email) :</label>
                    <div class="columns seven">
                        <input type="text" class="form-control" id="inputPortalUrl" name="portal_url" value="<?php echo $data['portal_url'] ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmailUserSupport" class="columns five control-label">Support Email User :</label>
                    <div class="columns seven">
                        <input type="email" class="form-control" id="inputEmailUserSupport" name="email_user_support" value="<?php echo $data['email_user_support'] ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmailUserSupportPass" class="columns five control-label">Support Email Password :</label>
                    <div class="columns seven">
                        <input type="text" class="form-control" id="inputEmailUserSupportPass" name="email_user_support_pass" value="<?php echo $data['email_user_support_pass'] ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmailUserNoReply" class="columns five control-label">No Reply Email User :</label>
                    <div class="columns seven">
                        <input type="email" class="form-control" id="inputEmailUserNoReply" name="email_user_noreply" value="<?php echo $data['email_user_noreply'] ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmailUserNoReplyPass" class="columns five control-label">No Reply Email Password :</label>
                    <div class="columns seven">
                        <input type="text" class="form-control" id="inputEmailUserNoReplyPass" name="email_user_noreply_pass" value="<?php echo $data['email_user_noreply_pass'] ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputSmtpServer" class="columns five control-label">SMTP Server : </label>
                    <div class="columns seven">
                        <input type="text" class="form-control" id="inputSmtpServer" name="smtp_server" value="<?php echo $data['smtp_server'] ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputSmtpProtocol" class="columns five control-label">SMTP Protocol :</label>
                    <div class="columns seven">
                        <input type="text" class="form-control" id="inputSmtpProtocol" name="smtp_protocol" value="<?php echo $data['smtp_protocol'] ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputSmtpPort" class="columns five control-label">SMTP Port :</label>
                    <div class="columns seven">
                        <input type="text" class="form-control" id="inputSmtpPort" name="smtp_port" value="<?php echo $data['smtp_port'] ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="columns twelve">
                        <button type="submit" id="emailconf-btn" name="submit" class="btn btn-default" value="email_conf">Update Settings</button>
                        <div class="columns twelve ajax_loader"></div>
                    </div>
                </div>
            </form>



            <form class="form-horizontal" role="form" method="POST" name="email-conf-form" id="email-conf-form" autocomplete="off">
                <div class="form-title">Test Email Settings :</div>
                <div class="error-wrap"><?php echo $message_test;?></div>

                <div class="form-group">
                    <label for="inputEmailTest" class="columns five control-label">Email :</label>
                    <div class="columns seven">
                        <input type="email" class="form-control" id="inputEmailTest" name="email_to_test" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="columns twelve">
                        <button type="submit" id="emailtestconf-btn" name="submit" class="btn btn-default" value="email_test_conf">Send Test Email</button>
                        <div class="columns twelve ajax_loader"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
}

// mt_sublevel_page() displays the page content for the first submenu
// of the custom Test Toplevel menu
function mt_sublevel_page() {
    global $config;
    $data=$config;
    $message='';
    ?>
<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" name="email-conf-form" id="email-conf-form" autocomplete="off">
            <div class="form-title">Venture Settings :</div>
            <div class="error-wrap"><?php echo $message;?></div>

            <div class="form-group">
                <label for="inputWsdl" class="columns five control-label">WSDL Location :</label>
                <div class="columns seven">
                    <input type="text" class="form-control admin-fields" id="inputWsdl" name="wsdl" value="<?php echo $data['wsdl']; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label for="inputapiLocation" class="columns five control-label">API Location :</label>
                <div class="columns seven">
                    <input type="text" class="form-control admin-fields" id="inputapiLocation" name="apiLocation" value="<?php echo $data['apiLocation']; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label for="inputOrganization" class="columns five control-label">Organization:</label>
                <div class="columns seven">
                    <input type="text" class="form-control admin-fields" id="inputOrganization" name="organization" value="<?php echo $data['organization']; ?>" />
                </div>
            </div>



            <div class="form-group">
                <label for="inputBusinessUnitName" class="columns five control-label">Business Unit Name:</label>
                <div class="columns seven">
                    <input type="text" class="form-control admin-fields" id="inputBusinessUnitName" name="businessUnitName" value="<?php echo $data['businessUnitName']; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label for="inputOwnerUserId" class="columns five control-label">Owner User Id :</label>
                <div class="columns seven">
                    <input type="text" class="form-control admin-fields" id="inputOwnerUserId" name="ownerUserId" value="<?php echo $data['ownerUserId']; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label for="inputUsername" class="columns five control-label">User Name :</label>
                <div class="columns seven">
                    <input type="text" class="form-control admin-fields" id="inputUsername" name="username" value="<?php echo $data['username']; ?>" />
                </div>
            </div>


            <div class="form-group">
                <label for="inputPassword" class="columns five control-label">Password :</label>
                <div class="columns seven">
                    <input type="text" class="form-control admin-fields" id="inputPassword" name="password" value="<?php echo $data['password']; ?>" />
                </div>
            </div>

            <input type="hidden" class="form-control" id="inputWsdlCache" name="wsdlCache" value="<?php echo WSDL_CACHE_MEMORY; ?>" />


            <div class="form-group">
                <div class="columns twelve">
                    <button type="submit" id="emailtestconf-btn" name="submit" class="btn btn-default" value="email_test_conf">Update Settings</button>
                    <div class="columns twelve ajax_loader"></div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php

}

// mt_sublevel_page2() displays the page content for the second submenu
// of the custom Test Toplevel menu
function mt_sublevel_page2() {
    echo "<h2>" . __( 'Test Sublevel2', 'menu-test' ) . "</h2>";
}


/**
 * @Controller Functions
 * Need to add these functions in Admin-Controller class
 */

//!This Function Will be Added on Controller ADMIN
function update_email_settings($data){

    unset($data['submit']);
    $json_value=json_encode($data);
    execute_sql_update('wp_venture_plugin_settings',array('option_value'=>$json_value),array('option_category'=>'email'));

}


//!This Function Will be Added on Controller ADMIN
function execute_sql_update($table_name,$array_updated,$array_condition){

    global $wpdb;
    $sql = $wpdb->update ( $table_name,$array_updated,$array_condition);
    $wpdb->query ( $sql );

}


function send_test_email($data){

    require_once($_SERVER ['DOCUMENT_ROOT'] . '/wp-content/plugins/Venture/Email/email_generic.php');
    $email_instance= new email_generic();
    $email_instance->send_test_email($data);

}


