<?php
/**
 * DFD Friday Components
 */

function dfd_kadabra_excerpt_length( $length ) {
    return 30;
}

function dfd_kadabra_posts_link_attributes_1() {
    return 'class="older"';
}

function dfd_kadabra_posts_link_attributes_2() {
    return 'class="newer"';
}

function dfd_next_page_button($buttons) {
	if (in_array('wp_page', $buttons)) {
		return $buttons;
	}
	
	$pos = array_search('wp_more',$buttons,true);
    if ($pos !== false) {
        $tmp_buttons = array_slice($buttons, 0, $pos+1);
        $tmp_buttons[] = 'wp_page';
        $buttons = array_merge($tmp_buttons, array_slice($buttons, $pos+1));
    }
    return $buttons;
}

function prev_next_post_format_icon($post_id) {
	$post_type_icon = '';
	if (has_post_format('video', $post_id)) {
		$post_type_icon = '<i class="dfd-icon-play_film"></i>';
	} elseif (has_post_format('audio', $post_id)) {
		$post_type_icon = '<i class="dfd-icon-play2"></i>';
	} elseif (has_post_format('gallery', $post_id)) {
		$post_type_icon = '<i class="dfd-icon-photos"></i>';	
	} elseif (has_post_format('quote', $post_id)) {
		$post_type_icon = '<i class="navicon-quote-left"></i>';	
	} else {
		$post_type_icon = '<i class="dfd-icon-document2"></i>';
	}
	return $post_type_icon;
}

/*---------------------------------------------------------
 * Paginate Archive Index Page Links
 ---------------------------------------------------------*/
function dfd_kadabra_pagination() {
    global $portfolio_pagination_type;
	
	if (strcmp($portfolio_pagination_type, '1') === 0) {
		dfd_ajax_pagination();
	} elseif(strcmp($portfolio_pagination_type, '2') === 0) {
		dfd_lazy_load_pagination();
	} else {
		dfd_default_pagination();
	}
}

function dfd_default_pagination() {
	global $wp_query;
	
	$big = 999999999; // This needs to be an unlikely integer

    // For more options and info view the docs for paginate_links()
    // http://codex.wordpress.org/Function_Reference/paginate_links
    $paginate_links = paginate_links( array(
        'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages,
        'mid_size' => 5,
        'prev_next' => false,
        //'prev_text' => __('Previous', 'dfd'),
        //'next_text' => __('Next', 'dfd'),
        'type' => 'list'
    ) );

    // Display the pagination if more than one page is found
    if ( $paginate_links ) {
        echo '<div class="pagination">';
		echo '<div class="prev-next-links">';
		echo previous_posts_link( __('Prev.','dfd') );
		echo next_posts_link( __('Next','dfd') );
        echo '</div>';
        echo $paginate_links;
        echo '</div><!--// end .pagination -->';
    }
}

function dfd_ajax_pagination() {
	global $wp_query;
	
	$max_num_pages = $wp_query->max_num_pages;
	$page = get_query_var('paged');
	$paged = ($page > 1) ? $page : 1;

	wp_localize_script(
		'ajax-pagination',
		'dfd_pagination_data',
		array(
			'startPage' => $paged,
			'maxPages' => $max_num_pages,
			'nextLink' => next_posts($max_num_pages, false),
			'container' => '#portfolio-page > .works-list, #grid-folio, #grid-posts, .dfd-news-layout #main-content .row',
		)
	);
	
	wp_enqueue_script('ajax-pagination');
	
	echo '<div class="pagination ajax-pagination"><a id="ajax-pagination-load-more" class="button" href="#">'.__('Load more', 'dfd').'</a></div><!--// end .pagination -->';
}
function dfd_lazy_load_pagination() {
	global $wp_query, $dfd_ronneby;
	
	$max_num_pages = $wp_query->max_num_pages;
	$page = get_query_var('paged');
	$paged = ($page > 1) ? $page : 1;

	wp_localize_script(
		'dfd-lazy-load',
		'dfd_pagination_data',
		array(
			'startPage' => $paged,
			'maxPages' => $max_num_pages,
			'nextLink' => next_posts($max_num_pages, false),
			'container' => '#portfolio-page > .works-list, #grid-folio, #grid-posts, .dfd-news-layout #main-content .row',
		)
	);
	
	wp_enqueue_script('dfd-lazy-load');
	
	$lazy_load_pagination_image_html = '';
	
	if(isset($dfd_ronneby['lazy_load_pagination_image']) && !empty($dfd_ronneby['lazy_load_pagination_image'])) {
		$lazy_load_pagination_image_html .= '<img src="'. esc_url($dfd_ronneby['lazy_load_pagination_image']['url']).'" alt="Lazy load image" />';
	}
	
	echo '<div class="dfd-lazy-load-pop-up box-name">'.$lazy_load_pagination_image_html.'</div><!--// end .pagination -->';
}

