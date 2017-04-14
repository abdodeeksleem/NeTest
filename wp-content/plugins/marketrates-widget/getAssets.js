(function($) {

    // run get comment function and poll api for comments
    get_assets();

    // set interval to check every 5 seconds
    setIntervalX(function () {
        get_assets();
    }, 5000, 5);


    function setIntervalX(callback, delay, repetitions) {
        var x = 0;
        var intervalID = window.setInterval(function () {

            callback();

            if (++x === repetitions) {
                window.clearInterval(intervalID);
            }
        }, delay);
    }


    /**
     * get_comments function.
     *
     */
    function get_assets() {

        $.ajax({
            url: '/wp-content/plugins/marketrates-widget/getAssets.php',
            dataType: 'json',
            type: 'GET',
            success: function(data) {
                // send data to processing function
                process_assets_data( data );
            },
            error: function() {
                console.log('Error with API');
            }
        });

    }

    /**
     * process_comment_data function.
     *
     */
    function process_assets_data( data ) {

        var json = jQuery.parseJSON(data);

        $.each(json, function() {
            $.each(this, function(k, v) {
                if (k=="Rates") {
                    $.each(v, function( index, value ) {
                        $('.'+value['Name']).text(value['Ask']);
                    });
                }
            });
        });
    }

})(jQuery);

