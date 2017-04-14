/**
 * Created by andreas on 09/02/2016.
 */

(function($) {


    $('#forgotpassword-form').each(function() {
        $(this).validate({
            rules: {
                username: {
                    required: true,
                    email: true
                }
            },
            messages: {
                username: {
                    required: "Please enter a username",
                    email: "Invalid Username"
                }
            }
        });
    });


    var optionsforgot = {
        beforeSubmit:  before_submit,  // pre-submit callback
        success:       after_submit , // post-submit callback
        url:      '/wp-content/plugins/Venture/controller.php' // override for form's 'action' attribute
    };

    $('#forgotpassword-form').ajaxForm(optionsforgot);

    $( "#inputEmailForgot").change(function(){
        $(".error-wrap").text('');
    });

})(jQuery);



function before_submit(){

    jQuery("#forgotpassword-btn").css('display',"none");
    jQuery( "div.ajax_loader" ).css('display',"block");

}


function after_submit(data){

    var obj=jQuery.parseJSON(data);
    var code =obj.Code;
    var msg = obj.Message;

    if (code==0){
        
        jQuery(".error-wrap").text(msg);
        jQuery("#forgotpassword-btn").css('display',"block");
        jQuery( "div.ajax_loader" ).css('display',"none");
        return false;

    }else if(code=='Success'){
        jQuery(".error-wrap").text(msg);
        jQuery( "div.ajax_loader" ).css('display',"none");
        return true;
    }


}