function dfd_kadabra_prettyadd ($content) {
	$content = preg_replace("/<a/","<a data-rel=\"prettyPhoto[slides]\"",$content,1);
	return $content;
}

/*---------------------------------------------------------
 * Paginate
 ---------------------------------------------------------*/
function dfd_link_pages() {
	wp_link_pages(array('before' => '<nav class="post-pagination">', 'after' => '</nav>'));
}

/* ----------------------------------------------------------
 *  Search form
 ----------------------------------------------------------*/

function crum_search_form($form) {
	ob_start();
	get_template_part('templates/searchform');
	$form = ob_get_clean();
	
    return $form;
}

add_filter('get_search_form', 'crum_search_form');

/* ----------------------------------------------------------
 *  Login form
 ----------------------------------------------------------*/

function crum_login_form($redirect)
{
    $args = array(
        'redirect' => $redirect, //Your url here
        'form_id' => 'loginform-custom',
		'label_username' => '',
		'label_password' => '',
    );
	
	add_filter('login_form_top', 'crum_login_form_top');
	
	if (class_exists('crum_login_widget')) {
		$args = array(
			'label_log_in' => __('Login on site', 'dfd'),
			'label_lost_password' => __('Remind the password', 'dfd'),
		);
		
		$crum_login_widget = new crum_login_widget();
		
		$crum_login_widget->wp_login_form($args);
	} else {
		wp_login_form($args);
	}
}

function crum_login_form_top() {
	echo '<h3 class="login_form_title"><i class="infinityicon-padlock_closed_2"></i>'.__('Login on site', 'dfd').'</h3>';
}
/* ----------------------------------------------------------
 *  Social networks icons for header and footer
 ----------------------------------------------------------*/

