(function($) {
	$(document).ready(function() {
		var $carousel = $('.dfd-gallery-carousel'),
			slidesToShow = $carousel.data('slides'),
			autoSlideshow = $carousel.data('autoplay'),
			slideshowSpeed = $carousel.data('slideshow-speed'),
			slidesBreakpointOne,
			slidesBreakpointTwo,
			slidesBreakpointThree;
		
		if(!slidesToShow) {
			slidesToShow = 1;
		}
		if(!autoSlideshow) {
			autoSlideshow = true;
		}
		if(!slideshowSpeed) {
			slideshowSpeed = 3000;
		}
		slidesBreakpointOne = (slidesToShow > 3) ? 3 : slidesToShow;
		slidesBreakpointTwo = (slidesToShow > 2) ? 2 : slidesToShow;
		slidesBreakpointThree = 1;
		
		$carousel.slick({
			infinite: true,
			slidesToShow: slidesToShow,
			slidesToScroll: 1,
			arrows: false,
			dots: false,
			autoplay: autoSlideshow,
			autoplaySpeed: slideshowSpeed,
			responsive: [
				{
					breakpoint: 1280,
					settings: {
						slidesToShow: slidesBreakpointOne,
						infinite: true,
						arrows: false
					}
				},
				{
					breakpoint: 1024,
					settings: {
						slidesToShow: slidesBreakpointTwo,
						infinite: true,
						arrows: false,
					}
				},
				{
					breakpoint: 640,
					settings: {
						slidesToShow: slidesBreakpointThree,
						slidesToScroll: 1,
						arrows: false,
					}
				}
			]
		});
	});
})(jQuery);