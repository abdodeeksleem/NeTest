<?php
$DOCUMENT_ROOT = $_SERVER ['DOCUMENT_ROOT'];

//require_once (plugin_dir_path ( __FILE__ ) . '/crm/fxconfig.php');
//require_once (plugin_dir_path ( __FILE__ ) . '/util/util.php');

add_shortcode ( 'zotapay_success', 'zotapay_success_short' );

function zotapay_success_short() {
    ob_start ();
    zotapay_success_func();
    return ob_get_clean ();
}

function zotapay_success_func() {

    if(isset($_SESSION['amount'])){

        $email=$_SESSION['email'];
        $amount=$_SESSION['amount'];
        unset($_SESSION);
        outputmessage($email, $amount);

    }else{

        global $wpdb;
        $orderNumber = $_GET["transaction"];
        $payment_status_table = $wpdb->prefix . 'payment_status';
        $result = $wpdb->get_results ( $wpdb->prepare ( "SELECT *  FROM $payment_status_table WHERE transaction_id = %s", $orderNumber ) );
        $email = $result [0]->email;
        $amount = $result [0]->amount;
        outputmessage($email, $amount);

    }

}



//Form to collect personal details
function outputmessage($email, $amount) {
    ?>
    <h1 class="form-titleHead"> <?php echo __("Payment Confirmation","success")?></h1>
    <p><?php echo __("Thank you for your payment.","success"); ?> </p>
    <p><?php echo __("User Id: ","success"); ?> <span><?php echo $email;?></span></p>
    <p><?php echo __("Receipt Number: ","success"); ?> <span><?php echo $_GET["transaction"];?></span></p>
    <p><?php echo __("Total amount: ","success"); ?><span> <?php echo $amount; ?></span></p>

    <?php
}