(function($){
	"use strict";
	
	$(document).ready(function($){
		var addAudioPlayer = function() {
			$('.post.format-audio').each(function() {
				if(!$(this).find('div.audioplayer').length && $(this).find('audio').length) {
					$('audio').audioPlayer();
				}
			});
		};
		addAudioPlayer();
		if($('.post').length > 0) {
			$('.post').parent().observeDOM(function(){ 
				addAudioPlayer();
			});
		}
	});
})(jQuery);
