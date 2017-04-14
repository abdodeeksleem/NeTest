;
var screen_medium = 800;
(function ($, window, undefined) {
    'use strict';

    var $doc = $(document),
        Modernizr = window.Modernizr;
	
	$.fn.sbAccordion = function() {
		var settings = {
			speed: 300
		};
		
		return this.each(function(){
			var $accordion = $(this);
			var $lis = $accordion.children('li');
			
			$accordion.find('.title').click(function(){
				var $this = $(this);
				var $li = $this.parent('li');
				
				if ($li.hasClass('active')) {
					return false;
				}
				
				$this.siblings('.content').slideDown(settings.speed);
				$lis.filter('.active').removeClass('active')
					.children('.content').slideUp(settings.speed);
				$li.addClass('active');
				
				return false;
			});
		});
	};
	
    $(document).ready(function () {
		$('ul.accordion').sbAccordion();
        $.fn.foundationAlerts ? $doc.foundationAlerts() : null;
        $.fn.foundationButtons ? $doc.foundationButtons() : null;
//        $.fn.foundationAccordion ? $doc.foundationAccordion() : null;
        $.fn.foundationNavigation ? $doc.foundationNavigation() : null;
        $.fn.foundationTopBar ? $doc.foundationTopBar() : null;
        $.fn.foundationCustomForms ? $doc.foundationCustomForms() : null;
        $.fn.foundationMediaQueryViewer ? $doc.foundationMediaQueryViewer() : null;
        $.fn.foundationTabs ? $doc.foundationTabs({callback: $.foundation.customForms.appendCustomMarkup}) : null;
        $.fn.foundationTooltips ? $doc.foundationTooltips() : null;
        $.fn.foundationMagellan ? $doc.foundationMagellan() : null;
        $.fn.foundationClearing ? $doc.foundationClearing() : null;

        $.fn.placeholder ? $('input, textarea').placeholder() : null;
    });

    // Hide address bar on mobile devices (except if #hash present, so we don't mess up deep linking).
    if (Modernizr.touch && !window.location.hash) {
        $(window).load(function () {
            setTimeout(function () {
                window.scrollTo(0, 1);
            }, 0);
        });
    }
	
})(jQuery, this);


/*---------------------------------
 Correct OS & Browser Check
 -----------------------------------*/

var ua = navigator.userAgent,
    checker = {
        os: {
            iphone: ua.match(/iPhone/),
            ipod: ua.match(/iPod/),
            ipad: ua.match(/iPad/),
            blackberry: ua.match(/BlackBerry/),
            android: ua.match(/(Android|Linux armv6l|Linux armv7l)/),
            linux: ua.match(/Linux/),
            win: ua.match(/Windows/),
            mac: ua.match(/Macintosh/)
        },
        ua: {
            ie: ua.match(/MSIE/),
            ie6: ua.match(/MSIE 6.0/),
            ie7: ua.match(/MSIE 7.0/),
            ie8: ua.match(/MSIE 8.0/),
            ie9: ua.match(/MSIE 9.0/),
            ie10: ua.match(/MSIE 10.0/),
            opera: ua.match(/Opera/),
            firefox: ua.match(/Firefox/),
            chrome: ua.match(/Chrome/),
            safari: ua.match(/(Safari|BlackBerry)/)
        }
    };


/*---------------------------------
 DOM mutation
 -----------------------------------*/
(function ($) {
	'use strict';
	$.fn.observeDOM = function(callback){
		var MutationObserver = window.MutationObserver || window.WebKitMutationObserver,
			eventListenerSupported = window.addEventListener,
			$self = $(this)[0];

		if($self) {
			if( MutationObserver ){
				// define a new observer
				var obs = new MutationObserver(function(mutations){
					if( mutations[0].addedNodes.length || mutations[0].removedNodes.length )
						callback();
				});
				// have the observer observe foo for changes in children
				obs.observe( $self, { childList:true });
			} else if( eventListenerSupported ){
				$self.addEventListener('DOMNodeInserted', callback, false);
				$self.addEventListener('DOMNodeRemoved', callback, false);
			}
		}
		return this;
	};
})(jQuery);

/*---------------------------------
 Navigation dropdown
 -----------------------------------*/
(function ($) {
	$.bindMobileMenu = function() {
		if($('#header-container').hasClass('header-style-3') || $('#header-container').hasClass('header-style-4')) {
			var $mobileMenu = $('<ul />');
			$('ul.menu-clonable-for-mobiles').each(function() {
				var $sub_menu = $(this).children().clone();
				$mobileMenu = $mobileMenu.append($sub_menu);
			});
		} else {
			var $mobileMenu = $('ul.menu-clonable-for-mobiles').clone();
		}
		$mobileMenu
				.removeAttr('id')
				.find('ul, li, a').addBack()
				.removeAttr('id');
				//.removeAttr('class');
		$mobileMenu
				.find('ul')
				.removeAttr('style');
	
		$mobileMenu
				.attr('class', 'sidr-dropdown-menu')
			.find('ul')
				.attr('class', 'sidr-class-sub-menu');
		
		$mobileMenu.find('.sub-nav > ul').each(function(){
			$(this).unwrap();
		});
		
		$mobileMenu.find('li').each(function(){
			var $self = $(this);
			if($self.find('ul').length > 0) {
				$self.find('> a').append('<i class="dfd-icon-right_2 sidr-dropdown-toggler" />');
			}
		});
		/*
		$('.dl-menuwrapper').each(function(){
			var $wrapper = $(this);
			
			$wrapper.append($mobileMenu);
			$wrapper.dlmenu({
				animationClasses: {
					classin : 'dl-animate-in-1',
					classout : 'dl-animate-out-1'
				}
			});
		});*/
		$('.sidr-inner').append($mobileMenu);
		$('#mobile-menu').sidr({
			displace: false
		});
		
		$('.sidr-dropdown-toggler').unbind('click').bind('touchend click', function(e) {
			e.preventDefault();
			$(this).parent('a').toggleClass('active').siblings('ul').slideToggle(500);
		});
		$('.dfd-sidr-close').unbind('click').bind('touchend click', function(e) {
			e.preventDefault();
			$.sidr('close');
		});
	};
})(jQuery);

/*---------------------------------
 Navigation dropdown
 -----------------------------------*/
(function ($) {
	"use strict";
	
	$(document).ready(function() {
		var $top_panel_inner = $('#top-panel-inner');
		$('a.top-inner-page').on('click', function(e){
			e.preventDefault();
			$top_panel_inner.addClass('open');
		});
		$('a.top-inner-page-close').on('click', function(e){
			e.preventDefault();
			$top_panel_inner.removeClass('open');
		});
	});
})(jQuery);

(function ($) {
	"use strict";
	$(document).ready(function() {
		$('form.wpcf7-form input:not([type="submit"])').focus(function(e){
			$(this).parent('span').addClass('active').siblings().addClass('active');
		}).blur(function() {
			if(!$(this).parents('.dfd-contact-form-style-5').length || ($(this).parents('.dfd-contact-form-style-5').length && $(this).val() == '')) {
				$(this).parent('span').removeClass('active').siblings().removeClass('active');
			}
		});
	});
})(jQuery);

(function ($) {
	"use strict";
	$(document).ready(function() {
		$('form.wpcf7-form select, .widget select').dropkick();
	});
})(jQuery);

(function($){
	"use strict";
	$.fn.dfdSocTooltips = function() {
		
		return this.each(function() {
			var $soc_icons = $(this);

			$('a', $soc_icons).each(function(){
				var $this = $(this);
				
				// If already binded
				if ($this.next('span.soc-tooltip').length > 0) {
					return false;
				}
				
				var title = $this.attr('title');
				$this.removeAttr('title');

				if (title && title.length==0) {
					return true;
				}
				var $tooltip = $(['<span class="soc-tooltip">', title, '</span>'].join(''));
				
				if($this.parent().parent().hasClass('module-soc-icons')) {
					$this.append($tooltip);
					$tooltip.css({
						'margin-left': 0
					});
				}else{
					$tooltip.insertAfter($this);
					var w = $tooltip.width();
					$tooltip.css({
						'margin-left': -Math.floor(w/2),
					});
				}
			    
			}).hover(function(){
				if($(this).parent().parent().hasClass('module-soc-icons')) return;
				if(!$(this).parent().parent().parent().hasClass('header-top-panel')) 
				$(this).next('.soc-tooltip')
					.css({
						'top': -$(this).height()
					});
				$(this).next('.soc-tooltip')
					.css({
						'left': $(this).offset().left - $(this).parent().offset().left,
					});
			});
		});
		
	};
})(jQuery);

