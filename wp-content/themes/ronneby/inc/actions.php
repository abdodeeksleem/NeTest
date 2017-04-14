<?php
/*
 * Pages layout select function
 */

function set_layout($page, $open = true) {
	global $dfd_ronneby;
	$page = isset($dfd_ronneby[$page . '_layout']) && !empty($dfd_ronneby[$page . '_layout']) ? $dfd_ronneby[$page . '_layout'] : '1col-fixed';
	
	switch($page) {
		case '3c-l-fixed':
			$cr_layout = 'sidebar-left2';
			$cr_width = 'six dfd-eq-height';
			break;
		case '3c-r-fixed':
			$cr_layout = 'sidebar-right2';
			$cr_width = 'six dfd-eq-height';
			break;
		case '2c-l-fixed':
			$cr_layout = 'sidebar-left';
			$cr_width = 'nine dfd-eq-height';
			break;
		case '2c-r-fixed':
			$cr_layout = 'sidebar-right';
			$cr_width = 'nine dfd-eq-height';
			break;
		case '3c-fixed':
			$cr_layout = 'sidebar-both';
			$cr_width = 'six dfd-eq-height';
			break;
		case '1col-fixed':
		default:
			$cr_layout = '';
			$cr_width = 'twelve';
	}
	
    if ($open) {

        // Open content wrapper


        echo '<div class="blog-section ' . esc_attr($cr_layout) . '">';
        echo '<section id="main-content" role="main" class="' . $cr_width . ' columns">';


    } else {

        // Close content wrapper

        echo ' </section>';

        if (($page == "2c-l-fixed") || ($page == "3c-fixed")) {
            get_template_part('templates/sidebar', 'left');
            echo ' </div>';
        }
        if (($page == "3c-l-fixed")){
            get_template_part('templates/sidebar', 'right');
            echo ' </div>';
            get_template_part('templates/sidebar', 'left');
        }
        if ($page == "3c-r-fixed"){
            get_template_part('templates/sidebar', 'left');
            echo ' </div>';
        }
        if (($page == "2c-r-fixed") || ($page == "3c-fixed") || ($page == "3c-r-fixed") ) {
            get_template_part('templates/sidebar', 'right');
        }
		echo '</div>';
    }
}


/**
 * Add the RSS feed link in the <head> if there's posts
 */
function crum_feed_link() {
	$count = wp_count_posts('post'); if ($count->publish > 0) {
		echo "\n\t<link rel=\"alternate\" type=\"application/rss+xml\" title=\"". get_bloginfo('name') ." Feed\" href=\"". home_url() ."/feed/\">\n";
	}
}

add_action('wp_head', 'crum_feed_link', -2);


/**
 * Customization of login page
 */

function crum_custom_login_logo() {
	global $dfd_ronneby;
    if(isset($dfd_ronneby['custom_logo_image']['url']) && $dfd_ronneby['custom_logo_image']['url']){
        $custom_logo = $dfd_ronneby['custom_logo_image']['url'];
    } else {
        $custom_logo = get_template_directory_uri() .'/assets/img/logo.png';
    }

    echo '<style type="text/css">
    body.login{background:#fff;}
    h1 a { background-image:url('. $custom_logo .') !important; height: auto !important; min-height: 70px !important; width: 160px !important; background-size: contain !important;} </style>';
}

add_action('login_head', 'crum_custom_login_logo');

function crum_home_link() {
    return site_url();
}
add_filter('login_headerurl','crum_home_link');

function change_title_on_logo() {
    return get_bloginfo( 'name' );
}
add_filter('login_headertitle', 'change_title_on_logo');


// Add/Remove Contact Methods
function add_remove_contactmethods( $contactmethods ) {
	$contacts = author_contact_methods();
	
	foreach($contacts as $k=>$v) {
		$contactmethods[$k] = $v;
	}

    // Remove Contact Methods
    unset($contactmethods['aim']);
    unset($contactmethods['yim']);
    unset($contactmethods['jabber']);

    return $contactmethods;
}
add_filter('user_contactmethods','add_remove_contactmethods',10,1);


/**
 * Create pagination
 */

function crumin_pagination() {

    global $wp_query;

    $big = 999999999;

    $links = paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'prev_next' => true,
            'prev_text' =>  __('Prev', 'dfd'), //text of the "Previous page" link
            'next_text' =>  __('Next', 'dfd'), //text of the "Next page" link

            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages,
            'type' => 'list'
        )
    );

    $pagination = str_replace('page-numbers','pagination',$links);

    echo $pagination;

}