function crum_social_networks($only_show_in_header = false){
	global $dfd_ronneby;
    $social_networks = array(
        "de"=>"Devianart",
        "dg"=>"Digg",
        "dr"=>"Dribbble",
        "db"=>"Dropbox",
        "en"=>"Evernote",
        "fb"=>"Facebook",
        "flk"=>"Flickr",
        "fs"=>"Foursquare",
        "gp"=>"Google +",
        "in"=>"Instagram",
        "lf"=>"Last FM",
        "li"=>"LinkedIN",
        "lj"=>"Livejournal",
        "pi"=>"Picasa",
        "pt"=>"Pinterest",
        "rss"=>"RSS",
        "tu"=>"Tumblr",
        "tw"=>"Twitter",
        "vi"=>"Vimeo",
        //"vk"=>"Vkontakte",
        "wp"=>"Wordpress",
        "yt"=>"YouTube",
        "500px"=>"500px",
        "vb"=>"viewbug",
        "ml"=>"mail",
        "vk2"=>"vkontacte2",
        "xn"=>"xing",
        "sp"=>"spotify",
        "hz"=>"houzz",
        "sk"=>"skype",
        "ss"=>"slideshare",
        "bd"=>"bandcamp",
        "sd"=>"soundcloud",
        "mk"=>"meerkat",
        "ps"=>"periscope",
        "sc"=>"snapchat",
    );
    $social_icons = array(
        "de" => "soc_icon-deviantart",
        "dg" => "soc_icon-digg",
        "dr" => "soc_icon-dribbble",
        "db" => "soc_icon-dropbox",
        "en" => "soc_icon-evernote",
        "fb" => "soc_icon-facebook",
        "flk" => "soc_icon-flickr",
        "fs" => "soc_icon-foursquare_2",
        "gp" => "soc_icon-google__x2B_",
        "in" => "soc_icon-instagram",
        "lf" => "soc_icon-last_fm",
        "li" => "soc_icon-linkedin",
        "lj" => "soc_icon-livejournal",
        "pi" => "soc_icon-picasa",
        "pt" => "soc_icon-pinterest",
        "rss" => "soc_icon-rss",
        "tu" => "soc_icon-tumblr",
        "tw" => "soc_icon-twitter-3",
        "vi" => "soc_icon-vimeo",
        //"vk" => "soc_icon-rus-vk-01",
        "wp" => "soc_icon-wordpress",
        "yt" => "soc_icon-youtube",
        "500px" => "dfd-vb_500_xing_avail-icon-500px",
        "vb" => "dfd-vb_500_xing_avail-icon-vb",
        "ml" => "soc_icon-mail",
        "vk2" => "soc_icon-rus-vk-02",
        "xn" => "dfd-vb_500_xing_avail-icon-xing",
        "sp" => "dfd-vb_500_xing_avail-icon-availability",
        "hz" => "dfd-vb_500_xing_avail-icon-houzz-dark-icon",
        "sk" => "dfd-vb_500_xing_avail-icon-skype",
        "ss" => "dfd-vb_500_xing_avail-icon-slideshare",
        "bd" => "dfd-vb_500_xing_avail-icon-bandcamp-logo",
        "sd" => "dfd-vb_500_xing_avail-icon-soundcloud-logo",
        "mk" => "dfd-vb_500_xing_avail-icon-Meerkat-color",
        "ps" => "dfd-vb_500_xing_avail-icon-periscope-logo",
        "sc" => "dfd-vb_500_xing_avail-icon-Snapchat-logo",
    );

    if ($only_show_in_header){
        foreach($social_networks as $short=>$original) {

            $icon = $social_icons[$short];

            if (isset($dfd_ronneby[$short.'_link']) && $dfd_ronneby[$short.'_link']) {
                $link = $dfd_ronneby[$short.'_link'];
            } else {
				$link = false;
			}
/*
            if ($dfd_ronneby[$short.'_show']) {
                $show = $dfd_ronneby[$short.'_show'];
            } else {
				$show = false;
			}
*/			
            if ( $link && $link!='http://' /*&& $show*/ ) {
                echo '<a href="'.esc_url($link) .'" class="'.esc_attr($short) . ' ' . esc_attr($icon) . '" title="'.esc_attr($original).'" target="_blank"><span class="line-top-left '.esc_attr($icon).'"></span><span class="line-top-center '.esc_attr($icon).'"></span><span class="line-top-right '.esc_attr($icon).'"></span><span class="line-bottom-left '.esc_attr($icon).'"></span><span class="line-bottom-center '.esc_attr($icon).'"></span><span class="line-bottom-right '.esc_attr($icon).'"></span><i class="'.esc_attr($icon).'"></i></a>';
			}
        }

    } else {
        foreach($social_networks as $short=>$original){
            $link = $dfd_ronneby[$short.'_link'];
            $icon = $social_icons[$short];
            if( $link  !='' && $link  !='http://' )
                echo '<a href="'.esc_url($link) .'" class="'.esc_attr($icon).'" title="'.esc_attr($original).'" target="_blank"><span class="line-top-left '.esc_attr($icon).'"></span><span class="line-top-center '.esc_attr($icon).'"></span><span class="line-top-right '.esc_attr($icon).'"></span><span class="line-bottom-left '.esc_attr($icon).'"></span><span class="line-bottom-center '.esc_attr($icon).'"></span><span class="line-bottom-right '.esc_attr($icon).'"></span><i class="'.esc_attr($icon).'"></i></a>';
        }
    }
}

function author_contact_methods() {
	$contactmethods = array();
	$contactmethods['dfd_author_info'] = 'Author Info';
    $contactmethods['twitter'] = 'Twitter';
    $contactmethods['googleplus'] = 'Google Plus';
    $contactmethods['linkedin'] = 'Linked In';
    $contactmethods['youtube'] = 'YouTube';
    $contactmethods['vimeo'] = 'Vimeo';
    $contactmethods['lastfm'] = 'LastFM';
    $contactmethods['tumblr'] = 'Tumblr';
    $contactmethods['skype'] = 'Skype';
    $contactmethods['cr_facebook'] = 'Facebook';
    $contactmethods['deviantart'] = 'Deviantart';
    $contactmethods['vkontakte'] = 'Vkontakte';
    $contactmethods['picasa'] = 'Picasa';
    $contactmethods['pinterest'] = 'Pinterest';
    $contactmethods['wordpress'] = 'Wordpress';
    $contactmethods['instagram'] = 'Instagram';
    $contactmethods['dropbox'] = 'Dropbox';
    $contactmethods['rss'] = 'RSS';
	
	return $contactmethods;
}

