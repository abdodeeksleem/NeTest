<?php
global $dfd_ronneby;
$image_crop = $dfd_ronneby['thumb_image_crop'];
if ($image_crop == "") {$image_crop = true;}
?>


<?php
	global $post;
	$postid = get_the_ID();
	
	$unique_id = uniqid('post_gallery_');
/*
    $args = array(
        'order' => 'ASC',
        'post_type' => 'attachment',
        'post_parent' => $postid,
        'post_mime_type' => 'image',
        'post_status' => null,
        'numberposts' => -1,
    );

    $attachments = get_posts($args);*/
	if (metadata_exists('post', $postid, '_my_post_image_gallery')) {
		$my_posts_image_gallery = get_post_meta($postid, '_my_post_image_gallery', true);
	} else {
		// Backwards compat
		$attachment_ids = get_posts('post_parent=' . $postid . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids');
		$attachment_ids = array_diff($attachment_ids, array(get_post_thumbnail_id()));
		$my_posts_image_gallery = implode(',', $attachment_ids);
	}

	$attachments = array_filter(explode(',', $my_posts_image_gallery));
    if ($attachments) {
		echo '<div class="cover">';
			echo '<div id="'. esc_attr($unique_id) .'" class="slide-post">';

				foreach ($attachments as $attachment) {
					$img_url =  wp_get_attachment_url($attachment); /*get img URL*/

					if ($dfd_ronneby['post_thumbnails_width'] && $dfd_ronneby['post_thumbnails_height']){
						$article_image = dfd_aq_resize($img_url, $dfd_ronneby['post_thumbnails_width'], $dfd_ronneby['post_thumbnails_height'], $image_crop, true, true);
					} else {
						$article_image = dfd_aq_resize($img_url, 900, 600, $image_crop, true, true);
					}
					if(!$article_image) {
						$article_image = $img_url;
					}
					?>
					<div>
						<img src="<?php echo esc_url($article_image); ?>" alt="<?php the_title(); ?>"/>
					</div>

				<?php  }
			echo '</div>';
			echo DFD_Carousel::controls();
			echo '<div class="post-comments-wrap">';
				get_template_part('templates/entry-meta/mini', 'comments-number');
			echo '</div>';
			echo '<div class="post-like-wrap">';
				get_template_part('templates/entry-meta/mini', 'like');
			echo '</div>';
        echo '</div>';
    }
?>
<script type="text/javascript">
	(function($){
		"use strict";
		$(document).ready(function(){
			var total_slides;
			var $carousel = $('#<?php echo esc_js($unique_id); ?>');
			$carousel.on('init reInit afterChange', function (event, slick, currentSlide) {
				var prev_slide_index, next_slide_index, current;
				var $prev_counter = $carousel.next('.slider-controls').find('.prev .count');
				var $next_counter = $carousel.next('.slider-controls').find('.next .count');
				total_slides = slick.slideCount;
				current = (currentSlide ? currentSlide : 0) + 1;
				prev_slide_index = (current - 1 < 1) ? total_slides : current - 1;
				next_slide_index = (current + 1 > total_slides) ? 1 : current + 1;
				$prev_counter.text(prev_slide_index + '/' + total_slides);
				$next_counter.text(next_slide_index + '/'+ total_slides);
			});
			$carousel.slick({
				infinite: true,
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
				dots: false,
				autoplay: true,
				autoplaySpeed: 2000,
			});
			$carousel.next('.slider-controls').find('.next').click(function(e) {
				$carousel.slickNext();

				e.preventDefault();
			});

			$carousel.next('.slider-controls').find('.prev').click(function(e) {
				$carousel.slickPrev();

				e.preventDefault();
			});
			$carousel.find('div').on('mousedown select',(function(e){
				e.preventDefault();
			}));
		});
	})(jQuery);
</script>