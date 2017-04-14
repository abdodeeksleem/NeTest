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

    $('#login-form').each(function() {
        $(this).validate({
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 6,
                    regex: /^[a-zA-Z0-9]+$/
                }
            },
            messages: {
                username: {
                    required: "Please enter a username"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Password should include at least 6 characters",
                    regex: 'Password should include only numbers and letters.'
                }
            }
        });

    });


    var optionslogin = {
        beforeSubmit:  before_submit,  // pre-submit callback
        success:       after_submit , // post-submit callback
        url:      '/wp-content/plugins/Venture/controller.php' // override for form's 'action' attribute
    };
    $('#login-form').ajaxForm(optionslogin);

    $( "#inputEmailLogin").change(function(){
        $(".error-wrap").text('');
    });

})(jQuery);



function before_submit(){

    jQuery("#login-submit").css('display',"none");
    jQuery( "div.ajax_loader" ).css('display',"block");

}


function after_submit(data){

    var obj=jQuery.parseJSON(data);
    var code =obj.Code;

    if (code==0){

        jQuery(".error-wrap").text('Incorrect Username or Password.');
        jQuery("#login-submit").css('display',"");
        jQuery( "div.ajax_loader" ).css('display',"none");

        return false;

    }else if(code=='Success'){
        window.location.replace("/my-account");
        return true;
    }


}


