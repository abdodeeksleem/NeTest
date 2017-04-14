/**
 * Created by andreas on 22/02/2016.
 */
(function($) {

    $(function() {
        $( "#tabs" ).tabs({disabled: [ 9, 10, 11 ]}).addClass( "ui-tabs-vertical ui-helper-clearfix" );
        $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
    });

    $('#tabs li a.ex-link').click(function(){
        window.open(this.href);
        return false;
    });

    $('#tabs li a.link-docs').click(function(){
        get_docs();
        return false;
    });


    //webshims.setOptions('waitReady', false);
    //webshims.setOptions('forms-ext', {types: 'date'});
    //webshims.polyfill('forms forms-ext');

//!Set the country according to GUID
    var country_id=$("#user_country_id").val();
    $("#countryId").val(country_id).change();


    var optionsmyaccount = {
        beforeSubmit:  before_submit,  // pre-submit callback
        success:       after_submit , // post-submit callback
        url:      '/wp-content/plugins/Venture/controller.php' // override for form's 'action' attribute
    };

    $('#userinformation-form').ajaxForm(optionsmyaccount);

    var optionsforgot = {
        beforeSubmit:  before_submit_forgot,  // pre-submit callback
        success:       after_submit_forgot , // post-submit callback
        url:      '/wp-content/plugins/Venture/controller.php' // override for form's 'action' attribute
    };

    $('#forgot-tpaccount-password').ajaxForm(optionsforgot);



    var optionsreset = {
        beforeSubmit:  before_submit_reset,
        success:       after_submit_reset ,
        url:      '/wp-content/plugins/Venture/controller.php'
    };

    $('#reset-tpaccount-password').ajaxForm(optionsreset);

    var optionsgethistory = {

        beforeSubmit:  before_submit_history,
        success:       after_submit_history ,
        url:      '/wp-content/plugins/Venture/controller.php'
    };

    $('#get-tpaccount-history').ajaxForm(optionsgethistory);

    var optionswithdrawal = {

        beforeSubmit:  before_submit_withdrawal,
        success:       after_submit_withdrawal ,
        url:      '/wp-content/plugins/Venture/controller.php'
    };

    $('#create-withdrawal').ajaxForm(optionswithdrawal);


    var optionsadditional = {

        beforeSubmit:  before_submit_additional,
        success:       after_submit_additional ,
        url:      '/wp-content/plugins/Venture/controller.php'
    };

    $('#additional-account').ajaxForm(optionsadditional);


})(jQuery);


function before_submit(){

    jQuery("#userinformation-btn").css('display',"none");
    jQuery( "div.ajax_loader" ).css('display',"block");

}


function after_submit(data){

    var obj=jQuery.parseJSON(data);
    var code =obj.Code;
    var msg = obj.Message;

    if (code==0){

        jQuery("#accountinfo").text("Error Occured . Please Contact Administrator if problem is not fixed .");
        jQuery("#userinformation-btn").css('display',"block");
        jQuery( "div.ajax_loader" ).css('display',"none");

        return false;

    }else if(code=='Success'){

        jQuery( "div.ajax_loader" ).css('display',"none");
        jQuery("#accountinfo").text(msg);
        jQuery("#userinformation-btn").css('display',"block");

        return true;
    }

}



function before_submit_forgot(){
    jQuery("#forgot-tpaccount-btn").css('display',"none");
    jQuery( "div.ajax_loader" ).css('display',"block");
}


function after_submit_forgot(data){

    var obj=jQuery.parseJSON(data);
    var code =obj.Code;
    var msg = obj.Message;
    if (code==0){

        jQuery("#forgotmsg").text("Error Occured . Please Contact Administrator if problem is not fixed .");
        jQuery("#forgot-tpaccount-btn").css('display',"block");
        jQuery( "div.ajax_loader" ).css('display',"none");

        return false;

    }else if(code=='Success'){

        jQuery( "div.ajax_loader" ).css('display',"none");
        jQuery("#forgotmsg").text("Your Platform Account Password has been sent via Email.");
        jQuery("#forgot-tpaccount-btn").css('display',"block");

        return true;
    }else{

        jQuery("#forgotmsg").text("Error Occured . Please Contact Administrator if problem is not fixed .");
        jQuery("#forgot-tpaccount-btn").css('display',"block");
        jQuery( "div.ajax_loader" ).css('display',"none");

    }

}

function before_submit_reset(){
    jQuery("#reset-tpaccount-btn").css('display',"none");
    jQuery( "div.ajax_loader" ).css('display',"block");
}


function after_submit_reset(data){

    var obj=jQuery.parseJSON(data);
    var code =obj.Code;
    var msg = obj.Message;
    if (code==0){

        jQuery("#resetmsg").text(msg);
        jQuery("#reset-tpaccount-btn").css('display',"block");
        jQuery( "div.ajax_loader" ).css('display',"none");

        return false;

    }else if(code=='Success'){

        jQuery( "div.ajax_loader" ).css('display',"none");
        jQuery("#resetmsg").text("Your Platform Account Password has been Changed Successfully.");
        jQuery("#reset-tpaccount-btn").css('display',"block");

        return true;
    }else{

        jQuery("#resetmsg").text(msg);
        jQuery("#reset-tpaccount-btn").css('display',"block");
        jQuery( "div.ajax_loader" ).css('display',"none");

    }

}