/* Anchor smooth scroll */
(function($) { 
	"use strict";
	$(document).ready(function() {
		var $window = $(window);
		var $link = $('a.menu-link');
		$link.each(function() {
			var $self = $(this);
			var href = $self.attr('href');
			if(href && href.indexOf('#') !== -1 && href != '#') {
				href = href.substring(href.indexOf("#"));
				if($(href).length > 0) {
					var highlightCurrent = function() {
						/*var targetheight = $(href).outerHeight(true);*/
						var targetOffset = $(href).offset().top;
						if(($window.scrollTop() + $('body').offset().top) >= targetOffset /*&& $window.scrollTop() < (targetOffset + targetheight)*/) {
							/*setTimeout(function() {*/
								$self.parent().addClass('current-menu-ancestor current-menu-item').siblings().removeClass('current-menu-ancestor current-menu-item');
							/*}, 100);*/
						}
					};
					highlightCurrent();
					$window.on('load resize scroll', highlightCurrent);
					$self.on('click touchend', function(e) {
						e.preventDefault();
						$window.scrollTo(href, {duration:'slow'});
						highlightCurrent();
					});
				}
			}
		});
	});
})(jQuery);

(function($){
	"use strict";
	$.fn.dfdClientsTooltips = function() {
		
		return this.each(function() {
			var $clients = $(this);

			$($clients).mousemove(function(event){
				$(this).next('.clients-tooltip')
					.css({
						"opacity" : 1,
						"display" : "block",
						"z-index" : 3,
						"top" : event.pageY - $(this).parent().offset().top + 25,
						"left" : event.pageX - $(this).parent().offset().left + 15
					});
			}).mouseout(function(){
				$(this).next('.clients-tooltip')
					.css({
						"display" : "none",
						"opacity" : 0,
						"z-index" : -3,
						"top" : 0,
						"left" : 0
					});
			});
		});
		
	};
})(jQuery);

/*Arrows Revolution Slider*/
//TODO: remove
/*
(function($){
	"use strict";
	$(document).ready(function(){
		$(".rev_slider_wrapper").mousemove(function(e) {
			var $self = $(this);
			var $arrows = $self.find(".tp-leftarrow, .tp-rightarrow");
			var $arrowLeft = $self.find(".tp-leftarrow");
			var $arrowRight = $self.find(".tp-rightarrow");
			var offset_top = $self.offset().top;
			var offset_left = $self.offset().left;
			var container_width = $self.width();
			if(e.pageX < container_width / 2) {
				$arrowLeft.show();
				$arrowRight.hide();
			} else {
				$arrowLeft.hide();
				$arrowRight.show();
			}
			$arrows.css({
				visibility: 'visible',
				left: (e.pageX-offset_left),
				top: (e.pageY-offset_top)
			});
		}).mouseout(function(e) {
			$(this).find(".tp-leftarrow, .tp-rightarrow").css('visibility', 'hidden');
		});
	}); 
})(jQuery);
*/
/*END Arrows Revolution Slider*/

(function($){
	"use strict";
	/* Pricing table columns width */
	$.fn.pricingTableEqColumns = function() {
		var $columns = $(this);
		var width = (100 / $columns.length);
		$columns.css('width', width+'%');
		
		return this;
	};
})(jQuery);

(function($){
	"use strict";
	/* Item width fixer */
	$.fn.elementFixedWidth = function() {
		$(this).each(function() {
			var width = $(this).width();
			$(this).css('width', width+'px');
		});
		
		return this;
	};
})(jQuery);
/*
(function($){
	"use strict";
	// Blur on hover 
	$.fn.vagueBlur = function() {
		$(this).each(function() {
			var $vague = $(this).find('.blur-me').Vague({
				intensity: 10
			});
			$(this).hover(function() {
				$vague.blur();
			},function() {
				$vague.unblur();
			});
		});
		
		return this;
	};
	$(document).ready(function() {
		$('.blur-hover-elem').vagueBlur();
	});
})(jQuery);

(function($){
	"use strict";
	// Unblur on hover
	$.fn.vagueUnblur = function() {
		$(this).each(function() {
			var $vague = $(this).find('.unblur-me').Vague({
				intensity: 10
			});
			$vague.blur();
			$(this).hover(function() {
				$vague.unblur();
			},function() {
				$vague.blur();
			});
		});
		
		return this;
	};
	$(window).load(function() {
		$('.unblur-hover-elem').vagueUnblur();
	});
})(jQuery);

(function($) {
	"use strict";
	// Pixastic blur
	$.fn.imageBlur = function() {
		return $(this).each(function() {
			var $self = $(this);
			if($self.hasClass('already-blured')) return;
			var img = $self.find('img');
			img.clone().addClass("image-blured").css('opacity', '').appendTo(this);
			var to_be_blured = $('.image-blured', this);
			to_be_blured.each(function(index, element) {
				if (img[index].complete == true) {
					Pixastic.process(to_be_blured[index], "blurfast", {amount:3});
				} else {
					to_be_blured.load(function () {
						Pixastic.process(to_be_blured[index], "blurfast", {amount:3});
					});
				}
			});
			$self.addClass('already-blured');
		});
	};
	$(window).load(function() {
		$('.unblur-onhover').imageBlur();
	});
})(jQuery);
(function($){
	"use strict";
	// Mouseenter and mouseleave class adder
	$.fn.styledButtonsAnimator = function() {
		$(this).each(function() {
			var $self = $(this);
			var mainItem = $(this).find('span.main-item');
			var secondItem = $(this).find('span.secondary-item');
			if($self.hasClass('read-more') === false) {
				$self.hover(function() {
					mainItem.stop().animate({
						'top': '100%',
						'opacity': '0'
					}, 200)
							.animate({
								'top': '-100%',
								'left': '0',
								'opacity': '0'
							},200);
					secondItem.stop().animate({
						'top': '0',
						'opacity': '1',
						'visibility': 'visible'
					}, 200);
				},function() {
					secondItem.stop().animate({
						'top': '100%',
						'visibility': 'hidden',
						'opacity': '0'
					}, 200)
							.animate({
								'top': '-100%',
								//'left': '-300%',
								'opacity': '0',
								'visibility': 'hidden'
							}, 200);
					mainItem.stop().animate({
						'top': '0',
						'left': '0',
						'opacity': '1'
					}, 200);
				});
			}
		});
		
		return this;
	};
})(jQuery);
// Check if works ok start
(function($) {
	"use strict";
	$.fn.menuClassAdder = function() {
		$(this).each(function() {
			var $self = $(this);
			$self.on('mouseleave', function(e) {
				setTimeout(function() {
					$self.find('.top-line').remove();
				}, 300);
			});
			$self.on('mouseenter', function(e) {
				var relTarget = e.relatedTarget;
				var cameFrom = relTarget !== null ? relTarget.getAttribute('ID') : '';
				var nextElID = $self.next().attr('id');
				var nextElTitleID = $self.next().find('.item-title').attr('id');
				$self.append('<span class="top-line"></span>')
				if(cameFrom === nextElID || cameFrom === nextElTitleID) {
					$self.find('.top-line').css('right', 0).animate({'width': '100%'}, 300);
					$self.next().find('.top-line').css({'left': 0, 'right': 'auto'}).animate({'width': '0%'}, 300);
					setTimeout(function() {$self.next().find('top-line').remove();},300);
				} else {
					$self.find('.top-line').css('left', 0).animate({'width': '100%'}, 300);
					var topLine = $self.prev().find('.top-line');
					if(topLine) {
						topLine.css({'right': 0, 'left': 'auto'}).animate({'width': '0%'}, 'slow');
						setTimeout(function() {topLine.remove();},300);
					}
				}
			});
		});
	};
})(jQuery);
// Check if works ok end
*/
(function($){
	"use strict";
	/* Pricing table columns width */
	$.fn.products_thumbnails_carousel = function(num, ver) {
		var obj = $(this);
		var responsive_point_one = (num > 1) ? num - 1 : 1;
		var responsive_point_two = (responsive_point_one > 1) ? responsive_point_one - 1 : 1;
		obj.slick({
			infinite: true,
			slidesToShow: num,
			slidesToScroll: 1,
			arrows: false,
			dots: false,
			autoplay: true,
			autoplaySpeed: 2000,
			vertical: ver,
			responsive: [
					{
						breakpoint: 800,
						settings: {
							slidesToShow: responsive_point_one,
							slidesToScroll: 1,
							infinite: true,
							arrows: false,
							dots: false,
							vertical: false
						}
					},
					{
						breakpoint: 500,
						settings: {
							slidesToShow: responsive_point_two,
							slidesToScroll: 1,
							arrows: false,
							dots: false,
							vertical: false
						}
					}
				]
		});
		
		return this;
	};
})(jQuery);
/*
(function($){
	"use strict";
	$.fn.headerSocIconsShowHide = function() {
		$(this).each(function(){
			//var $label = $(this).find('.label');
			
			$(this).click(function(){
				var $popup = $(this).siblings('.soc-icons');
				
				$popup.slideToggle('slow')

				return false;
			});
		});
	};
})(jQuery);
*/
(function($){
	"use strict";
	/* Pricing table columns width */
	var dfdFixedFooter = function() {
		if(!$('#layout').hasClass('one-page-scroll') && $('#main-wrap').hasClass('dfd-parallax-footer')) {
			var margin =  ($(window).width() > 780) ? $('#footer-wrap').outerHeight(true) : 0;
			if($('body > .boxed_layout').length > 0) {
				$('body > .boxed_layout').css('margin-bottom', margin);
			} else {
				$('#main-wrap').css('margin-bottom', margin);
			}
		}
	};
	$(document).ready(function() {
		dfdFixedFooter();
		$(window).on('load resize', dfdFixedFooter);
	});
})(jQuery);