/**
 * Breadcrumbs
 */
function dfd_breadcrumbs() {

    /* === OPTIONS === */
    $text['home']     = __('Home', 'dfd'); // text for the 'Home' link
    $text['category'] = __('Archive by Category "%s"', 'dfd'); // text for a category page
    $text['search']   = __('Search Results for "%s" Query', 'dfd'); // text for a search results page
    $text['tag']      = __('Posts Tagged "%s"', 'dfd'); // text for a tag page
    $text['author']   = __('Articles Posted by %s', 'dfd'); // text for an author page
    $text['404']      = __('Error 404', 'dfd'); // text for the 404 page

    $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $delimiter   = ' <span class="del"></span> '; // delimiter between crumbs
    $before      = '<span class="current">'; // tag before the current crumb
    $after       = '</span>'; // tag after the current crumb
    /* === END OF OPTIONS === */

    global $post;
    $homeLink = home_url() . '/';
    $linkBefore = '<span>';
    $linkAfter = '</span>';
    $link = $linkBefore . '<a href="%1$s">%2$s</a>' . $linkAfter;

    if (is_home() || is_front_page()) {

        if ($showOnHome == 1) echo '<nav id="crumbs"><a href="' . esc_url($homeLink) . '">' . $text['home'] . '</a></nav>';

    } else {

        echo '<nav id="crumbs">' . sprintf($link, $homeLink, $text['home']) . $delimiter;

        if ( is_category() ) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) {
                $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                $cats = str_replace('<a', $linkBefore . '<a', $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
            }
            echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

        } elseif ( is_search() ) {
            echo $before . sprintf($text['search'], get_search_query()) . $after;


        }
        elseif (is_singular('topic') ){
            $post_type = get_post_type_object(get_post_type());
            printf($link, $homeLink . '/forums/', $post_type->labels->singular_name);
        }
        /* in forum, add link to support forum page template */
        elseif (is_singular('forum')){
            $post_type = get_post_type_object(get_post_type());
            printf($link, $homeLink . '/forums/', $post_type->labels->singular_name);
        }
        elseif (is_tax('topic-tag')){
            $post_type = get_post_type_object(get_post_type());
            printf($link, $homeLink . '/forums/', $post_type->labels->singular_name);
        }
        elseif ( is_day() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
            echo $before . get_the_time('d') . $after;

        } elseif ( is_month() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo $before . get_the_time('F') . $after;

        } elseif ( is_year() ) {
            echo $before . get_the_time('Y') . $after;

        } elseif ( is_single() && !is_attachment() ) {
            if ( get_post_type() != 'post' ) {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
            } else {
                $cat = get_the_category(); $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = str_replace('<a', $linkBefore . '<a', $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
                if ($showCurrent == 1) echo $before . get_the_title() . $after;
            }

        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;

        } elseif ( is_attachment() ) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID);
			if($cat) {
				$cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a', $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
				printf($link, get_permalink($parent), $parent->post_title);
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
			}
        } elseif ( is_page() && !$post->post_parent ) {
            if ($showCurrent == 1) echo $before . get_the_title() . $after;

        } elseif ( is_page() && $post->post_parent ) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs)-1) echo $delimiter;
            }
            if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

        } elseif ( is_tag() ) {
            echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . sprintf($text['author'], $userdata->display_name) . $after;

        } elseif ( is_404() ) {
            echo $before . $text['404'] . $after;
        }

        if ( get_query_var('paged') ) {
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
            echo __('Page', 'dfd') . ' ' . get_query_var('paged');
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
        }

        echo '</nav>';

    }
}

