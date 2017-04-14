/**
 * Created by andreas on 28/01/2016.
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

    $('#Real-Form-Short').each(function() {
        $(this).validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                Password: {
                    required: true,
                    minlength: 6,
                    regex: /^(?=.*[a-zA-Z])(?=.*\d)(?=.*)[A-Za-z\d][A-Za-z\d]{6,19}$/
                },
                firstName: {
                    required: true
                },
                lastName: {
                    required: true
                },
                countryId: {
                    required: true
                },
                phoneNumber: {
                    required: true,
                    number: true
                },
                MobileNumber: {
                    required: true,
                    number: true
                },
                phoneCountryCode: {
                    required: true,
                    number: true
                },
                MobileNumberCCode: {
                    required: true,
                    number: true
                },
                terms: {
                    required: true
                }

            },
            messages: {
                email: {
                    required: "Please enter an email",
                    email: "Invalid Email"
                },
                Password: {
                    required: "Please provide a password",
                    minlength: "Password should include at least 6 characters",
                    regex: "Please check your input. Password should include at least one number and one character"
                },
                firstName: {
                    required: "Please provide your firstname"
                },
                lastName: {
                    required: "Please provide your lastname"
                },
                countryId: {
                    required: "Please select a country"
                },
                phoneNumber: {
                    required: "Please enter phone number",
                    number: "Please use only numbers"
                },
                MobileNumber: {
                    required: "Please enter mobile number",
                    number: "Please use only numbers"
                },
                phoneCountryCode: {
                    required: "Please enter country code",
                    number: "Please use only numbers"
                },
                MobileNumberCCode: {
                    required: "Please enter country code",
                    number: "Please use only numbers"
                },
                terms: {
                    required: "Need to accept terms and conditions"
                }
            }
        });
    });

    var optionsregister = {
        beforeSubmit:  before_submit,  // pre-submit callback
        success:       after_submit , // post-submit callback
        url:      '/wp-content/plugins/Venture/controller.php' // override for form's 'action' attribute
    };

    $('#Real-Form-Short').ajaxForm(optionsregister);

    //! Phone Country Code Based on Country
    realccode( $("#countryId option:selected" ).text());


    $( "#countryId" ).change(function() {
        realccode( $("#countryId option:selected" ).text());
    });

})(jQuery);



function after_submit(data){

    var obj=jQuery.parseJSON(data);
    if (obj.Code=='99'){

        // $(".error-wrap").text('Error Occured Please Try to resubmit.');
        alert("Error Occured Please Try to resubmit.");

        jQuery( ".ajax_loader" ).css('display',"none");
        jQuery( "#real-step" ).css('display',"block");
        return false;

    }else if(obj.Code=='Success'||obj.Code=='SuccessWithDuplicates') {
        alert('Registration was Successfully created . You will be redirected to UserArea');
        window.location.replace("/my-account");
        jQuery( ".ajax_loader" ).css('display',"none");
        jQuery( "#real-step" ).css('display',"block");
        return true;

    }else if(obj.Code=='1'){
        jQuery(".error-wrap").text(obj.Message);
        jQuery( ".ajax_loader" ).css('display',"none");
        jQuery( "#real-step" ).css('display',"block");
        return false;

    } else{
        jQuery(".error-wrap").text('Error Occured Please Try to resubmit.');
        jQuery( ".ajax_loader" ).css('display',"none");
        jQuery( "#real-step" ).css('display',"block");
        return false;
    }
}


function before_submit(){

    jQuery( ".ajax_loader" ).css('display',"block");
    jQuery( "#real-step" ).css('display',"none");

}

function realccode(option){

    var data=jQuery.getJSON( '/wp-content/plugins/Venture/assets/resources/data.json', function() {
        var values=(data.responseText);
        values=JSON.parse(values);
        if (values[option] != null) {
            var phone_code = values[option]["P_CODE"];
            jQuery("#inputPhoneCountryCode").val(phone_code);
        }else{
            jQuery("#inputPhoneCountryCode").val('');
        }

    });

}