(function($){
	"use strict";
	/* Pricing table columns width */
	$.fn.dfdRowDelimiterBg = function() {
		return this.each(function() {
			var $delimiters = $(this);
			var bg_color = $delimiters.parents('.vc-row-wrapper').css('background-color');
			$delimiters.css('background-color', bg_color);
		});
	};
	$(document).ready(function() {
		$('.vc-row-delimiter-top-left, .vc-row-delimiter-top-right, .vc-row-delimiter-bottom-left, .vc-row-delimiter-bottom-right').dfdRowDelimiterBg();
	});
})(jQuery);

(function($){
	"use strict";
	// Cache the Window object
	var $window = $(window), windowScrollTop, windowHeight, windowWidth;
	
	var recalcWindowOffset = function() {
		windowScrollTop = $window.scrollTop();
	};

	var recalcWindowInitHeight = function() {
		windowHeight = $window.height();
		windowWidth = $window.width();

		recalcWindowOffset();
	};
	
	
	var scrollbarWidth;
	$(document).ready(function() {
		var div = document.createElement('div');

		div.style.overflowY = 'scroll';
		div.style.width =  '50px';
		div.style.height = '50px';

		div.style.visibility = 'hidden';

		document.body.appendChild(div);
		scrollbarWidth = div.offsetWidth - div.clientWidth;
		document.body.removeChild(div);

	});

	recalcWindowOffset();
	$window
			.on("resize load", recalcWindowInitHeight)
			.on("scroll", recalcWindowOffset);
	
	$.loadRetinaLogo = function() {
		if (('devicePixelRatio' in window) && (window.devicePixelRatio > 1)) {
			$('.logo-for-panel img').each(function(){
				var $logo = $(this);
				var retina_src = $logo.attr('data-retina');

				if (!retina_src || retina_src.legth===0) {
					return;
				}

				var w = $logo.attr('data-retina_w');
				var h = $logo.attr('data-retina_h');

				var max = {w: 164, h: 54};

				$logo.attr('src', retina_src);

				if (w<max.w && h<max.h) {
					$logo.css({
						width: Math.round(w/2) + 'px',
						height: Math.round(h/2) + 'px'
					});
				}
			});
		}
	};
	
	$.bindHeaderEvents = function() {
		var $header_container = $("#header-container");
		var disable_body_hover = function() {
			$header_container.addClass('disable-hover').addClass('slide-up');
			
			setTimeout(function(){
				$header_container.removeClass('disable-hover');
			}, 400);
			setTimeout(function(){
				$header_container.removeClass('slide-up');
			}, 500);
		};
		
		var headroom_on_top = function() {
			disable_body_hover();
			
			//$header_container.trigger('side-aray-show');
		};
		var headroom_not_top = function() {
			disable_body_hover();
			
			//$header_container.trigger('side-aray-hide');
		};


		var headroom = new Headroom(document.querySelector("#header-container"), {
			 tolerance : {
				up : 0,
				down : 0
			},
			offset: 0,
			classes: {
				initial: "animated--header",
				notTop: "small"
			},
			onTop : headroom_on_top,
			onNotTop : headroom_not_top
		});
		$header_container = jQuery('#header-container');
		
		var header_width, hcH, header_wrap_height, header_logo_height, header_bottom_height;
		
		var $header_wrap = $header_container.find('.header-wrap');
		var $stuning_header = $('#stuning-header');
		var $menu_fixer = $('#menu-fixer');
		
		var header_el_sizing = function() {
			header_width = $('#main-wrap').width();
			
			$header_container.find('.dfd-top-row').width(header_width);
			/* menu fixer */
			
			hcH = ($header_container.find('.dfd-top-row').length) ? $header_container.find('.dfd-top-row').outerHeight() : $header_container.find('#header').outerHeight();
			
			if ($stuning_header.length > 0) {
				if (
					$menu_fixer.length === 0
					&& (!$header_container.hasClass('dfd-header-layout-fixed')
					|| $header_container.hasClass('dfd-keep-menu-fixer'))
				) {
					$menu_fixer = $('<div id="menu-fixer"></div>');
				}
				$stuning_header.prepend($menu_fixer);
			} else {
				if (
					$header_container.hasClass('dfd-header-layout-fixed') || $('#main-wrap').hasClass('dfd-one-page-scroll-layout') || $header_container.hasClass('menu-position-bottom')
				) {
					if ($menu_fixer.length > 0) {
						$menu_fixer.remove();
					}
				} else {
					if ($menu_fixer.length === 0) {
						$menu_fixer = $('<div id="menu-fixer"></div>');
						$($menu_fixer).insertAfter('#header-container');
					}
				}
			}
			if ($menu_fixer.length > 0) {
				$menu_fixer.height(hcH);
			}
		};
		
		$window.on('load resize', header_el_sizing);
		
		if(
			Modernizr.touch === false && $header_container.hasClass('dfd-enable-headroom') && !$('#layout').hasClass('one-page-scroll')
		) {
			headroom.init();
		}
		
		var top_panel_animation = new Headroom(document.querySelector("body"), {
			tolerance: 5,
			offset: 0,
			classes: {
				initial: "animated--body",
				notTop: "moved"
			}
		});
		if(
			$('#top-panel-inner').hasClass('dfd-panel-animated')
		) {
			var $top_panel_inner = $('#top-panel-inner .top-panel-inner-wrapper');
			var set_top_panel = function() {
				var height = $window.height() - ($('body').css('margin').replace('px', '') * 2);
				$top_panel_inner.outerHeight(height);
			};
			set_top_panel();
			$top_panel_inner.wrapInner('<div class="dfd-vertical-aligned" />');
			$('.top-inner-page').remove();
			top_panel_animation.init();
			$window.on('load resize', set_top_panel);
		}
		
		
		/*---------------------------------
			Mega Menu (if enabled)
		-----------------------------------*/
		/*
		if (typeof $.cloneMenuItems === 'function') {
			$.cloneMenuItems();
		}
		
		if (typeof $.hideShowMenuItems === 'function') {
			$.hideShowMenuItems();
		}
		*/
		if (typeof $.initSlider === 'function') {
			setTimeout(function() {
				$.initSlider();
			}, 500);
		}
		if (typeof $.runMegaMenu === 'function') {
			$.runMegaMenu();
		}
		
		/*---------------------------------
		* Header button * 
		---------------------------------*/
		$window.on('load resize scroll', function() {
			var documentHeight = $('body').outerHeight();
			var footerHeight = $('#footer-wrap').outerHeight();
			if(windowScrollTop >= (documentHeight - windowHeight - footerHeight)) {
				$('.header-button-section > a').addClass('active');
			} else {
				$('.header-button-section > a').removeClass('active');
			}
		});
		
		/* -------------------------------
			Menu titles animation
		 -------------------------------*/
		$('#header-container .nav-menu .mega-menu-item.menu-item-depth-0').each(function() {
			
		});

		/*---------------------------------
			Drop-down
		-----------------------------------*/
		$('.sel-dropdown').unbind('hover').hover(function(){
			jQuery(this).addClass("hovered");
		}, function(){
			jQuery(this).removeClass("hovered");
		});

		/*---------------------------------
			Menu animation
		-----------------------------------*/
		jQuery(".nav-item.has-submenu > a").on('click', function() {
			var $self = $(this);
			if ($self.attr('href') != '#' && $self.attr('href') != '' && $self.hasClass('open')) {
				window.location.href = $self.attr('href');
			}
			
			return false;
		});
		/*
		jQuery(".nav-item.has-submenu > a").on('click', function(){
			if($window.width()>screen_medium) return true;

			var $this = $(this).parent();

			if ($this.hasClass("hovered")) {
				$this
					.removeClass("hovered")
					.find(".sub-nav").stop().slideUp(200);
			} else {
				if ($this.siblings().length>0) {
				$this.siblings('.hovered')
					.removeClass("hovered")
					.find(".sub-nav").stop().slideUp(200);
				}

				$this
					.addClass("hovered")
					.find(".sub-nav").stop().slideDown(200);
			}

			return false;
		});
		$('.top-menu-button').on('click', function(){
			var $this = $(this);
			var $menu = $($this.attr('data-href')).parent('.mega-menu');

			$menu.slideToggle(200, function(){
				if ($menu.is(':visible')) {
					$this.removeClass("inactive");
				} else {
					$this.addClass("inactive");
				}
			});

			return false;
		});
*/
		
		/*---------------------------------
			Search Form
		-----------------------------------*/
		/*Search form on hover
		(function(){
			var search_show = function($this) {
				var $search = $this.find('.search-query');
				var $button = $('#searchsubmit');

				$button.attr('disabled', true);

				if ($search.is(':focus')) {
					return;
				}
				$('.form-search', $this).addClass('open');
				if (!$search.attr('data-width')) {
					$search.attr('data-width', parseInt($search.css('width')));
				}
				var search_width = parseInt($search.attr('data-width'));

				$search.stop()
					.css({
						width: 0
					})
					.show()
					.animate({
						width: search_width
					}, function() {
						$button.attr('disabled', false);
					});
			};

			var search_hide = function($this, hide) {
				var $search = $this.find('.search-query');
				var $button = $('#searchsubmit');

				if (hide !== true) {
					$button.attr('disabled', true);
				}

				if ($search.is(':focus') && hide == undefined) {
					return;
				}
				if (!$search.attr('data-width')) {
					$search.attr('data-width', parseInt($search.css('width')));
				}
				$('.form-search', $this).removeClass('open');
				var search_width = parseInt($search.attr('data-width'));

				$search.stop()
					.css({
						width: search_width
					})
					.animate({
						width: 0
					}, function() {
						$(this).hide();
						$button.attr('disabled', false);
					});
			};

			$('.form-search-wrap .search-query').unbind('blur').blur(function(){
				search_hide($(this).parents('.form-search-wrap'), true);
			});

			if (Modernizr.touch === false) {
				$('.form-search-wrap')
					.unbind('hover').hover(function(){
						search_show($(this));
					}, function(){
						search_hide($(this));
					});
			} else {
				$('#searchsubmit').unbind('click').on('click touchend', function(){
					if (!$('.form-search-wrap .search-query').is(':visible')) {
						search_show($(this).parents('.form-search-wrap'));
						return false;
					}
				});
			}
		})(jQuery);*/
		
		(function($) {
			"use strict";
			var button = $('.header-search-switcher');
			var form = $('.form-search-section');
			button.unbind('click').on('click touchend', function() {
				form.fadeToggle(250, function() {
					if (form.is(':visible')) {
						button.addClass("active");
					} else {
						button.removeClass("active");
					}
				});
				return false;
			});
		})(jQuery);
		
		(function($) {
			"use strict";
			var container = $('#header-container.header-style-6 .onclick-menu-wrap');
			var button = $('.dfd-click-menu-activation-button a', container);
			var menu = $('nav.onclick-menu', container);
			button.unbind('click').on('click touchend', function(e) {
				e.preventDefault();
				if ($(this).hasClass('opened')) {
					button.removeClass('opened');
				} else {
					button.addClass('opened');
				}
				menu.slideToggle(250);
			});
		})(jQuery);
		
		/* Header woocommerce cart, wishlist */
		var header_items_timeout = function(el_first, el_second) {
			var box_timer;
			$(el_first).hover(function() {
				if (box_timer != undefined) {
					clearTimeout(box_timer);
				}
				$(el_second, $(this)).css('max-height', $window.height() - $('#header > .header-wrap').height() - 40).fadeIn(300);
			}, function() {
				var $this = $(this);
				box_timer = setTimeout(function() {
					$(el_second, $this).fadeOut(300);
				},0);
			});
		};
		
		//header_items_timeout('.total_cart_header', '> .shopping-cart-box');
		//$('.pop-up-soc-icons > a').headerSocIconsShowHide();
		
		(function($) {
			"use strict";
			var button = $('.dfd-menu-button');
			var headerContainer = $('#header-container');
			button.unbind('click').on('click touchend', function(e) {
				e.preventDefault();
				headerContainer.toggleClass('opened');
			});
		})(jQuery);
		
		(function($) {
			$(document).ready(function() {
				$('#dfd-side-header-activation-button').unbind('click').bind('click touchend', function(e) {
					e.preventDefault();
					$(this).parents('#header-container').toggleClass('active');
				});
			});
		})(jQuery);

		$.loadRetinaLogo();

		/*---------------------------------
		 Bind Mobile Menu
		 -----------------------------------*/
		$.bindMobileMenu();
	};
	
	var widget_title_decoration_16 = function(only_resize) {
		return;
		var class_list = [
			'.widget-title-decoration-16',
			'.widget-title-decoration-lines_black',
			'.widget-title-decoration-lines_blue',
			'.widget-title-decoration-lines_purple'
		];
		$(class_list.join(',')).each(function() {
			var $this = $(this);
			
			if (only_resize == undefined || only_resize !== true) {
				$('> span', $this).wrap('<span></span>');
			}
			
			if ($this.next().hasClass('widget-sub-title') && $('> span', $this.next().length > 0)) {
				if ($('> span', $this.next()).width() > $('> span', $this).width()) {
					$('> span', $this).innerWidth($('> span', $this.next()).width());
				}
			}
		});
	};
	
	window.widget_title_decoration_sub_subtitle = function(only_resize) {
		var class_list = [
			'.widget-title-decoration-0',
			'.widget-title-decoration-underline_solid',
			'.widget-title-decoration-uppercase_underline_solid',
			'.widget-title-decoration-underline_small',
			'.widget-title-decoration-uppercase_underline_small',
			'.widget-title-decoration-background_main_color',
			'.widget-title-decoration-uppercase_background_main_color',
			'.widget-title-decoration-underline_label',
			'.widget-title-decoration-uppercase',
		];
		
		$(class_list.join(',')).each(function() {
			var $title = $(this);
			var $subtitle = $title.siblings('.widget-sub-title, .subtitle');
			
			if ($subtitle.length == 0) {
				return true;
			}
			
			if (!only_resize) {
				$subtitle.insertBefore($title);
			}
			
		});
	};
	/** TODO: DEPRECATED
	var widget_title_decoration_with_icons = function(only_resize) {
		var class_list = [
			'.widget-title-decoration-icon_gray',
			'.widget-title-decoration-icon_black',
			'.widget-title-decoration-icon_blue',
			'.widget-title-decoration-icon_purple'
		];
		$(class_list.join(',')).each(function(){
			var $this = $(this);
			
			if (only_resize == undefined || only_resize !== true) {
				$('> span', $this).wrap('<span></span>');
			}
		});
	}
	
	$window.on("load", function () {
		widget_title_decoration_16();
		widget_title_decoration_sub_subtitle();
	}).on("resize", function () {
		widget_title_decoration_16(true);
		widget_title_decoration_sub_subtitle(true);
	});
	*/
	jQuery(document).ready(function($) {
		"use strict";
		$.bindHeaderEvents();
		
		// Widget title decoration
		$('.widget-title-decoration-9, .widget-title-decoration-10, .widget-title-decoration-11, .widget-title-decoration-12').each(function() {
			var $this = $(this);
			
			if ($('> i', $this).length > 0) {
				$('> span', $this).prepend($('> i', $this).clone()).css('display', 'inline-block');
				$('> i', $this).remove();
			}
		});
				
		//widget_title_decoration_with_icons();
		
		// Bind Soc Tooltips
		$('.soc-icons').dfdSocTooltips();
		$('.client-tile').dfdClientsTooltips();
		$('.widget_dfd_author').each(function() {
			$('.widget.soc-icons.dfd-soc-icons-hover-style-13 a', $(this)).pricingTableEqColumns();
		});

		$window.on("resize", function () {
			var $tiled_menu = $('.mega-menu, .sub-nav', '#header');
			if (windowWidth >= screen_medium) {
				$tiled_menu.each(function(){
					if (!$(this).is(':visible')) {
						$(this).removeAttr('style');
					}
				});
			}
		});
		
		$('#footer .widget_nav_menu >ul >li').equalHeights();
		
		////@TODO: Remove copypaste (mvb main.js);
		//var row_fullheight = ($('.mvb_container .row-wrapper:first').hasClass('mvb-row-fullheight')) ? true : false;
		
		/*---------------------------------
		 Scroll To Top
		 -----------------------------------*/
		var $back_to_top = jQuery('.body-back-to-top');
		$window.on('scroll', function() {
			if ($back_to_top.length>0) {
				if(jQuery(window).scrollTop() > 80) {
					$back_to_top.stop().animate({bottom: 40, opacity: 1}, 700);
				} else {
					$back_to_top.stop().animate({bottom: -40, opacity: 0}, 700);
				}
			}
		});

		var duration = 800;
		jQuery('.back-to-top, .body-back-to-top').click(function (event) {
			event.preventDefault();
			jQuery('html, body').animate({scrollTop: 0}, duration);
			return false;
		});

		/*
		 * MVB: Facts
		 */
		$('.fact-num').not('.circle').each(function(){
			var $this = $(this);
			var eq = function() {
				var diff = $this.find('.val').width() + 20;
				$this.find('.line').css('left', diff);
			};

			eq(); $this.bind('dfd-update', eq);
		});

		$('.fact-num.circle').each(function(){
			var $this = $(this);
			var eq = function() {
				var diff = $this.find('canvas').width() + 20;
				$this.find('.line').css('left', diff);
			};

			eq();  $this.bind('dfd-update', eq);
		});
		
		$('.chaffle').chaffle({
			speed: 20,
			time: 60
		});
		
		/* Pricing table columns width */
		//$('.pricetable-column').pricingTableEqColumns();
		
		/*---------------------------------
		 Zoom images
		 -----------------------------------*/
		/*
		jQuery('.entry-content a').has('img').addClass('prettyPhoto');

		jQuery('.entry-content a img').click(function () {
			var desc = jQuery(this).attr('title');
			jQuery('.entry-content a').has('img').attr('title', desc);
		});
		*/
		jQuery("a[data-rel^='prettyPhoto'], a.zoom-link, a.thumbnail, a[class^='prettyPhoto']").prettyPhoto({hook: 'data-rel',show_title: true});
		jQuery("a[rel^='prettyPhoto']").prettyPhoto(); //
	});
	/*
	$(window).resize(function() {
		if (typeof $.hideShowMenuItems === 'function' && typeof $.runMegaMenu === 'function') {
			$.hideShowMenuItems();
		}
	});
	*/
	/* remove header, footer and admin bar if  opened in iframe */
	$window.load(function() {
		if(window.top != window.self && $('body').hasClass('single-my-product')) {
			$('#header-container, #footer-wrap, #wpadminbar').hide();
		}
	});
   
	$.fn.dfdParallax = function() {
		return this.each(function() {
			// Store some variables based on where we are
			var $self = $(this), offsetCoords, topOffset, selfHeight;
			
			var recalcInitValues = function() {
				offsetCoords = $self.offset();
				selfHeight = $self.height();
				topOffset = offsetCoords.top;
			};
			
			recalcInitValues();
			
			$window.on("resize load", recalcInitValues);
			
			// When the window is scrolled...
			$window.on("load scroll", function() {
				// If this section is in view
				// Scroll the background at var speed
				// the yPos is a negative value because we're scrolling it UP!
				var diff = (topOffset - windowScrollTop) / 3;
				var speed = parseFloat($self.data('parallax_sense')) / 100;
				var diffPos = -(diff * 2 * speed);
				var statPos = '50%';
				var maxMinValue = parseFloat($self.data('parallax_limit'));
				// If this element has a Y offset then add it on
				if ($self.data('parallax_offset')) {
					diffPos += $self.data('parallax_offset');
				}

				// Put together our final background position
				var coords;
				if($self.hasClass('vcpb-vz-jquery')) {
					coords = statPos + ' ' + diffPos + 'px';
				}

				if($self.hasClass('vcpb-hz-jquery')) {
					coords = diffPos + 'px' + ' ' + statPos;
				}

				if($self.hasClass('dfd-row-parallax')) {
					var yPos = -(diff * speed);

					if(yPos > maxMinValue) yPos = maxMinValue;
					if(yPos < -maxMinValue) yPos = -maxMinValue;

					// Move the module
					$self.find('>.row').css({
						'-webkit-transform': 'matrix(1,0,0,1,0,'+yPos+')',
						'-moz-transform': 'matrix(1,0,0,1,0,'+yPos+')',
						'-0-transform': 'matrix(1,0,0,1,0,'+yPos+')',
						'transform': 'matrix(1,0,0,1,0,'+yPos+')'
					});
				}
				if(($self.hasClass('dfd-column-parallax'))) {
					// Move the column
					var yPos = -(diff * speed);

					if(yPos > maxMinValue) yPos = maxMinValue;
					if(yPos < -maxMinValue) yPos = -maxMinValue;

					$self.css({
						'-webkit-transform': 'matrix(1,0,0,1,0,'+yPos+')',
						'-moz-transform': 'matrix(1,0,0,1,0,'+yPos+')',
						'-0-transform': 'matrix(1,0,0,1,0,'+yPos+')',
						'transform': 'matrix(1,0,0,1,0,'+yPos+')'
					});
				}
				if (
						((windowScrollTop ) > (topOffset)) &&
						((topOffset + selfHeight) > windowScrollTop)
				) {
					if($self.hasClass('dfd-fade-on-scroll')) {
						var height = $self.height();

						// Fade the row
						$self.css({
							opacity: (1 + 1/(height/(topOffset - windowScrollTop)))
						});
					}
				}
				if (
						((windowScrollTop + windowHeight) > (topOffset)) &&
						((topOffset + selfHeight) > windowScrollTop)
				) {
					// Move the background
					$self.css({backgroundPosition: coords});

					// Check for other sprites in this section
					$('[data-dfd-type="sprite"]', $self).each(function() {

						// Cache the sprite
						var $sprite = $(this);

						// Use the same calculation to work out how far to scroll the sprite
						var yPos = -(windowScrollTop / $sprite.data('parallax_sense'));
						var coords = $sprite.data('Xposition') + ' ' + (yPos + $sprite.data('offsetY')) + 'px';

						$sprite.css({backgroundPosition: coords});

					}); // sprites

					// Check for any Videos that need scrolling
					$('[data-dfd-type="video"]', $self).each(function() {

						// Cache the video
						var $video = $(this);

						// There's some repetition going on here, so
						// feel free to tidy this section up.
						var yPos = -(windowScrollTop / $video.data('parallax_sense'));
						var coords = (yPos + $video.data('offsetY')) + 'px';

						$video.css({top: coords});

					}); // video
				} /*else {
					recalcInitValues();
				};*/ // in view
					recalcInitValues();

			}); // window scroll

		});
	};
	
	$.fn.dfdStunHeaderParallax = function() {
		var scrolledY = $(window).scrollTop();
		var $self = $(this);
		var height = $self.parent().height();
		$self.css({
			'top': ((scrolledY*0.4))+'px',
			'opacity': (1 - 1/(height/scrolledY))
		});
	};
	
	$.fn.dfdShareScroll = function() {
		var scrolledY = $(window).scrollTop();
		var $self = $(this);
		var headerHeight = $('#header').height();
		var containerTopCoord = $self.next('article').offset().top;
		var containerHeight = $self.next('article').height();
		var containerBottomCoord = containerTopCoord + containerHeight;
		var offset = $self.parent().offset().top;
		var selfMargin = $self.css('margin-top').replace("px", "");
		var height = $self.height();
		if(scrolledY > (offset - headerHeight) && scrolledY < containerBottomCoord - height - selfMargin) {
			var top = (scrolledY - offset) > 0 ? scrolledY - offset : 0;
			$self.css({
				'top': top + 'px',
			});
		};
	};
	
	$.fn.dfdFolioInsideScroll = function() {
		var scrolledY = $(window).scrollTop();
		var $self = $(this);
		var headerHeight = $('#header-container').hasClass('header-style-7') ? $('#header-container .dfd-top-row').height() : $('#header').height();
		var padding = +$self.css('padding-top').replace('px', '');
		var offset = +$self.parent().offset().top + padding;
		var containerHeight = $self.parent().height();
		var containerBottomCoord = offset + containerHeight - padding*2;
		var height = $self.find('>.row').height();
		//var metaHeight = $self.siblings('.folio-entry-media').height();
		if(scrolledY > offset -	 headerHeight && scrolledY < containerBottomCoord - height - headerHeight) {
			var top = (scrolledY - offset + headerHeight) > 0 ? scrolledY - offset + headerHeight : 0;
			$self.find('>.row').css({
				'top': top + 'px'
			});
		};
	};
	
	
	
	$(document).ready(function(){
		// Cache the Y offset and the speed of each sprite
		$('[data-type]').each(function() {
			$(this).data('offsetY', parseInt($(this).attr('data-offsetY')));
			$(this).data('Xposition', $(this).attr('data-Xposition'));
			$(this).data('parallax_sense', $(this).attr('parallax_sense'));
		});

		if (Modernizr.touch === false && !$('html').is('.lt-ie10, .lt-ie9, .lt-ie8')) {
			$('.upb_row_bg').dfdParallax();
			$('.dfd-row-parallax').dfdParallax();
			$('.dfd-column-parallax').dfdParallax();
			$('.dfd-fade-on-scroll').dfdParallax();
			// For each element that has a data-type attribute
			$(window).bind('scroll',function(e){
				$('.stuning-header-inner .page-title-inner').dfdStunHeaderParallax();
				//if($('#layout').hasClass('single-post')) {
				//	$('.share-cover').dfdShareScroll();
				//}
				if($('#layout').hasClass('single-folio') && $(window).width() > 800) {
					//$('.share-cover').dfdFolioInsideScroll();
					if($('.folio-info').hasClass('desc-left') || $('.folio-info').hasClass('desc-right')) {
						$('.folio-info').dfdFolioInsideScroll();
					}
				}
			});
		}
	});
	/*
	var scrollbarWidth;
	$(document).ready(function() {
		var div = document.createElement('div');

		div.style.overflowY = 'scroll';
		div.style.width =  '50px';
		div.style.height = '50px';

		div.style.visibility = 'hidden';

		document.body.appendChild(div);
		scrollbarWidth = div.offsetWidth - div.clientWidth;
		document.body.removeChild(div);

	});
	*/
	var eqHeightInit = function() {
		var w = jQuery(window).width() + scrollbarWidth;
		$('.features_module-eq-height .row').each(function(){
			if (w>800) {
				$(this).find('.columns').equalHeights();
			} else {
				$(this).find('.columns').equalHeightsDestroy();
			}
		});
		$('.module-eq-height .row').each(function(){
			if (w>800) {
				$(this).find('.columns').equalHeights();
			} else {
				$(this).find('.columns').equalHeightsDestroy();
			}
		});
		$('.features_tiles_module .row').each(function(){
			$(this).find('.columns').equalHeights();
		});
		$('.dfd-equal-height-children').each(function(){
			if (w>800 && !$(this).hasClass('dfd-destroy-wide')) {
				if ($(this).find('#left-sidebar.dfd-eq-height').length > 0 || $(this).find('#right-sidebar.dfd-eq-height').length > 0) {
					var $self = $(this);
					setTimeout(function() {
						$self.find('.dfd-eq-height').equalHeights();}, 1000);
				} else {
					$(this).find('.dfd-eq-height').equalHeights();
				}
				$(this).find('.dfd-eq-height').equalHeights();
			} else if ($(this).hasClass('dfd-mobile-keep-height')) {
				$(this).find('.dfd-eq-height').equalHeights();
			} else if (w>1024 && $(this).hasClass('dfd-destroy-wide')) {
				$(this).find('.dfd-eq-height').equalHeights();
			} else {
				$(this).find('.dfd-eq-height').equalHeightsDestroy();
			}
		});
		$('.vc-row-wrapper.equal-height-columns').each(function(){
			var $container = $(this);
			var $columns = $container.find('>.row >.columns');
			if($(this).hasClass('mobile-destroy-equal-heights')) {
				if (w>800) {
					$columns.equalHeights();
				} else {
					$columns.equalHeightsDestroy();
				}
			} else {
				$(this).find('>.row >.columns').equalHeights();
			}
			$columns.each(function() {
				if($(this).find('.vc-row-wrapper').length > 0) {
					$(this).addClass('dfd-bg-inside');
				}
			});
		});
		
		$('.dfd-equal-height-wrapper').each(function(){
			if($(this).hasClass('dfd-mobile-destroy-equal-heights')) {
				if (w>800) {
					$(this).find('>div').equalHeights();
				} else {
					$(this).find('>div').equalHeightsDestroy();
				}
			} else {
				$(this).find('>div').equalHeights();
			}
		});
	};
	
	$window.on("load resize", eqHeightInit);
	$window.one('scroll', eqHeightInit);
	
	var dfdFullHeightRow = function () {
		$( '.dfd-row-full-height:first' ).each( function () {
			var windowHeight,
				offset,
				fullHeight,
				$self = $(this);
				windowHeight = $window.height()
				windowWidth = $window.width();
			setTimeout(function() {
				offset = $self.offset().top;
				if($('.dfd-frame-line.line-bottom')) {
					offset += $('.dfd-frame-line.line-bottom').height();
				}
				if ( offset < windowHeight ) {
						fullHeight = windowHeight - offset - 1;
						$self.css( 'min-height', fullHeight + 'px' );
						if(windowWidth < 1025 && windowWidth > 1022) {
							$self.css( 'max-height', fullHeight + 'px' );
						}
				}
			}, 100);
		});
	};
	
	$window.on("load resize", dfdFullHeightRow);
	
	var dfdProductsListDelim = function() {
		$('.dfd-woocomposer_list .dfd-woo-product-list >li').each(function() {
			var $self = $(this);
			if(!$self.find('.dfd-list-menu-mode')) return;
			var $container = $self.find('.dfd-list-menu-mode:first-child');
			var titleWidth = 0;
			var priceWidth = 0;
			if($container.find('.box-name')) {
				titleWidth = $container.find('.box-name').width();
			}
			if($container.find('>.amount')) {
				priceWidth = $container.find('>.amount').width();
			}
			$container.find('.woo-delim').css({
				'left': titleWidth,
				'right': priceWidth
			});
		});
	};
	$window.on("load resize", dfdProductsListDelim);
	
	if($('#left-sidebar').length > 0 || $('#right-sidebar').length > 0) {
		$('#grid-folio, .works-list, #grid-posts').observeDOM(function(){
			eqHeightInit();
		});
	}
	if($('.dfd-equal-height-children').length > 0) {
		$('.dfd-equal-height-children').parent().observeDOM(function(){ 
			eqHeightInit();
		});
	}
	
	$(document).ready(function() {
		eqHeightInit();
		$('.vc-row-wrapper.equal-height-columns.aligh-content-verticaly').each(function(){
			var $container = $(this);
			var $columns = $container.find('>.row >.columns');
			$columns.each(function() {
				if($(this).find('.vc-row-wrapper').length > 0) {
					$(this).find('.vc-row-wrapper').wrapInner('<div class="dfd-vertical-aligned"></div>');
				} else {
					$(this).wrapInner('<div class="dfd-vertical-aligned"></div>');
				}
			});
		});
	});

})(jQuery);