function dfd_potfolio_breadcrumbs() {
	global $dfd_ronneby;
	$delimiter   = ' <span class="del"></span> ';
	
	$page = isset($dfd_ronneby['portfolio_page_select']) ? $dfd_ronneby['portfolio_page_select'] : '';
	$title = '';
	$slug = '';
	
	if (!empty($page)) {
		$title = get_the_title($page);
		$slug = get_permalink($page);
	}
	
	$html = '';
	$html .= '<nav id="crumbs">';
	$html .= '<span><a href="' . home_url() . '">' . __('Home', 'dfd') . '</a></span>';
	$html .= $delimiter;
	
	if (!empty($title) && !empty($slug)) {
		$html .= '<span><a href="' . $slug . '">' . $title . '</a></span>';
		$html .= $delimiter;
	}
	
	$html .= get_the_title();
	$html .= '</nav>';
	
	echo $html;
}

function custom_bbp_breadcrumb() {
	$args['before'] = '<nav id="crumbs"><span>';
	$args['after'] = '</span></nav>';
	$args['sep'] = '<span class="del"></span>';
	$args['pad_sep'] = 0;
	$args['sep_before'] = '</span>';
	$args['sep_after'] = '<span>';
	$args['current_before'] = '';
	$args['current_after'] = '';
	$args['home_text'] = __('Home', 'dfd');
	
	return $args;
}

add_filter('bbp_before_get_breadcrumb_parse_args', 'custom_bbp_breadcrumb');

function custom_woocommerce_breadcrumb_defaults($args=array()) {
	$args['delimiter'] = '<span class="del"></span>';
	$args['wrap_before'] = '<nav id="crumbs">';
	$args['wrap_after'] = '</nav>';
	$args['before'] = '<span>';
	$args['after'] = '</span>';
	
	return $args;
}

add_filter('woocommerce_breadcrumb_defaults', 'custom_woocommerce_breadcrumb_defaults');

/*
 * Seo additions
 */

/**
 * Add Google+ meta tags to header
 *
 * @uses	get_the_ID()  Get post ID
 * @uses	setup_postdata()  setup postdata to get the excerpt
 * @uses	wp_get_attachment_image_src()  Get thumbnail src
 * @uses	get_post_thumbnail_id  Get thumbnail ID
 * @uses	the_title()  Display the post title
 *
 * @author c.bavota
 */
//add_action( 'wp_head', 'add_google_plus_meta' );

function add_google_plus_meta() {

    if( is_single() ) {

        global $post;

        $post_id = get_the_ID();
        setup_postdata( $post );

        $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'thumbnail' );
        $thumbnail = empty( $thumbnail ) ? '' : '<meta itemprop="image" content="' . esc_url( $thumbnail[0] ) . '">';
        ?>

    <!-- Google+ meta tags -->
    <meta itemprop="name" content="<?php esc_attr( the_title() ); ?>">
    <meta itemprop="description" content="<?php echo esc_attr( get_the_excerpt() ); ?>">
    <?php echo $thumbnail . "\n"; ?>

    <!-- eof Google+ meta tags -->
    <?php

    }

}

/*-----------------------------------------------------------------------------------*/
# Get Social Counter
/*-----------------------------------------------------------------------------------*/
global $dfd_ronneby;
$cachetime = (isset($dfd_ronneby['cachetime']) && $dfd_ronneby['cachetime']) ? ((int) $dfd_ronneby['cachetime'] * 60) : (60 * 60 * 1);

