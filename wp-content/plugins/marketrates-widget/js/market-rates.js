(function($) {

    $(".tabs a").click(function(event) {
        event.preventDefault();

        $('.asset-outer-container').hide();
        $('.asset-category-container').hide();
        $('.asset-outer-container').removeClass("active");
        $('.asset-category').removeClass("active");
        $('.asset-name').removeClass("active");


        $(this).addClass("active");
        $('#'+$(this).attr("href").split("#").pop()).addClass("active");


        $('#'+$(this).attr("href").split("#").pop()).show();


        $(('#'+$(this).attr("href").split("#").pop())+ ' li:first-child a').addClass("active");


        $('#'+$(('#'+$(this).attr("href").split("#").pop())+ ' li:first-child a').attr("href").split("#").pop()).show();
    });

    $(".inner-tabs a").click(function(event) {

        event.preventDefault();
        $('.asset-outer-container').hide();
        $('.asset-name').removeClass("active");

        $(this).addClass("active");
        $('#'+$(this).attr("href").split("#").pop()).show();
    });

})(jQuery);