/*---------------------------------
 Custom share buttons
 -----------------------------------*/
jQuery(document).ready(function ($) {
    var  $share_container = jQuery('.entry-share-popup, .entry-share-no-popup, .entry-share-popup-folio');

    if (jQuery($share_container).length  > 0) {
		jQuery('.entry-share-clickable > a').each(function(){
			var $closebutton = $(this).parent().parent().siblings('.entry-share-clickable-close').find('>a');
			var $popup = $(this).parent().parent().siblings('.entry-share-popup-folio');
			
			$(this).click(function(){
				$popup.show().animate({top: '0'}, 200, function () {
					$closebutton.show();
				});

				return false;
			});
			
			$closebutton.click(function() {
				$popup.animate({top: '100%'}, 200, function() {
					$closebutton.hide();
				});
				setTimeout(function() {
					$popup.hide();
				},200);
				
				return false;
			});
		});
		
		jQuery('.dfd-share-popup').unbind('click').bind('click touchend', function(e) {
			e.preventDefault();
			var $self = jQuery(this);
			$self.siblings('.entry-share-popup').toggle('slow');
			/*
			if($self.parent('.dfd-share-popup-wrap').hasClass('opened')) {
				$self.parent('.dfd-share-popup-wrap').removeClass('opened');
			} else {
				$self.parent('.dfd-share-popup-wrap').addClass('opened');
			}
			*/
		});

        jQuery('.entry-share-link-facebook', $share_container).sharrre({
            share: {
                facebook: true
            },
            template: '<a href="#"><i class="soc_icon-facebook"></i><span class="total">{total}</span></a>',
            enableHover: false,
			enableCounter: true,
            urlCurl: $share_container.data('directory') + '/inc' + '/sharrre.php',

            click: function (api, options) {
                api.simulateClick();
                api.openPopup('facebook');
            }
        });


        jQuery('.entry-share-link-twitter', $share_container).sharrre({
            share: {
                twitter: true
            },
            template: '<a href="#" class="twitter"><i class="soc_icon-twitter-3"></i><span class="total">{total}</span></a>',
            enableHover: false,
			enableCounter: true,
            urlCurl: $share_container.data('directory') + '/inc' + '/sharrre.php',
            click: function (api, options) {
                api.simulateClick();
                api.openPopup('twitter');
            }
        });



        jQuery('.entry-share-link-googleplus', $share_container).sharrre({
            share: {
                googlePlus: true
            },
            template: '<a href="#"><i class="soc_icon-google__x2B_"></i><span class="total">{total}</span></a>',
            enableHover: false,
			enableCounter: true,
            urlCurl: $share_container.data('directory') + '/inc' + '/sharrre.php',

            click: function (api, options) {
                api.simulateClick();
                api.openPopup('googlePlus');
            }
        });

        jQuery('.entry-share-link-linkedin', $share_container).sharrre({
				share: {
					linkedin: true
				},
				template: '<a href="#"><i class="soc_icon-linkedin"></i><span class="total">{total}</span></a>',
				enableHover: false,
				enableCounter: true,
				urlCurl: $share_container.data('directory') + '/inc' + '/sharrre.php',

				click: function (api, options) {
					api.simulateClick();
					api.openPopup('linkedin');
				}
			});

    }
	
	/* Fan facts animation */
	$('.fact-number .number.call-on-waypoint:not(.circle)').each(function() {
		var $number = $(this);
		var start = $number.attr('data-start');
		var end = $number.attr('data-end');
		var speed = parseInt($number.attr('data-speed'));
		
		$number.on('on-waypoin', function () {	
			$({value: start}).animate({value: end}, {
					duration: speed,
					easing: 'linear',
					step: function() {
						$number.text(Math.floor(this.value)).trigger('change');
					},
					complete: function() {
						$number.text(Math.floor(this.value)).trigger('change');
					}
				});
		});
	});
	
	$('.fact-number .number.circle.call-on-waypoint').each(function() {
		if ($(window).width() <= screen_medium) return false;
		
		var $number = $(this);
		var start = $number.attr('data-start');
		var end = $number.attr('data-end');
		var speed = parseInt($number.attr('data-speed'));
		
		var $input = $number.find($number.attr('data-knob'));
		$input.val(Math.ceil(start)).trigger('change');
		
		$number.on('on-waypoin', function () { 
			$({value: start}).animate({value: end}, {
				duration: speed,
				easing: 'swing',
				step: function() {
					$input.val(Math.ceil(this.value)).trigger('change');
					$number.text(Math.floor(this.value)).trigger('change');
				},
				complete: function() {
					$input.val(Math.ceil(this.value)).trigger('change');
					$number.text(Math.floor(this.value)).trigger('change');
				}
			});
		});
	});
	$('.animated-test-module .call-on-waypoint').each(function() {
		var $block = $(this);

		$block.on('on-waypoin', function () {
			if($block.hasClass('onit') === false) {
				setTimeout(function() {
					$block.addClass('onit');
				}, 500);
			}
		});
	});
}); // document ready