function tie_curl_subscribers_text_counter( $xml_url ) {
	$data_buf = wp_remote_get($xml_url, array('sslverify' => false));
	if (!is_wp_error($data_buf) && isset($data_buf['body'])) {
		return $data_buf['body'];
	}
}

function tie_rss_count( $fb_id ) {
    $feedburner['rss_count'] = get_option( 'rss_count');
    return $feedburner;
}

function tie_followers_count() {
	global $dfd_ronneby;
	$twitter_username = isset($dfd_ronneby['username']) ? $dfd_ronneby['username'] : '';
	
	$r['page_url'] = 'http://www.twitter.com/'.$twitter_username;
	
    try {
		require_once locate_template('/inc/lib/twitteroauth.php');
		$twitter = new DFDTwitter();
		$r['followers_count'] = $twitter->getFollowersCount();
    } catch (Exception $e) {
        $r['followers_count'] = 0;
    }

    return $r;
}

function tie_facebook_fans( $page_id ){/*
    $face_link = @parse_url($page_link);
	$fans = 0;
	
	if ( false === ( $fans = get_transient( 'facebook_fans_cache' ) ) ) {
		
		if( $face_link['host'] == 'www.facebook.com' || $face_link['host']  == 'facebook.com' ){
			try {
				$page_name = substr(@parse_url($page_link, PHP_URL_PATH), 1);
				$data = @json_decode(tie_curl_subscribers_text_counter("https://graph.facebook.com/".$page_name));
				if ($data && isset($data->likes)) {
					$fans = intval($data->likes);
				}
			} catch (Exception $e) {
				$fans = 0;
			}
			
		}
		
	}
	
	return $fans;*/
	global $cachetime;

	$fans = '';
    $xml = @simplexml_load_file("http://api.facebook.com/restserver.php?method=facebook.fql.query&query=SELECT%20fan_count%20FROM%20page%20WHERE%20page_id=".$page_id."");
	if(!empty($xml) && is_object($xml)) {
		$fans = (string)$xml->page->fan_count;
	}
	if(empty($fans)) $fans = 0;
	set_transient( 'facebook_fans_cache', $fans, $cachetime );
    return $fans;
}


function tie_youtube_subs( $channel_link ){
    $youtube_link = @parse_url($channel_link);
	$subs = 0;
	global $cachetime;
	
	if ( false === ( $subs = get_transient( 'youtube_subs_cache' ) ) ) {
		if( $youtube_link['host'] == 'www.youtube.com' || $youtube_link['host']  == 'youtube.com' ){
			try {
				$youtube_name = substr(@parse_url($channel_link, PHP_URL_PATH), 6);
				$json = @tie_curl_subscribers_text_counter("http://gdata.youtube.com/feeds/api/users/".$youtube_name."?alt=json");
				$data = json_decode($json, true);
				
				$subs = intval($data['entry']['yt$statistics']['subscriberCount']);
			} catch (Exception $e) {
				$subs = 0;
			}

			set_transient( 'youtube_subs_cache', $subs, $cachetime );
		}
	}
	
    return $subs;
}


function tie_vimeo_count( $page_link ) {
    $face_link = @parse_url($page_link);

    if( $face_link['host'] == 'www.vimeo.com' || $face_link['host']  == 'vimeo.com' ){
        try {
            $page_name = substr(@parse_url($page_link, PHP_URL_PATH), 10);
            @$data = @json_decode(tie_curl_subscribers_text_counter( 'http://vimeo.com/api/v2/channel/' . $page_name  .'/info.json'));

            $vimeo = $data->total_subscribers;
        } catch (Exception $e) {
            $vimeo = 0;
        }

        if( !empty($vimeo) && get_option( 'vimeo_count') != $vimeo )
            update_option( 'vimeo_count' , $vimeo );

        if( $vimeo == 0 && get_option( 'vimeo_count') )
            $vimeo = get_option( 'vimeo_count');

        elseif( $vimeo == 0 && !get_option( 'vimeo_count') )
            $vimeo = 0;

        return $vimeo;
    }

}

