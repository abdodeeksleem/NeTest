/**
 * Created by andreas on 28/01/2016.
 */
(function($) {

    $("#LeadForm").validate({
        rules: {
            firstName: {
                required: true
            },
            lastName: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            countryId: {
                required: true
            },
            phoneCountryCode: {
                required: true
            },
            phoneNumber: {
                required: true,
                number: true
            }
        },

        messages: {
            firstName: {
                required: "Please enter your firstname"
            },
            lastName: {
                required: "Please enter your lastname"
            },
            email: {
                required: "Please enter a valid email address",
                email: "Invalid Email"
            },
            countryId: {
                required: 'Please Select Country'
            },
            phoneCountryCode: {
                required: 'Please Select Country Code'
            },
            phoneNumber: {
                required: 'Please enter your phone number',
                number: 'Phone Number is Invalid'
            }
        }
    });

    var options = {
        beforeSubmit:  before_submit,  // pre-submit callback
        success:       after_submit , // post-submit callback
        url:      '/wp-content/plugins/Venture/controller.php' // override for form's 'action' attribute
    };

    $('#LeadForm').ajaxForm(options);

    //! Phone Country Code Based on Country
    realccode( $("#countryId option:selected" ).text());

    $( "#countryId" ).change(function() {
        realccode( $("#countryId option:selected" ).text());
    });



})(jQuery);



function after_submit(data){

    var obj=jQuery.parseJSON(data);
    //!Check the error if is success

    if (obj.Code=='Success') {
        var reg_lang = jQuery("#reg_lang").val();
        var Account_Id = obj.AccountId;
        jQuery(".ajax_loader").css('display',"none");

        if (reg_lang == 'ar'|| reg_lang=="")
            window.location.replace("/registration?id=" + Account_Id);
        else
            window.location.replace("/" + reg_lang + "/registration?id=" + Account_Id);

    } else if(obj.Code=='99'){

        jQuery(".error-wrap").text('Error Occured Please Try to resubmit.');
        jQuery("#message").css('display', "block");
        jQuery( ".ajax_loader" ).css('display',"none");
        jQuery("#leadsubmit").css('display', "block");

        return false;

    }else{

        jQuery(".error-wrap").text(obj.Message);
        jQuery("#message").css('display', "block");
        jQuery( ".ajax_loader" ).css('display',"none");
        jQuery("#leadsubmit").css('display', "block");

        return false;
    }


}


function before_submit(){

    jQuery("#leadsubmit").css('display',"none");
    jQuery( ".ajax_loader" ).css('display',"block");

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