function author_social_networks() {
	global $dfd_ronneby;
	if(isset($dfd_ronneby['author_soc_icons_hover_style']) && !empty($dfd_ronneby['author_soc_icons_hover_style'])) {
		$soc_icons_hover_style = 'dfd-soc-icons-hover-style-'.$dfd_ronneby['author_soc_icons_hover_style'];
	} else {
		$soc_icons_hover_style = 'dfd-soc-icons-hover-style-1';
	}
	$options = author_contact_methods();
	
	$social_icons = array(
        "cr_facebook" => "soc_icon-facebook",
        "googleplus" => "soc_icon-google__x2B_",
        "twitter" => "soc_icon-twitter-3",
        "instagram" => "soc_icon-instagram",
        "vimeo" => "soc_icon-vimeo",
        "lastfm" => "soc_icon-last_fm",
        "vkontakte" => "soc_icon-rus-vk-01",
        "youtube" => "soc_icon-youtube",
        "deviantart" => "soc_icon-deviantart",
        "linkedin" => "soc_icon-linkedin",
        "picasa" => "soc_icon-picasa",
        "pinterest" => "soc_icon-pinterest",
        "wordpress" => "soc_icon-wordpress",
        "dropbox" => "soc_icon-dropbox",
        "rss" => "soc_icon-rss",
    );
	
	ob_start();
	
	echo '<div class="widget soc-icons inline-block '.esc_attr($soc_icons_hover_style).'">';
	
	foreach($social_icons as $option=>$class) {
		$title = $options[$option];
		$link = get_the_author_meta($option);
		
		if (empty($link)) {
			continue;
		}
		
		echo '<a href="'.esc_url($link) .'" class="'.esc_attr($class).'" title="'.esc_attr($title).'"><span class="line-top-left '.esc_attr($class).'"></span><span class="line-top-center '.esc_attr($class).'"></span><span class="line-top-right '.esc_attr($class).'"></span><span class="line-bottom-left '.esc_attr($class).'"></span><span class="line-bottom-center '.esc_attr($class).'"></span><span class="line-bottom-right '.esc_attr($class).'"></span><i class="'.esc_attr($class).'"></i></a>';
	}
	
	echo '</div>';
	
	return ob_get_clean();
}

/* ----------------------------------------------------------
 *  Post vote counter for portfolio items
 ----------------------------------------------------------*/

add_action('wp_ajax_nopriv_post-like', 'post_like');
add_action('wp_ajax_post-like', 'post_like');

function post_like() {
    // Check for nonce security
    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Busted!');

    if(isset($_POST['post_like']))
    {
        // Retrieve user IP address
        $ip = $_SERVER['REMOTE_ADDR'];
        $post_id = $_POST['post_id'];

        // Get voters'IPs for the current post
        $meta_IP = get_post_meta($post_id, "_voted_IP");
        $voted_IP = (isset($meta_IP[0]))?$meta_IP[0]:false;

        if(!is_array($voted_IP))
            $voted_IP = array();

        // Get votes count for the current post
        $meta_count = get_post_meta($post_id, "_votes_count", true);

        // Use has already voted ?
        if(!hasAlreadyVoted($post_id))
        {
            $voted_IP[$ip] = time();

            // Save IP and increase votes count
            update_post_meta($post_id, "_voted_IP", $voted_IP);
            update_post_meta($post_id, "_votes_count", ++$meta_count);

            // Display count (ie jQuery return value)
            echo $meta_count;
        }
        else
            echo "already";
    }
    exit;
}

function hasAlreadyVoted($post_id)
{
    $timebeforerevote = 60*60;

    // Retrieve post votes IPs
    $meta_IP = get_post_meta($post_id, "_voted_IP");
    $voted_IP = (isset($meta_IP[0])) ? $meta_IP[0] : '';

    if(!is_array($voted_IP))
        $voted_IP = array();

    // Retrieve current user IP
    $ip = $_SERVER['REMOTE_ADDR'];

    // If user has already voted
    if(in_array($ip, array_keys($voted_IP)))
    {
        $time = $voted_IP[$ip];
        $now = time();

        // Compare between current time and vote time
        if(round(($now - $time) / 60) > $timebeforerevote)
            return false;

        return true;
    }

    return false;
}

/**
 * Post Like. Social Share
 * @param integer $post_id Post ID
 * @return string Post like code
 */