function tie_dribbble_count( $page_link ) {
    $face_link = @parse_url($page_link);

    if( $face_link['host'] == 'www.dribbble.com' || $face_link['host']  == 'dribbble.com' ){
        try {
            $page_name = substr(@parse_url($page_link, PHP_URL_PATH), 1);
            @$data = @json_decode(tie_curl_subscribers_text_counter( 'http://api.dribbble.com/' . $page_name));

            $dribbble = $data->followers_count;
        } catch (Exception $e) {
            $dribbble = 0;
        }

        if( !empty($dribbble) && get_option( 'dribbble_count') != $dribbble )
            update_option( 'dribbble_count' , $dribbble );

        if( $dribbble == 0 && get_option( 'dribbble_count') )
            $dribbble = get_option( 'dribbble_count');

        elseif( $dribbble == 0 && !get_option( 'dribbble_count') )
            $dribbble = 0;

        return $dribbble;
    }
}

function dfd_get_multisite_option() {
	$dfd_multisite_file_option = '';
	if(is_multisite()) {
		$blog_details = get_blog_details();
		$blog_id = '';
		if(!empty($blog_details) && is_object($blog_details)) {
			$dfd_multisite_file_option .= '-'.$blog_details->blog_id;
		}
	}
	return $dfd_multisite_file_option;
}


/* * *
 * PHP Less
 */
function sb_auto_compile_less_init() {
	if ( !file_exists(get_template_directory() . '/inc/lessc.inc.php') )
		return false;
	
	if (is_admin()) {
		return false;
	}
	
	$dfd_multisite_file_option = dfd_get_multisite_option();
	
	if(!class_exists('lessc')) {
		require_once( get_template_directory() . '/inc/lessc.inc.php' );
	}
	
	$less_files = array(
		'admin-panel' => array(
			'src' => get_template_directory() . '/assets/less/admin-panel.less',
			'out' => get_template_directory() . '/assets/css/admin-panel.css',
		),
		
		'animate-custom' => array(
			'src' => get_template_directory() . '/assets/less/animate-custom.less',
			'out' => get_template_directory() . '/assets/css/animate-custom.css',
		),
		
		'app' => array(
			'src' => get_template_directory() . '/assets/less/app.less',
			'out' => get_template_directory() . '/assets/css/app'.$dfd_multisite_file_option.'.css',
			'autocompile' => true,
		),
		
		'visual-composer' => array(
			'src' => get_template_directory() . '/assets/less/visual-composer.less',
			'out' => get_template_directory() . '/assets/css/visual-composer'.$dfd_multisite_file_option.'.css',
			'autocompile' => true,
		),
		
		'bbpress' => array(
			'src' => get_template_directory() . '/assets/less/bbpress.less',
			'out' => get_template_directory() . '/assets/css/bbpress'.$dfd_multisite_file_option.'.css',
		),
		
		'buddypress' => array(
			'src' => get_template_directory() . '/assets/less/buddypress.less',
			'out' => get_template_directory() . '/assets/css/buddypress'.$dfd_multisite_file_option.'.css',
		),
		/*
		'flexslider' => array(
			'src' => get_template_directory() . '/assets/less/flexslider.less',
			'out' => get_template_directory() . '/assets/css/flexslider.css',
		),
		*/
		'jquery.isotope' => array(
			'src' => get_template_directory() . '/assets/less/jquery.isotope.less',
			'out' => get_template_directory() . '/assets/css/jquery.isotope.css',
		),
		
		'mobile-responsive' => array(
			'src' => get_template_directory() . '/assets/less/mobile-responsive.less',
			'out' => get_template_directory() . '/assets/css/mobile-responsive.css',
			'autocompile' => true,
		),
		
		'multislider' => array(
			'src' => get_template_directory() . '/assets/less/multislider.less',
			'out' => get_template_directory() . '/assets/css/multislider.css',
		),
		/*
		'preloader' => array(
			'src' => get_template_directory() .'/assets/less/preloader.less',
			'out' => get_template_directory() . '/assets/css/preloader'.$dfd_multisite_file_option.'.css',
		),
		*/
		'prettyPhoto' => array(
			'src' => get_template_directory() . '/assets/less/prettyPhoto.less',
			'out' => get_template_directory() . '/assets/css/prettyPhoto.css',
		),
		
		'rtl' => array(
			'src' => get_template_directory() . '/assets/less/rtl.less',
			'out' => get_template_directory() . '/assets/css/rtl.css',
		),
		
		'site-preloader' => array(
			'src' => get_template_directory() .'/assets/less/site-preloader.less',
			'out' => get_template_directory() . '/assets/css/site-preloader'.$dfd_multisite_file_option.'.css',
		),

		'styled-button' => array(
			'src' => get_template_directory() .'/assets/less/styled-button.less', 
			'out' => get_template_directory() . '/assets/css/styled-button'.$dfd_multisite_file_option.'.css',
		),
		
		'woocommerce' => array(
			'src' => get_template_directory() . '/assets/less/woocommerce.less',
			'out' => get_template_directory() . '/assets/css/woocommerce'.$dfd_multisite_file_option.'.css',
			'autocompile' => true,
		),
		/*
		'go_pricing_skin_blue' => array(
			'src' => get_template_directory() . '/assets/less/go_pricing_skin.less',
			'out' => get_template_directory() . '/assets/css/go_pricing_skin'.$dfd_multisite_file_option.'.css',
			'autocompile' => true,
		),
		
		'masterslider_default' => array(
			'src' => get_template_directory() . '/assets/less/masterslider.less',
			'out' => get_template_directory() . '/assets/css/masterslider'.$dfd_multisite_file_option.'.css',
			'autocompile' => true,
		),
		*/
	);

	$less_files = apply_filters('dfd_less_filter', $less_files);

	if (!empty($less_files) && is_array($less_files)) {
		foreach ($less_files as $less_file) {
			if (!is_file($less_file['out']) 
					|| (!empty($less_file['autocompile']) 
						&& $less_file['autocompile'] === true 
						&& defined('DFD_PHP_LESS') 
						&& DFD_PHP_LESS === true)) {
				sb_auto_compile_less($less_file['src'], $less_file['out']);
			}
		}
	}
}