function before_submit_history(){
    jQuery("#records_table").empty();
    jQuery("#gethistory-tpaccount-btn").css('display',"none");
    jQuery( "div.ajax_loader" ).css('display',"block");
}


function after_submit_history(data){

    var obj=jQuery.parseJSON(data);
    var code =obj.Code;
    var msg = obj.Message;

    response =jQuery.parseJSON(data);

    jQuery(function() {
        var heads =jQuery('<tr>').append(
            jQuery('<td>').text("Action Type"),
            jQuery('<td>').text("Amount"),
            jQuery('<td>').text("Instrument Name"),
            jQuery('<td>').text("Open Rate"),
            jQuery('<td>').text("Open Time"),
            jQuery('<td>').text("Close Rate"),
            jQuery('<td>').text("Close Time"),
            jQuery('<td>').text("Order ID")
        );

        var thead = jQuery('<thead>').append(heads);

        thead.appendTo('#records_table');
        jQuery.each(response, function(i, item) {
            var $tr =jQuery('<tr>').append(
                jQuery('<td>').text(item.ActionType),
                jQuery('<td>').text(item.Amount),
                jQuery('<td>').text(item.InstrumentName),
                jQuery('<td>').text(item.OpenRate),
                jQuery('<td>').text(item.OpenTime),
                jQuery('<td>').text(item.CloseRate),
                jQuery('<td>').text(item.CloseTime),
                jQuery('<td>').text(item.OrderID)

            );
            $tr.appendTo('#records_table');
        });
    });

    if (code==0){

        jQuery("#historymsg").text(msg);
        jQuery("#gethistory-tpaccount-btn").css('display',"block");
        jQuery( "div.ajax_loader" ).css('display',"none");

        return false;

    }else if(code=='Success'){

        jQuery( "div.ajax_loader" ).css('display',"none");
        jQuery("#historymsg").text("Your Platform Account Password has been Changed Successfully.");
        jQuery("#gethistory-tpaccount-btn").css('display',"block");
        alert(data);

        return true;

    }else{

        jQuery("#resetmsg").text(msg);
        jQuery("#gethistory-tpaccount-btn").css('display',"block");
        jQuery( "div.ajax_loader" ).css('display',"none");

    }

}


function before_submit_withdrawal(){
    jQuery("#create-withdrawal-btn").css('display',"none");
    jQuery( "div.ajax_loader" ).css('display',"block");
}


function after_submit_withdrawal(data){

    var obj=jQuery.parseJSON(data);
    var code =obj.Code;
    var msg = obj.Message;

    if (code==0){

        jQuery("#withdrawalmsg").text(msg);
        jQuery("#create-withdrawal-btn").css('display',"block");
        jQuery( "div.ajax_loader" ).css('display',"none");

        return false;

    }else if(code=='Success'){
        jQuery( "div.ajax_loader" ).css('display',"none");
        jQuery("#withdrawalmsg").text(msg);
        jQuery("#create-withdrawal-btn").css('display',"block");
        return true;

    }else{
        jQuery("#withdrawalmsg").text("Error Occured . Please Contact Administrator if problem is not fixed .");
        jQuery("#create-withdrawal-btn").css('display',"block");
        jQuery( "div.ajax_loader" ).css('display',"none");
    }
}


function get_docs(){


    jQuery.ajax({
        url: '/wp-content/plugins/Venture/controller.php',
        type: 'POST',
        data: {submit: 'user_docs'}
    }).done(function(data){

        if (data==false){
            return;
        }

        jQuery("#docs_table").empty();
        //!Documents Found
        response =jQuery.parseJSON(data);
        trigger_table(response);
    });

}





function before_submit_additional(){

    jQuery("#create-account-additional").css('display',"none");
    jQuery( "div.ajax_loader" ).css('display',"block");

}


function after_submit_additional(data){

    console.log(data);

    var obj=jQuery.parseJSON(data);
    var code =obj.Code;
    var msg = obj.Message;

    if (code==0){
        jQuery("#additionalmsg").text(msg);
        jQuery("#create-account-additional").css('display',"block");
        jQuery( "div.ajax_loader" ).css('display',"none");

        return false;

    }else if(code=='Success'){
        jQuery( "div.ajax_loader" ).css('display',"none");
        jQuery("#additionalmsg").text(msg);
        jQuery("#create-account-additional").css('display',"block");
        return true;

    }else{
        jQuery("#additionalmsg").text("Error Occured . Please Contact Administrator if problem is not fixed .");
        jQuery("#create-account-additional").css('display',"block");
        jQuery( "div.ajax_loader" ).css('display',"none");
    }
}


function trigger_table(response){
    var heads =jQuery('<tr>').append(
        jQuery('<td>').text("Document Type"),
        jQuery('<td>').text("File Name"),
        jQuery('<td>').text("Date")
    );

    var thead = jQuery('<thead>').append(heads);

    thead.appendTo('#docs_table');
    jQuery.each(response, function(i, item) {
        var $tr =jQuery('<tr>').append(
            jQuery('<td>').text(item.document_type),
            jQuery('<td>').text(item.file_name),
            jQuery('<td>').text(item.date_uploaded)
        );
        $tr.appendTo('#docs_table');
    });

}
