/**
 * Created by andreas on 28/01/2016.
 */
(function($) {
    $( document ).ready(function() {
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
                phoneNumber: {
                    required: true,
                    number: true
                },
                phoneCountryCode: {
                    required: true
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
            beforeSubmit: before_submit,  // pre-submit callback
            success: after_submit, // post-submit callback
            url: '/wp-content/plugins/Venture/controller.php' // override for form's 'action' attribute
        };


        $('#LeadForm').ajaxForm(options);

        //! Phone Country Code Based on Country
        realccode( $("#country option:selected" ).text());

        $( "#country" ).change(function() {
            realccode( $("#country option:selected" ).text());
        });
    });


})(jQuery);

function trackGoogleConversion(){
    window.google_trackConversion(
        {google_conversion_id:924720795,
            google_conversion_label:"ASC0COy4jmUQm734uAM"});

}

function trackAffiliateConversion(){

var jqxhr = jQuery.get( "https://www.ettemad.com/callaffiliate.php", function() {
 console.log( "success" );
})
  .done(function() {
   console.log( "success" );
  })
  .fail(function() {
    console.log( "error" );
  })
  .always(function() {
    console.log( "finished" );
  });
 
}

function after_submit(data){

    var obj=jQuery.parseJSON(data);
    //!Check the error if is success

    if (obj.Code=='Success') {
        trackGoogleConversion();
	trackAffiliateConversion();
        var reg_lang = jQuery("#reg_lang").val();
        var Account_Id = obj.AccountId;
        jQuery(".ajax_loader").css('display',"none");
        var url;
        if (reg_lang == 'ar'|| reg_lang=="")
            url="https://www.ettemad.com" + "/registration?id=" + Account_Id;
        else
            url="https://www.ettemad.com/" + reg_lang + "/registration?id=" + Account_Id;

        jQuery("#message").text(get_msg_translation(reg_lang));
        jQuery("#message" ).append( '<a href="'+url+'">Verify</a>');
        jQuery("#LeadForm").css('display',"none");

    } else if(obj.Code=='99'){

        jQuery("#message").text('Error Occured Please Try to resubmit.');
        jQuery("#message").css('display', "block");
        jQuery( ".ajax_loader" ).css('display',"none");
        jQuery("#leadsubmit").css('display', "block");

        return false;

    }else{

        jQuery("#message").text(obj.Message);
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


function get_msg_translation(reg_lang){

    var  text;

    if(reg_lang=='ar')
        text='شكرا لتسجيل بياناتك. اللرجاء الضغط على اللرابط التالي لتأكيد ألتسجيل.';
    else
        text='Thank you for registering. Please click on the link to confirm your registration.';

    return text;

}