(function($) {
	$('.dfd-blog-share-popup-wrap').each(function() {
		var $self = $(this);
		$self.sharrre({
			share: {
				googlePlus: true,
				facebook: true,
				twitter: true,
				linkedin: true,
				pinterest: true
			},
			template: '<div class="box"><div class="dfd-share-icons"><a href="#" class="facebook soc_icon-facebook"></a><a href="#" class="twitter soc_icon-twitter-3"></a><a href="#" class="googleplus soc_icon-google"></a><a href="#" class="linkedin soc_icon-linkedin"></a><a href="#" class="pinterest soc_icon-pinterest"></a></div><div class="dfd-share-title box-name">'+$self.data('title')+'<span class="dfd-share-right">{total}</span></div></div>',
			urlCurl: $self.data('directory') + '/inc' + '/sharrre.php',
			enableHover: false,
			enableTracking: true,
			render: function(api, options){
				$(api.element).on('click', '.twitter', function(e) {
					e.preventDefault();
					api.openPopup('twitter');
				});
				$(api.element).on('click', '.facebook', function(e) {
					e.preventDefault();
					api.openPopup('facebook');
				});
				$(api.element).on('click', '.googleplus', function(e) {
					e.preventDefault();
					api.openPopup('googlePlus');
				});
				$(api.element).on('click', '.linkedin', function(e) {
					e.preventDefault();
					api.openPopup('linkedin');
				});
				$(api.element).on('click', '.pinterest', function(e) {
					e.preventDefault();
					api.openPopup('pinterest');
				});
			}
		});
	});
})(jQuery);