function sb_auto_compile_less($inputFile, $outputFile) {
	if (!class_exists('lessc'))
		return false;

	$less = new lessc();
	try {
		$less->setFormatter('compressed');//classic
		$less->compileFile($inputFile, $outputFile);
		unset($less);
	} catch (Exception $ex) {
		wp_die('Less compile error: '.$ex->getMessage());
	}
}

add_action('wp', 'sb_auto_compile_less_init');

/*
 * Saved theme options
 */

function sb_updated_theme_option(/*$option, $old_value, $value*/) {
	//if ($option === DFD_THEME_SETTINGS_NAME) {
		//DfdThemeSettings::reloadInstance();
		WP_Filesystem();
		global $wp_filesystem;

		/** Capture variables.less output **/
		ob_start();
		require locate_template('/redux_framework/variables_less.php');
		$variables_less = ob_get_clean();

		$variables_less_uploads_file = locate_template('assets/less.lib/_generated/variables.less');

		if (!$wp_filesystem->put_contents($variables_less_uploads_file, $variables_less, 0644)) {
			file_put_contents($variables_less_uploads_file, $variables_less);
		}
		
		$dfd_multisite_file_option = dfd_get_multisite_option();
		
		/*
		$_default_option_name = array(
			1 => 'title_h1',//h1 title
			2 => 'title_h2',//h2 title
			3 => 'title_h3',//h3 title
			4 => 'title_h4',//h4 title
			5 => 'title_h5',//h5 title
			6 => 'title_h6',//h6 title
			7 => 'subtitle_h1',//h1 subtitle
			8 => 'subtitle_h2',//h2 subtitle
			9 => 'subtitle_h3',//h3 subtitle
			10 => 'subtitle_h4',//h4 subtitle
			11 => 'subtitle_h5',//h5 subtitle
			12 => 'subtitle_h6',//h6 subtitle
			13 => 'widget_title',//widget title
			14 => 'block_title',//block title
			15 => 'feature_title',//feature title
			16 => 'box_name',//box name
			17 => 'subtitle',//subtitle
			18 => 'text',//text
			19 => 'entry_meta',//text
			20 => 'menu_titles',//menu titles
			21 => 'menu_dropdowns',//menu dropdowns
		);
		
		$check_options = array(
			'main_site_color',
			'secondary_site_color',
			'third_site_color',
			'fourth_site_color',
			'border_color',
			'header_background_color',
			'fixed_header_background_color',
			'fixed_header_background_opacity',
			'stunning_header_min_height',
			'folio_hover_text_color',
			'folio_hover_bg',
			'folio_hover_bg_opacity',
			'header_logo_width',
			'header_logo_height',
			'side_area_width',
			'top_menu_height',
		);
		for ($i=1; $i<=21; $i++) {
			$check_options[] = $_default_option_name[$i].'_typography_option';
		}
		
		$colors_old_value = array();
		$colors_new_value = array();
		
		foreach ( $check_options as $v ) {
			$colors_old_value[$v] = ( isset($old_value[$v]) ) ? $old_value[$v] : '';
			$colors_new_value[$v] = ( isset($value[$v]) ) ? $value[$v] : '';
		}
*/
		//if ($colors_old_value !== $colors_new_value) {
			if ( !class_exists('lessc') ) {
				if ( !file_exists(get_template_directory() . '/inc/lessc.inc.php') ) {
					return false;
				}
				
				require( get_template_directory() . '/inc/lessc.inc.php' );
			}
			
			try {
				$less = new lessc();
				$less->setFormatter('compressed');
				$less->compileFile( get_template_directory() . '/assets/less/app.less', 
						get_template_directory() . '/assets/css/app'.$dfd_multisite_file_option.'.css' );
				
				unset($less);
			} catch (Exception $ex) {
				set_transient( 'redux-opts-exceptions-'.DFD_THEME_SETTINGS_NAME, array('Less compile error: ' . $ex->getMessage()), 1000 );
			}
			
			try {
				$less = new lessc();
				$less->setFormatter('compressed');
				$less->compileFile( get_template_directory() . '/assets/less/visual-composer.less', 
						get_template_directory() . '/assets/css/visual-composer'.$dfd_multisite_file_option.'.css' );
				
				unset($less);
			} catch (Exception $ex) {
				set_transient( 'redux-opts-exceptions-'.DFD_THEME_SETTINGS_NAME, array('Less compile error: ' . $ex->getMessage()), 1000 );
			}
			/*
			try {
				$less = new lessc();
				$less->setFormatter('compressed');
				$less->compileFile( get_template_directory() . '/assets/less/styled-button.less', 
						get_template_directory() . '/assets/css/styled-button'.$dfd_multisite_file_option.'.css' );
				
				unset($less);
			} catch (Exception $ex) {
				set_transient( 'redux-opts-exceptions-'.DFD_THEME_SETTINGS_NAME, array('Less compile error: ' . $ex->getMessage()), 1000 );
			}
			*/
			try {
				$less = new lessc();
				$less->setFormatter('compressed');
				if (is_plugin_active('woocommerce/woocommerce.php')) {
					$less->compileFile( get_template_directory() . '/assets/less/woocommerce.less', 
							get_template_directory() . '/assets/css/woocommerce'.$dfd_multisite_file_option.'.css' );
				}
				
				unset($less);
			} catch (Exception $ex) {
				set_transient( 'redux-opts-exceptions-'.DFD_THEME_SETTINGS_NAME, array('Less compile error: ' . $ex->getMessage()), 1000 );
			}
		//}
		//sb_auto_compile_less_init();
	//}
}

