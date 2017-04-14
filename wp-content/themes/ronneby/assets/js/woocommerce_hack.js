var add_to_cart_button;

(function($){
	"use strict";
	var supports_html5_storage = ( 'sessionStorage' in window && window.sessionStorage !== null );
	if (supports_html5_storage) { sessionStorage.clear(); }

	$(document).ready(function(){
		if($('body').hasClass('single-product')) {
			if ($('.ul-dropdown-toggle').length>0)
				$('.ul-dropdown-toggle').dropdown();
			if ($('.variations .value select').length>0)
				$('.variations .value select').dropkick();
		}
		/*
		if (!('ontouchstart' in window)) {
			$('.products-slider ul.products .product').hover(function() {
				var $parent = $(this).parents('.products-slider');

				$parent.css({
					'padding-bottom': '160px',
					'margin-bottom': '-160px'
				});
			}, function() {
				var $parent = $(this).parents('.products-slider');

				$parent.css({
					'padding-bottom': '0',
					'margin-bottom': '0'
				});
			});
		}*/
		
		$('body').on('adding_to_cart', function(trigger, button) {
			add_to_cart_button = button;
		});
		
		$('body').on('added_to_cart', function (trigger) {
			if (add_to_cart_button != undefined) {
				var $woo_entry_thumb = $(add_to_cart_button).parents('li.product').find('div.woo-entry-thumb');
				var $added_to_cart_notice = $('<div class="added-to-cart-notice moon-checkmark">Added to cart</div>');
				
				if ($woo_entry_thumb.length > 0) {
					$woo_entry_thumb.append($added_to_cart_notice);
					$added_to_cart_notice.stop().animate({opacity: 1}, 800).delay( 1800 ).animate({opacity: 0}, 800, function() {$(this).remove()});
				}
				add_to_cart_button = null;
			}
		});
		/*
		(function(){
			var woo_get_products_class = function($this, init_class) {
				var w = $this.width();
				var el_class;
				switch(true) {
					case ( w < 780 ): el_class = 'six'; break;
					case ( w < 860 ): el_class = 'four'; break;
					default: el_class = init_class;
				}
				
				return el_class;
			};
			
			$('.woocommerce > ul.products.row').each(function(){
				var $this = $(this);
				var $els = $this.children('li.columns');
				if ($els.length == 0) {
					return true;
				}
				
				var init_class = 'four';
				if ($els.hasClass('three')) {
					init_class = 'three'
				}
				
				var woo_resize_products = function() {
					var c = woo_get_products_class($this, init_class);
					$els.removeClass('three four six').addClass(c);
				};
				
				$(window).on('load resize', woo_resize_products);
			});
		})();
		$('#show-hide-reviews').unbind('click').on('click touchend', function(e) {
			e.preventDefault();
			$(this).siblings('#review_form').slideToggle();
		});
		*/
		
		/* Plus-minus buttons customization */
		$('.single_add_to_cart_button_wrap .quantity').each(function(){
			var inputNumber, min, max, $self = $(this);
			if($self.length > 0) {
				$self.prepend('<i class="dfd-icon-down_2 minus">').append('<i class="dfd-icon-up_2 plus">');
				$self.find('.minus').on('click touchend', function() {
					inputNumber = $(this).siblings('.qty');
					min = inputNumber.attr('min');
					max = inputNumber.attr('max');
					var beforeVal = +inputNumber.val();
					var newVal = (beforeVal > min || !min) ? +beforeVal - 1 : min;
					inputNumber.val(newVal);
					$(this).parent().siblings('.single_add_to_cart_button').attr('data-quantity', newVal);
				});
				$self.find('.plus').on('click touchend', function() {
					inputNumber = $(this).siblings('.qty');
					min = inputNumber.attr('min');
					max = inputNumber.attr('max');
					var beforeVal = +inputNumber.val();
					var newVal = (beforeVal < max || !max) ? +beforeVal + 1 : max;
					inputNumber.val(newVal);
					$(this).parent().siblings('.single_add_to_cart_button').attr('data-quantity', newVal);
				});
			}
			$self.find('.qty').on('input propertychange',function() {
				$('.single_add_to_cart_button').attr('data-quantity', $(this).val());
			});
			if($('.wcmp-quick-view-wrapper').length > 0)
				$('.wcmp-quick-view-wrapper form.cart .single_add_to_cart_button').removeClass('product_type_simple');
		});
		/*
		var paymentSection = $('#payment .payment_methods.methods');
		var paymenyMethodsDesc = function() {
			paymentSection.find('li input[type="radio"]').each(function() {
				if($(this).is(':checked')) {
					$(this).siblings('.payment_box').show();
					$(this).parents('li').siblings().find('.payment_box').hide();
					console.log($(this).attr('class'));
				}
			});
		};
		paymenyMethodsDesc();
		paymentSection.find('li input[type="radio"]').change(function() {
			paymenyMethodsDesc();
		});
		*/
	});
	
	var products_li_eq_height = function() {
		jQuery('.products.row').each(function() {
			$(this).find('.product').equalHeights();
		});
	};
	$(document).ready(products_li_eq_height);
	$(window).on('load resize', products_li_eq_height);
	
})(jQuery);