(function($) {
	var ua = window.navigator.userAgent;
	var ie_version;

	var msie = ua.indexOf('MSIE ');
	if (msie > 0) {
		// IE 10 or older => return version number
		ie_version =  parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
		$('html').addClass('dfd-ie-detected ie-'+ie_version);
	}

	var trident = ua.indexOf('Trident/');
	if (trident > 0) {
		// IE 11 => return version number
		var rv = ua.indexOf('rv:');
		ie_version =  parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
		$('html').addClass('dfd-ie-detected ie-'+ie_version);
	}

	var edge = ua.indexOf('Edge/');
	if (edge > 0) {
	   // IE 12 => return version number
	   ie_version =  parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
		$('html').addClass('dfd-ie-detected ie-'+ie_version);
	}
})(jQuery);

/*---------------------------------
 Video controls
 -----------------------------------*/
(function($){
	"use strict";
	$(document).ready(function() {
		$('.row-video-controls a.video').click(function(e) {
			var $this = $(this);
			var video = $(this).parents('section.row-wrapper').find('.row-video-container > video').get(0);
			
			if (video.paused) {
				video.play();
				$this.removeClass('video-off').addClass('video-on');
			} else {
				video.pause();
				$this.removeClass('video-on').addClass('video-off');
			}
			
			e.preventDefault();
		});
		
		$('.row-video-controls a.sound').click(function(e) {
			var $this = $(this);
			var video = $(this).parents('section.row-wrapper').find('.row-video-container > video').get(0);
			
			if (video.muted) {
				video.muted = false;
				$this.removeClass('sound-off').addClass('sound-on');
			} else {
				video.muted = true;
				$this.removeClass('sound-on').addClass('sound-off');
			}
			
			e.preventDefault();
		});
	});
	
})(jQuery);
// end video controls