function getPostLikeLink($post_id=null) {
	if (!$post_id) {
		global $post;
		
		$post_id = $post->ID;
	}
	
    $vote_count = intval(get_post_meta($post_id, "_votes_count", true));
	//$vote_count .= '&nbsp;'.__('Like(s)', 'dfd');
	
	
//	if ($vote_count > 10) {
//		$vote_count = '10+';
//	}

    $output = '';

    if(hasAlreadyVoted($post_id)) {
        $output .= '<i class="dfd-icon-heart"></i><span title="'.__('I like this article', 'dfd').'" class="like alreadyvoted"><span class="count">'.$vote_count.'</span></span>';
	} else {
        $output .= '<a class="post-like" href="#" data-post_id="'.$post_id.'">
					<i class="dfd-icon-heart"></i>
					<span class="count">'.$vote_count.'</span>
                </a>';
	}

    return $output;
}

/* ----------------------------------------------------------
 *  
 ----------------------------------------------------------*/
function dfd_get_folio_inside_template() {
//	$value = get_post_meta(get_the_id(), 'folio_inside_template', true);
//	if (empty($value)) {
//		//@TODO: make global foli templates list
//		$value = 'folio_inside_1';
//	}
	
	$value = 'folio_inside_1';
	
	return $value;
}

function dfd_get_folio_gallery_type() {
	$value = get_post_meta(get_the_id(), 'folio_gallery_type', true);
	if (empty($value)) {
		$value = 'default';
	}
	
	return $value;
}

function dfd_get_folio_description_align() {
	$value = get_post_meta(get_the_id(), 'folio_description_position', true);
	if (empty($value)) {
		$value = 'left';
	}
	
	return $value;
}

function dfd_get_header_style_option() {
	global $post, $dfd_ronneby;

	$headers_avail = array_keys(dfd_headers_type());
	
	if (isset($_POST['header_type']) && !empty($_POST['header_type'])) {
		if ( in_array($_POST['header_type'], $headers_avail) ) {
			return $_POST['header_type'];
		}
	}
	
	if (!empty($post) && is_object($post)) {
		$page_id = $post->ID;
		$selected_header = get_post_meta($page_id, 'dfd_headers_header_style', true);

		if ($selected_header && in_array($selected_header, $headers_avail)) {
			return $selected_header;
		}
	}

	$layouts = array('pages', 'archive', 'single', 'search', '404',);

	switch (true) {
		case is_404(): $layout = '404';
			break;
		case is_search(): $layout = 'search';
			break;
		case is_single(): $layout = 'single';
			break;
		case is_archive(): $layout = 'archive';
			break;
		case is_page(): $layout = 'pages';
			break;
		default:
			$layout = false;
	}

	if (!$layout || !in_array($layout, $layouts)) {
		$layout = $layouts[0];
	}

	if (!$dfd_ronneby["{$layout}_head_type"] || !in_array($dfd_ronneby["{$layout}_head_type"], $headers_avail)) {
		return false;
	}

	return $dfd_ronneby["{$layout}_head_type"];
}
/*
function dfd_get_show_top_header() {
	global $post;

	if (!empty($post) && is_object($post)) {
		$page_id = $post->ID;
		
		$selected_show_header_option = get_post_meta($page_id, 'dfd_headers_show_top_header', true);
		$selected_header_variant = !empty($selected_show_header_option) ? $selected_show_header_option : 'on';

		return $selected_header_variant;
	}
}
*/
function dfd_get_header_logo_position() {
	global $post;
	
	$logo_pos_avail = array_keys(dfd_logo_position());
	
	$selected_logo_position = '';
	
	if (isset($_POST['header_logo_position']) && !empty($_POST['header_logo_position'])) {
		if ( in_array($_POST['header_logo_position'], $logo_pos_avail) ) {
			return $_POST['header_logo_position'];
		}
	}

	if (!empty($post) && is_object($post)) {
		$page_id = $post->ID;
		
		$logo_position = get_post_meta($page_id, 'dfd_headers_logo_position', true);
		if(!empty($logo_position)) {
			$selected_logo_position = $logo_position;
		}
	}
	if(empty($selected_logo_position)) {
		$selected_logo_position = 'left';
	}
	
	return $selected_logo_position;
}

