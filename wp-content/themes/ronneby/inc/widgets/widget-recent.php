<?php
require_once(dirname(__FILE__).'/widget.php');

class dfd_recent_posts extends SB_WP_Widget {
	protected $widget_base_id = 'dfd_recent_posts';
	protected $widget_name = 'Widget: Recent Posts';
	
	protected $options;
	
	private $cache_enabled = false;
	private $cache_time = 0; // 120
	private $thumbnail_size = array(80, 80);

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
		$this->widget_params = array(
			'description' => __('Advanced recent posts widget.', 'dfd')
		);
		
		$this->options = array(
			array(
				'title', 'text', '', 
				'label' => __('Title', 'dfd'), 
				'input'=>'text', 
				'filters'=>'widget_title', 
				'on_update'=>'esc_attr',
			),
			array(
				'limit', 'int', 5, 
				'label' => __('Limit', 'dfd'), 
				'input'=>'select', 
				'values' => array('range', 'from'=>1, 'to'=>20),
			),
			array(
				'date', 'text', '', 
				'label' => __('Display date', 'dfd'), 
				'input'=>'checkbox',
			),
			array(
				'comments', 'text', '', 
				'label' => __('Display comments', 'dfd'), 
				'input'=>'checkbox',
			),
			array(
				'author', 'text','', 
				'label' => __('Display author', 'dfd'), 
				'input'=>'checkbox',
			),
			array(
				'thumb', 'text', '', 
				'label' => __('Display thumbnail', 'dfd'), 
				'input'=>'checkbox',
			),
			array(
				'radius', 'text', '', 
				'label' => __('Border radius in px', 'dfd'), 
				'input'=>'text', 
			),
			array(
				'cat', 'text', '', 
				'label' => __('Limit to category', 'dfd'), 
				'input'=>'wp_dropdown_categories',
			),
		);
		
        parent::__construct();
    }

    /**
     * Display widget
     */
    function widget( $args, $instance ) {
        extract( $args );
		$this->setInstances($instance, 'filter');
		
        echo $before_widget;

		$title = $this->getInstance('title');
        if ( ! empty( $title ) ) {
            echo $before_title . $title . $after_title;
		}

        global $post;

        if ( !$this->cache_enabled || (false === ( $crumwidget = get_transient( 'crumwidget_' . $widget_id ) )) ) {

            $args = array(
                'numberposts' => $this->getInstance('limit'),
                'category_name' => $this->getInstance('cat'),
                'offset' => '0',
            );

            $crumwidget = get_posts( $args );

            set_transient( 'crumwidget_' . $widget_id, $crumwidget, $this->cache_time );
			
        }
		?>

        <ul class="recent-posts-list">
            <?php 
			
		$counter = 0;
			
	    foreach( $crumwidget as $post ) :	setup_postdata( $post );
			$counter++;
				if (has_post_thumbnail() && $this->getInstance('thumb')==true) {
					$display_thumbnail = true;
				} else {
					$display_thumbnail = false;
				}
			?>
            <li class="post-item clearfix <?php echo ($counter == 1) ? 'active' : ''; ?> <?php echo !$display_thumbnail ? 'without-thumbnail' : ''; ?>">

                <?php if ($display_thumbnail ) {
                    $thumb_img = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb_img, 'thumb'); //get img URL
                    $article_image = dfd_aq_resize($img_url, $this->thumbnail_size[0], $this->thumbnail_size[1], true, true, true);
					$border_radius_thumb = $this->getInstance('radius');
					$border_radius_thumb_style = '';
					if ($border_radius_thumb != '') {
						$border_radius_thumb_style = 'style="border-radius: '.$border_radius_thumb.'px;"';
					}
					if(!$article_image) {
						$article_image = $img_url;
					}
		    ?>
				<div class="entry-thumb entry-thumb-hover" <?php echo $border_radius_thumb_style ; ?>>
                        <a href="<?php the_permalink() ;?>" class="more">
                            <img src="<?php echo esc_url($article_image); ?>" alt="<?php the_title(); ?>" <?php echo $border_radius_thumb_style ; ?>/>
                        </a>
                    </div>
                <?php } ?>

				<div class="entry-content-wrap <?php if ($display_thumbnail) : ?>extra<?php endif; ?>">
					<div class="widget-inner-heading">
						<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'dfd' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					</div>

					<?php
						$author = $this->getInstance('author');
						$date = $this->getInstance('date');
						$comments = $this->getInstance('comments');
						
						if ($author || $date || $comments ) {
					?>
						<div class="subtitle">
							<?php
							if ($author) {
								get_template_part('templates/entry-meta/mini', 'author');
								get_template_part('templates/entry-meta/mini', 'delim-blank');
							}

							if ($date) {
								get_template_part('templates/entry-meta/mini', 'date');
								get_template_part('templates/entry-meta/mini', 'delim-blank');
							}

							if ($comments) {
								get_template_part('templates/entry-meta/mini', 'comments');
							}
							?>
						</div>
					<?php } ?>
					
				</div>
            </li>

            <?php endforeach; wp_reset_postdata(); ?>

        </ul>

    <?php

        echo $after_widget;
    }

}