add_action('redux/options/'.DFD_THEME_SETTINGS_NAME.'/saved', 'sb_updated_theme_option'/*, 10, 3*/);
//add_action('updated_option', 'sb_updated_theme_option', 10, 3);

function dfd_stylecharger_return_header() {
    get_template_part('templates/header/style', dfd_get_header_style_option());
    exit;
}

function feature_read_more_style() {
	$feature_read_more = array(
		'read-more-default' => __('Main style', 'mvb'),
		'read-more' => __('Alternative style', 'mvb')
	);
	
	return $feature_read_more;
}

if (!function_exists('dfd_num_to_string')) {
	function dfd_num_to_string( $str = 1){
		$arr = array(1 => 'twelve', 'six', 'four', 'three');

		if( isset($arr[$str]) ) {
			return $arr[$str];
		} else {
			return 'twelve';
		}
	}
}

if (!function_exists('dfd_vc_delimiter_styles')) {
	function dfd_vc_delimiter_styles() {
		return array(
			__('None', 'dfd') => '',
			__('Default', 'dfd') => 1,
			__('With shadow above', 'dfd') => 2,
			__('With shadow below', 'dfd') => 3,
			__('Color triangle', 'dfd') => 4,
			__('Transparent triangle bottom', 'dfd') => 5,
			__('Transparent triangle top', 'dfd') => 6,
			__('Transparent triangle both top and bottom', 'dfd') => 7,
			__('Fade top', 'dfd') => 8,
			__('Fade bottom', 'dfd') => 9,
			__('Fade both top and bottom', 'dfd') => 10,
			__('Boxed border', 'dfd') => 11,
			__('Vertical line at the bottom', 'dfd') => 12,
		);
	}
}