function dfd_get_header_menu_position() {
	global $post;
	
	$menu_pos_avail = array_keys(dfd_menu_position());
	
	$selected_menu_position = '';
	
	if (isset($_POST['header_menu_position']) && !empty($_POST['header_menu_position'])) {
		if ( in_array($_POST['header_menu_position'], $menu_pos_avail) ) {
			return $_POST['header_menu_position'];
		}
	}

	if (!empty($post) && is_object($post)) {
		$page_id = $post->ID;
		
		$menu_position = get_post_meta($page_id, 'dfd_headers_menu_position', true);
		if(!empty($menu_position)) {
			$selected_menu_position = $menu_position;
		}
	}
	if(empty($selected_menu_position)) {
		$selected_menu_position = 'top';
	}
	
	return $selected_menu_position;
}

function dfd_get_header_layout() {
	global $dfd_ronneby;
	$available = dfd_header_layouts();
	
	$header_layout = isset($dfd_ronneby['header_layout']) ? $dfd_ronneby['header_layout'] : '';
	
	if (empty($header_layout) || !isset($available[$header_layout])) {
		$available_keys = array_keys($available);
		$header_layout = array_shift($available_keys);
	}
	
	return $header_layout;
}

function dfd_get_header_style() {
	$head_type = dfd_get_header_style_option();
	$header_layout = dfd_get_header_layout();
	//$show_top_header = dfd_get_show_top_header();
	$header_logo_position = dfd_get_header_logo_position();
	$header_menu_position = dfd_get_header_menu_position();
	
	$customizable_headers = array('1', '2');
	
	if(in_array($head_type, $customizable_headers)) {
		return "header-style-{$head_type} header-layout-{$header_layout} logo-position-{$header_logo_position} menu-position-{$header_menu_position}"; //top-header-{$show_top_header}
	} else {
		return "header-style-{$head_type} header-layout-{$header_layout} "; //top-header-{$show_top_header}
	}
}

if (!function_exists('post_like_scripts')) {
	/**
	 * Post Like scripts
	 */
	function post_like_scripts() {
		wp_register_script('like_post', get_template_directory_uri().'/assets/js/post-like.min.js', array('jquery'), null, true );
		wp_localize_script('like_post', 'ajax_var', array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajax-nonce')
		));
		wp_enqueue_script('like_post');
	}
}

/**
 * Portfolio Sort panel
 * @param array $categories
 */
function dfd_folio_sort_panel($categories) {
?>
<div class="sort-panel twelve columns">
	<ul class="filter filter-buttons">
		<li class="active">
			<a data-filter=".project" href="#"><?php echo __('All', 'dfd'); ?></a>
		</li>
		<?php foreach ($categories as $category): ?>
			<li>
				<a href="#" data-filter=".project[data-category~='<?php echo strtolower(preg_replace('/\s+/', '-', $category->slug)); ?>']">
					<?php echo $category->name; ?>
				<span class="anim-bg"></span></a>
			</li>
		<?php endforeach; ?>

	</ul>
</div>
<?php
}

function dfd_taxonomy_add_new_meta_field() {
	?>
	<div class="form-field">
		<label for="term_meta[custom_term_meta]"><?php _e( 'Category&#0146;s icon', 'dfd' ); ?></label>
		<input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" class="iconname" value="" style="width:50%;" />
		<a href="#" class="updateButton crum-icon-add"><?php _e('Add Icon', 'dfd'); ?></a>
	</div>
<?php
}

function dfd_taxonomy_edit_meta_field($term) {
	$t_id = $term->term_id;

	$term_meta = get_option( "taxonomy_$t_id" ); ?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[custom_term_meta]"><?php _e( 'Category&#0146;s icon', 'dfd' ); ?></label></th>
		<td>
			<input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" class="iconname" value="<?php echo esc_attr( $term_meta['custom_term_meta'] ) ? esc_attr( $term_meta['custom_term_meta'] ) : ''; ?>" style="width:50%;" />
			<a href="#" class="updateButton crum-icon-add"><?php _e('Add Icon', 'dfd'); ?></a>
		</td>
	</tr>
<?php
}

add_action( 'category_add_form_fields', 'dfd_taxonomy_add_new_meta_field', 10, 2 );
add_action( 'category_edit_form_fields', 'dfd_taxonomy_edit_meta_field', 10, 2 );

function save_taxonomy_custom_meta( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "taxonomy_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		update_option( "taxonomy_$t_id", $term_meta );
	}
}  
add_action( 'edited_category', 'save_taxonomy_custom_meta', 10, 2 );  
add_action( 'create_category', 'save_taxonomy_custom_meta', 10, 2 );