/*---------------------------------
 Portfolio hide categories
 -----------------------------------*/
(function($){
	"use strict";
	var hide_show_isotope_category = function (item_container, scan_hidden, new_item) {
		var $filter_item = (scan_hidden != undefined && scan_hidden === true) ? $('.sort-panel a:hidden') : $('.sort-panel a');
		
		$filter_item.each(function() {
			var $this = $(this);
			var filter = ($this.data('filter') != undefined) ? $this.data('filter') : false;
			if (filter === false) {
				return true;
			}
			var filter_match = (new_item != undefined && typeof(new_item) === 'object' && scan_hidden === true) 
				? (new_item.is(filter)) ? 1 : 0 
				: $(filter).length;
			
			if (filter_match == 0) {
				$this.hide();
			} else if (filter_match > 0 && $this.is(':hidden')) {
				$this.show();
			}
		});
	};
	
	$(document).ready(function() {
		hide_show_isotope_category('div.works-list');
		
		$('body').bind('isotope-add-item', function(e, item) {
			hide_show_isotope_category('div.works-list', true, $(item));
		});
	});
	
})(jQuery);


/*---------------------------------
 horizontal scroll hack
 -----------------------------------*/
(function($){
	"use strict";
	var y = 0;
	
	$(window).scroll(function() {
		if($(this).scrollLeft() != 0 && $('body').hasClass('dfd-custom-padding-html')) {
			$('#header-container').css({left: $(this).scrollLeft() + $('body').css('margin') * -1});
		} else if($(this).scrollLeft() != 0 && !$('body').hasClass('dfd-custom-padding-html')) {
			$('#header-container').css({left: $(this).scrollLeft() * -1});
		}
	});
	
})(jQuery);

/*---------------------------------
 buddy press
 -----------------------------------*/
(function($){
	"use strict";
	$(document).ready(function() {
		$('#whats-new-submit').prepend('<i class="crdash-check_alt"></i>');
		
		$('#subnav a').prepend('');
		
		if ($('#group-admins').length > 0) {
			$('#item-header-content > span').wrapAll('<div id="item-actions-wrap"></div>');
			$('#item-header-content > #item-actions-wrap').insertAfter($('#group-admins'));
			$('#item-actions > h3').insertBefore('#item-actions-wrap > .highlight');
			$('#item-header-content').hide();
		}
		
		$('#activity-stream li').each(function() {
			var $this = $(this);
			$('> div', $this).wrapAll('<div class="activitys-wrap"></div>');
			
			$('.activity-meta a', $this).removeClass('button');
			$('.activity-meta a.acomment-reply', $this).prepend('<i class="crdash-square_chat_alt"></i>');
			$('.activity-meta a.fav', $this).prepend('<i class="crdash-heart"></i>');
			$('.activity-meta a.delete-activity', $this).prepend('<i class="crdash-trash_can"></i>');
			
			$('.activity-content .activity-meta', $this).insertAfter($('.activitys-wrap', $this));
		});
		
		$('#members_search, #groups_search').unwrap('label');
		
		$('#bp-login-widget-form').find('label').each(function() {
			var id = $(this).attr('for');
			var input = $('#'+id);
			var labelHtml = $(this).clone();
			var inputHtml = $('#'+id).clone();
			if(input.length) {
				$(this).remove();
				input.remove();
				$('#bp-login-widget-form .forgetmenot').before('<p class="'+id+'"/>');
				$('#bp-login-widget-form').find('.'+id).append(labelHtml).append(inputHtml);
			}
		});
		
		/*$('#bp-login-widget-form, .bbp-login-form, .widget_crum_login').find('input[type="text"], input[type="password"]').focus(function() {
			$(this).parent().addClass('active');
		}).blur(function() {
			$(this).parent().removeClass('active');
		});*/
		
		//$('form.woocommerce-product-search, #bbp-search-form, form.form-search, #search-message-form, #search-members-form, #search-groups-form').find('input[type="text"], input[type="search"]').focus(function() {
		//	$(this).parents('form').addClass('active');
		//}).blur(function() {
		//	$(this).parents('form').removeClass('active');
		//});
	});
	
})(jQuery);

/*Product thumb carousel*/
(function($) {
	"use strict";
	$(document).ready(function() {
		var $carousel = $('.woo-entry-thumb-carousel'),
			speed = $carousel.data('speed');
		$carousel.slick({
			infinite: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			dots: false,
			fade: true,
			autoplay: true,
			autoplaySpeed: speed,
			pauseOnHover: false
		});
	});
})(jQuery);