if (!function_exists('dfd_folio_thumb_width')) {
	function dfd_folio_thumb_width() {
		$_thumb_width = array();
		
		for($i=1; $i<=4; $i++) {
			$_thumb_width[] = array(
								'value' => (string)$i,
								'name' => (string)$i,
							);
		}
		
		return $_thumb_width;
	}
}

if (!function_exists('dfd_folio_thumb_height')) {
	function dfd_folio_thumb_height() {
		$_thumb_height = array();
		
		for($i=1; $i<=4; $i++) {
			$_thumb_height[] = array(
								'value' => (string)$i,
								'name' => (string)$i,
							);
		}
		
		return $_thumb_height;
	}
}

if(!function_exists('column_class_maker')) {
	function column_class_maker($count = 1) {
		if($count % 3 == 0) {
			return 'third-size';
		} elseif($count % 2 == 0) {
			return 'half-size';
		} else {
			return 'full-width';
		}
	}
}

/*
 * AJAX Pagination
 */
if(!function_exists('dfd_template_redirect')) {
	function dfd_template_redirect() {
		global $post, $portfolio_pagination_type;
		if ( isset($post) && isset($post->ID) ) {
			$portfolio_pagination_type = get_post_meta($post->ID, 'dfd_pagination_type', true);
		}
	}
}
if(!function_exists('dfd_ajax_template')) {
	function dfd_ajax_template() {
		$template = locate_template(array('base-ajax.php'));
		return $template;
	}
}
if(!function_exists('dfd_is_ajax_request')) {
	function dfd_is_ajax_request() {
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
				&& strcasecmp($_SERVER['HTTP_X_REQUESTED_WITH'], 'xmlhttprequest') === 0) {
			add_filter( 'template_include', 'dfd_ajax_template', 100 );
		}
	}
}

add_action('template_redirect', 'dfd_template_redirect');
add_action('init', 'dfd_is_ajax_request');
