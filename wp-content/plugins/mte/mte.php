<?php
/**
 * Plugin Name: MTE Widget
 * Plugin URI: http://www.medialink.com.cy
 * Description: MTE Material
 * Version: 1.0.0
 * Author: Sandra Alkiviadous
 * Author URI: http://www.medialink.com.cy
 * License: GPL2
 */


class mte extends WP_Widget {

    /**
     * Unique identifier for this widget.
     *
     * Will also serve as the widget class.
     *
     * @var string
     */
    protected $widget_slug = 'mte';
    /**
     * Widget name displayed in Widgets dashboard.
     * Set in __construct since __() shouldn't take a variable.
     *
     * @var string
     */
    protected $widget_name = '';
    /**
     * Default widget title displayed in Widgets dashboard.
     * Set in __construct since __() shouldn't take a variable.
     *
     * @var string
     */
    protected $default_widget_title = '';
    /**
     * Shortcode name for this widget
     *
     * @var string
     */
    protected $shortcode = 'mte_widget';

    public function __construct() {
        $this->widget_name          = esc_html__( 'MTE Widget', 'mte_widget' );
        $this->default_widget_title = esc_html__( 'MTE Widget', 'mte_widget' );
        parent::__construct(
            $this->widget_slug,
            $this->widget_name,
            array(
                'classname'   => $this->widget_slug,
                'description' => esc_html__( 'MTE Material', 'mte_widget' ),
            )
        );
        add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
        add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
        add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
        add_shortcode( $this->shortcode, array( __CLASS__, 'get_widget' ) );
    }

    /**
     * Front-end display of widget.
     *
     * @param  array  $args      The widget arguments set up when a sidebar is registered.
     * @param  array  $instance  The widget settings as set by user.
     */
    public function widget( $args, $instance ) {
        echo self::get_widget( array(
            'before_widget' => $args['before_widget'],
            'after_widget'  => $args['after_widget'],
            'before_title'  => $args['before_title'],
            'after_title'   => $args['after_title'],
            'title'         => $instance['title'],
        ) );
    }

    /**
     * Return the widget/shortcode output
     *
     * @param  array  $atts Array of widget/shortcode attributes/args
     * @return string       Widget output
     */
    public static function get_widget( $atts ) {

        $class = new mte();

        $widget = '';
        // Set up default values for attributes
        $atts = shortcode_atts(
            array(
                // Ensure variables
                'before_widget' => '',
                'after_widget'  => '',
                'before_title'  => '',
                'after_title'   => '',
                'title'         => '',
            ),
            (array) $atts,
            'mte_widget'
        );
        // Before widget hook
        $widget .= $atts['before_widget'];
        // Title
        $widget .= ( $atts['title'] ) ? $atts['before_title'] . esc_html( $atts['title'] ) . $atts['after_title'] : '';

        // wrapper for mte material
        if(!is_user_logged_in()) {
            require_once('mte_locked.php');

        } else {
            require_once('mte_unlocked.php');
        }

        // After widget hook
        $widget .= $atts['after_widget'];
        return $widget;
    }

    /**
     * Update form values as they are saved.
     *
     * @param  array  $new_instance  New settings for this instance as input by the user.
     * @param  array  $old_instance  Old settings for this instance.
     * @return array  Settings to save or bool false to cancel saving.
     */
    public function update( $new_instance, $old_instance ) {
        // Previously saved values
        $instance = $old_instance;
        // Sanitize title before saving to database
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        // Flush cache
        $this->flush_widget_cache();
        return $instance;
    }

    /**
     * Back-end widget form with defaults.
     *
     * @param  array  $instance  Current settings.
     */
    public function form( $instance ) {
        // If there are no settings, set up defaults
        $instance = wp_parse_args( (array) $instance,
            array(
                'title' => $this->default_widget_title,
                'text'  => '',
            )
        );
        ?>

        <p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'mte_widget' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_html( $instance['title'] ); ?>" placeholder="optional" /></p>

        <?php
    }

    /**
     * scripts function.
     *
     * @access public
     * @return void
     */
    public function scripts() {
        $mte_rtl_css = '/wp-content/plugins/mte/assets/rtl.css';

        $rtl_languages = ["ar"];
        if(in_array(ICL_LANGUAGE_CODE,$rtl_languages)) {
            wp_enqueue_style( 'mte_rtl_css', $mte_rtl_css );
        }

    }
}

function mte_register_widgets() {
    register_widget( 'mte' );
}

add_action( 'widgets_init', 'mte_register_widgets' );