/*---------------------------------
 side area
 -----------------------------------*/
(function($){
	'use strict';
	
	$(document).on('click touchend', '.side-area-controller', function (e) {
		e.preventDefault();
		
		if($('.side-area-controller').hasClass('active')) {
			$('.side-area-controller').removeClass('active');
		} else {
			$('.side-area-controller').addClass('active');
		}
		
		$('#side-area').toggleClass('opened');
		$('html,body').toggleClass('side-area-opened');
		
		if (typeof $.initSlider === 'function') {
			setTimeout(function() {
				$.initSlider();
			}, 500);
		}
		
	});
	
	$('.top-inner-page-close').each(function(){
		var $self = $(this);
		$self.hover(function() {
			$self.addClass('hovered');
		},function() {
			$self.removeClass('hovered').addClass('lost-hover');
			setTimeout(function() {
				$self.removeClass('lost-hover');
			}, 300);
		});
	});
	/*
	$(document).on('side-aray-show', '#header-container', function() {
		$('.side-area-controller').show();
		$('#side-area').removeClass('not-open');
	});
	
	$(document).on('side-aray-hide', '#header-container', function() {
		$('.side-area-controller').hide();
		$('#side-area').addClass('not-open');
		close_side_area();
	});

	var close_side_area = function() {
        if ($('#side-area').hasClass('opened')) {
            $('#side-area').removeClass('opened');
			$('.side-area-controller').removeClass('opened');
            $('html,body').removeClass('side-area-opened');
        }
    };
	*/
})(jQuery);


/*!
 * Lettering.JS 0.6.1
 *
 * Copyright 2010, Dave Rupert http://daverupert.com
 * Released under the WTFPL license
 * http://sam.zoy.org/wtfpl/
 *
 * Thanks to Paul Irish - http://paulirish.com - for the feedback.
 *
 * Date: Mon Sep 20 17:14:00 2010 -0600
 */

(function(b){function c(a,e,c,d){e=a.text().split(e);var f="";e.length&&(b(e).each(function(a,b){f+='<span class="'+c+(a+1)+'">'+b+"</span>"+d}),a.empty().append(f))}var d={init:function(){return this.each(function(){c(b(this),"","char","")})},words:function(){return this.each(function(){c(b(this)," ","word"," ")})},lines:function(){return this.each(function(){c(b(this).children("br").replaceWith("eefec303079ad17405c889e092e105b0").end(),"eefec303079ad17405c889e092e105b0","line","")})}};b.fn.lettering=
    function(a){if(a&&d[a])return d[a].apply(this,[].slice.call(arguments,1));if("letters"===a||!a)return d.init.apply(this,[].slice.call(arguments,0));b.error("Method "+a+" does not exist on jQuery.lettering");return this}})(jQuery);

/*
 * textillate.js
 * http://jschr.github.com/textillate
 * MIT licensed
 *
 * Copyright (C) 2012-2013 Jordan Schroter
 */

(function($){"use strict";function isInEffect(effect){return/In/.test(effect)||$.inArray(effect,$.fn.textillate.defaults.inEffects)>=0}function isOutEffect(effect){return/Out/.test(effect)||$.inArray(effect,$.fn.textillate.defaults.outEffects)>=0}function getData(node){var attrs=node.attributes||[],data={};if(!attrs.length)return data;$.each(attrs,function(i,attr){if(/^data-in-*/.test(attr.nodeName)){data["in"]=data["in"]||{};data["in"][attr.nodeName.replace(/data-in-/,"")]=attr.nodeValue}else if(/^data-out-*/.test(attr.nodeName)){data.out=
    data.out||{};data.out[attr.nodeName.replace(/data-out-/,"")]=attr.nodeValue}else if(/^data-*/.test(attr.nodeName))data[attr.nodeName]=attr.nodeValue});return data}function shuffle(o){for(var j,x,i=o.length;i;j=parseInt(Math.random()*i),x=o[--i],o[i]=o[j],o[j]=x);return o}function animate($c,effect,cb){$c.addClass("animated "+effect).css("visibility","visible").show();$c.one("animationend webkitAnimationEnd oAnimationEnd",function(){$c.removeClass("animated "+effect);cb&&cb()})}function animateChars($chars,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            options,cb){var that=this,count=$chars.length;if(!count){cb&&cb();return}if(options.shuffle)shuffle($chars);$chars.each(function(i){var $this=$(this);function complete(){if(isInEffect(options.effect))$this.css("visibility","visible");else if(isOutEffect(options.effect))$this.css("visibility","hidden");count-=1;if(!count&&cb)cb()}var delay=options.sync?options.delay:options.delay*i*options.delayScale;$this.text()?setTimeout(function(){animate($this,options.effect,complete)},delay):complete()})}var Textillate=
    function(element,options){var base=this,$element=$(element);base.init=function(){base.$texts=$element.find(options.selector);if(!base.$texts.length){base.$texts=$('<ul class="texts"><li>'+$element.html()+"</li></ul>");$element.html(base.$texts)}base.$texts.hide();base.$current=$("<span>").text(base.$texts.find(":first-child").html()).prependTo($element);if(isInEffect(options.effect))base.$current.css("visibility","hidden");else if(isOutEffect(options.effect))base.$current.css("visibility","visible");
        base.setOptions(options);setTimeout(function(){base.options.autoStart&&base.start()},base.options.initialDelay)};base.setOptions=function(options){base.options=options};base.start=function(index){var $next=base.$texts.find(":nth-child("+(index||1)+")");(function run($elem){var options=$.extend({},base.options,getData($elem));base.$current.text($elem.html()).lettering("words");base.$current.find('[class^="word"]').css({"display":"inline-block","-webkit-transform":"translate3d(0,0,0)","-moz-transform":"translate3d(0,0,0)",
        "-o-transform":"translate3d(0,0,0)","transform":"translate3d(0,0,0)"}).each(function(){$(this).lettering()});var $chars=base.$current.find('[class^="char"]').css("display","inline-block");if(isInEffect(options["in"].effect))$chars.css("visibility","hidden");else if(isOutEffect(options["in"].effect))$chars.css("visibility","visible");animateChars($chars,options["in"],function(){setTimeout(function(){var options=$.extend({},base.options,getData($elem));var $next=$elem.next();if(base.options.loop&&!$next.length)$next=
        base.$texts.find(":first-child");if(!$next.length)return;animateChars($chars,options.out,function(){run($next)})},base.options.minDisplayTime)})})($next)};base.init()};$.fn.textillate=function(settings,args){return this.each(function(){var $this=$(this),data=$this.data("textillate"),options=$.extend(true,{},$.fn.textillate.defaults,getData(this),typeof settings=="object"&&settings);if(!data)$this.data("textillate",data=new Textillate(this,options));else if(typeof settings=="string")data[settings].apply(data,
    [].concat(args));else data.setOptions.call(data,options)})};$.fn.textillate.defaults={selector:".texts",loop:false,minDisplayTime:2E3,initialDelay:0,"in":{effect:"fadeInLeftBig",delayScale:1.5,delay:50,sync:false,shuffle:false},out:{effect:"hinge",delayScale:1.5,delay:50,sync:false,shuffle:false},autoStart:true,inEffects:[],outEffects:["hinge"]}})(jQuery);

/*! Fluidvids v2.2.0 | (c) 2014 @toddmotto | github.com/toddmotto/fluidvids */
!function(a,b){"function"==typeof define&&define.amd?define(b):"object"==typeof exports?module.exports=b:a.fluidvids=b()}(this,function(){"use strict";var a={selector:"iframe",players:["www.youtube.com","player.vimeo.com"]},b=document.head||document.getElementsByTagName("head")[0],c=".fluidvids{width:100%;position:relative;}.fluidvids iframe{position:absolute;top:0px;left:0px;width:100%;height:100%;}",d=function(b){var c=new RegExp("^(https?:)?//(?:"+a.players.join("|")+").*$","i");return c.test(b)},e=function(a){if(!a.getAttribute("data-fluidvids")){var b=document.createElement("div"),c=parseInt(a.height?a.height:a.offsetHeight,10)/parseInt(a.width?a.width:a.offsetWidth,10)*100;a.parentNode.insertBefore(b,a),a.setAttribute("data-fluidvids","loaded"),b.className+="fluidvids",b.style.paddingTop=c+"%",b.appendChild(a)}},f=function(){var a=document.createElement("div");a.innerHTML="<p>x</p><style>"+c+"</style>",b.appendChild(a.childNodes[1])};return a.apply=function(){for(var b=document.querySelectorAll(a.selector),c=0;c<b.length;c++){var f=b[c];d(f.src)&&e(f)}},a.init=function(b){for(var c in b)a[c]=b[c];a.apply(),f()},a});
(function($){
	"use strict";
	$(document).on('ready', function(){
		fluidvids.init({selector: 'iframe', players: ['www.youtube.com', 'player.vimeo.com']})
	});
})(jQuery);
