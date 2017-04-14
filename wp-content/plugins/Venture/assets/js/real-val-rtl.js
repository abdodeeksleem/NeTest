/**
 * Created by andreas on 28/01/2016.
 */
(function($) {
    webshims.setOptions('waitReady', false);
    webshims.setOptions('forms-ext', {types: 'date'});
    webshims.polyfill('forms forms-ext');

    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var check = false;
            return this.optional(element) || regexp.test(value);
        },
        "Please check your input."
    );

    $('#RealFormStep1').each(function() {
        $(this).validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                Password: {
                    required: true,
                    minlength: 6,
                    regex: /^[a-zA-Z0-9]+$/
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
                phoneAreaCode: {
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
                    regex: 'Password should include only numbers and letters.'
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
                phoneAreaCode: {
                    required: "Please enter area code",
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

    $('#RealFormStep2').each(function() {
        $(this).validate({
            rules: {
                DateOfBirth: {
                    required: true
                },
                address1: {
                    required: true
                },
                address2: {
                    required: true
                },
                towncity: {
                    required: true
                },
                State: {
                    required: true
                },
                ZipCode: {
                    required: true,
                    number: true
                }
            },
            messages: {
                DateOfBirth: {
                    required: "Please enter date of birth"
                },
                address1: {
                    required: "Please enter address"
                },
                address2: {
                    required: "Please enter address"
                },
                towncity: {
                    required: "Please enter town"
                },
                State: {
                    required: "Please enter state"
                },
                ZipCode: {
                    required: "Please enter zip code",
                    number: "Please use only numbers"
                }
            }
        });
    });

    $('#RealFormStep3').each(function() {
        $(this).validate({
            rules: {
                img: {
                    required: true
                },
                terms: {
                    required: true
                }

            },
            messages: {
                img: {
                    required: "Please upload your documents"
                },
                terms: {
                    required: "Need to accept terms and conditions"
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "terms") {
                    error.insertAfter(".terms");
                } else {
                    error.insertAfter(element);
                }
            }

        });
    });

    var options_step1 = {
        beforeSubmit:  before_submit_step1,  // pre-submit callback
        success:       after_submit_step1 , // post-submit callback
        url:      '/wp-content/plugins/Venture/controller.php' // override for form's 'action' attribute
    };

    var options_step2 = {
        beforeSubmit:  before_submit_step2,  // pre-submit callback
        success:       after_submit_step2 , // post-submit callback
        url:      '/wp-content/plugins/Venture/controller.php' // override for form's 'action' attribute
    };


    $('#RealFormStep3').submit(function(e) {

        $("#real-step3").css('display',"none");
        $( ".ajax_loader" ).css('display',"block");

        $.ajax({
            url: '/wp-content/plugins/Venture/controller.php',
            type: 'POST',
            data: $('#RealFormStep1, #RealFormStep2,#RealFormStep3').serializeArray()

        }).done(function(data){

            $("#real-step3").css('display',"block");
            $( ".ajax_loader" ).css('display',"none");

            var obj=jQuery.parseJSON(data);
            if (obj.Code=='99'){
               // $(".error-wrap").text('Error Occured Please Try to resubmit.');
                alert("Error Occured Please Try to resubmit.");

                return false;

            }else if(obj.Code=='Success'){
                alert(obj.Message);
                window.location.replace("/my-account");
                return true;

            }else if(obj.Code=='1'){
               $(".error-wrap").text('Error Occured Please Try to resubmit.');
                alert('Error Occured');
                $("#RealFormStep3").css('display',"none");
                $("#RealFormStep1").css('display',"block");
                return false;
            }
        });

        return false;
    });

//!Bind the options with the AjaxForm Function
    $('#RealFormStep1').ajaxForm(options_step1);
    $('#RealFormStep2').ajaxForm(options_step2);


})(jQuery);


function after_submit_step1(data){

    var obj=jQuery.parseJSON(data);

    //!Check the error if is success
    jQuery("#message").text(obj.Message);


    if (obj.Code=='Success') {
        jQuery(".steps-container.step-1 .step-arrow").css('background-color', '#1690a2');
        jQuery(".steps-container.step-2").css('background-color', '#1690a2');
        jQuery(".steps-container.step-2 .step-no").css('color', '#1690a2');
        jQuery(".steps-container.step-2 .step-arrow").css('background-position', '-13px -9px');
        jQuery("#RealFormStep1").css('display', "none");
        jQuery("#RealFormStep2").css('display', "block");
        jQuery("#account_id").val(obj.AccountId);
    }


    jQuery(".ajax_loader").css('display', "none");
    jQuery("#real-step1").css('display', "block");

}


function before_submit_step1(){

    jQuery("#real-step1").css('display',"none");
    jQuery( ".ajax_loader" ).css('display',"block");
}



function before_submit_step2(){

    jQuery("#real-step2").css('display',"none");
    jQuery( ".ajax_loader" ).css('display',"block");

}

function after_submit_step2(){

    jQuery(".steps-container.step-2 .step-arrow").css('background-color', '#056370');
    jQuery(".steps-container.step-3").css('background-color', '#056370');
    jQuery(".steps-container.step-3 .step-no").css('color', '#056370');
    jQuery("#RealFormStep2").css('display',"none");
    jQuery("#RealFormStep3").css('display',"block");
    jQuery("#real-step2").css('display',"block");
    jQuery(".ajax_loader").css('display',"none");

}



function realccode(option){

    var data=jQuery.getJSON( '/wp-content/plugins/traders_room/country/data.json', function() {
        var values=(data.responseText);
        values=JSON.parse(values);
        if (values[option] != null) {
            var phone_code = values[option]["P_CODE"];
            jQuery("#realcountrycode").val(phone_code);
        }else{
            jQuery("#realcountrycode").val('');
        }

    });

}
