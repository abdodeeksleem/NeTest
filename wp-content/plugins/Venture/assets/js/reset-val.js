/**
 * Created by andreas on 09/02/2016.
 */

(function($) {

    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var check = false;
            return this.optional(element) || regexp.test(value);
        },
        "Please check your input."
    );

    $('#resetpassword-form').each(function() {
        $(this).validate({
            rules: {
                password: {
                    required: true,
                    minlength: 6,
                    regex: /^[a-zA-Z0-9]+$/
                },
                passwordconfirm: {
                    required: true,
                    equalTo: "#inputPassword"
                }
            },
            password: {
                required: "Please provide a password",
                minlength: "Password should include at least 6 characters",
                regex: 'Password should include only numbers and letters.'
            },
            passwordconfirm: {
                username: {
                    required: "Please enter password again",
                    equalTo: "Please enter the same password as above"
                }
            }
        });
    });


    var optionsreset = {
        beforeSubmit:  before_submit,  // pre-submit callback
        success:       after_submit , // post-submit callback
        url:      '/wp-content/plugins/Venture/controller.php' // override for form's 'action' attribute
    };

    $('#resetpassword-form').ajaxForm(optionsreset);

})(jQuery);



function before_submit(){

    jQuery("#resetpassword-btn").css('display',"none");
    jQuery( "div.ajax_loader" ).css('display',"block");

}


function after_submit(data){

    var obj=jQuery.parseJSON(data);
    var code =obj.Code;
    var msg = obj.Message;

    if (code==0){

        jQuery(".error-wrap").text(msg);
        jQuery("#resetpassword-btn").css('display',"block");
        jQuery( "div.ajax_loader" ).css('display',"none");
        return false;

    }else if(code=='Success'){
        jQuery( "div.ajax_loader" ).css('display',"none");
        var counter = 10;
        setInterval(function(){
            counter--;
            if (counter >= 0) {
                jQuery(".error-wrap").text( msg + counter + 's');
            }
            // Display 'counter' wherever you want to display it.
            if (counter === 0) {
                window.location = "/login";
                clearInterval(counter);}}, 1000);

        return true;
    }


}


