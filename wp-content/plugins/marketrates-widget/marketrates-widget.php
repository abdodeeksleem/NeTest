<?php
/**
 * Plugin Name: Market Rates Widget
 * Plugin URI: http://www.medialink.com.cy
 * Description: A list of assets auto updated.
 * Version: 1.0.0
 * Author: Sandra Alkiviadous
 * Author URI: http://www.medialink.com.cy
 * License: GPL2
 */


class MarketRatesWidget extends WP_Widget {

    /**
     * Unique identifier for this widget.
     *
     * Will also serve as the widget class.
     *
     * @var string
     */
    protected $widget_slug = 'marketrateswidget';
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
    protected $shortcode = 'marketrateswidget';

    public function __construct() {
        $this->widget_name          = esc_html__( 'Market Rates Widget', 'marketrateswidget' );
        $this->default_widget_title = esc_html__( 'Market Rates Widget', 'marketrateswidget' );
        parent::__construct(
            $this->widget_slug,
            $this->widget_name,
            array(
                'classname'   => $this->widget_slug,
                'description' => esc_html__( 'A list of assets auto updated.', 'marketrateswidget' ),
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

        $class = new MarketRatesWidget();

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
            'marketrateswidget'
        );
        // Before widget hook
        $widget .= $atts['before_widget'];
        // Title
        $widget .= ( $atts['title'] ) ? $atts['before_title'] . esc_html( $atts['title'] ) . $atts['after_title'] : '';

        // wrapper for assets list
        $widget .= '<div id="market-rates"> <ul class="tabs assets assets-categories"> <li><a class="asset-category active" href="#currencies"><span class="asset-icon currencies-icon"><!-- icon --></span>Currencies</a></li> <li><a class="asset-category" href="#commodities"><span class="asset-icon commodities-icon"><!-- icon --></span>Commodities</a></li> <li><a class="asset-category" href="#indices"><span class="asset-icon indices-icon"><!-- icon --></span>Indices</a></li> <li><a class="asset-category" href="#stocks"><span class="asset-icon stocks-icon"><!-- icon --></span>Stocks</a></li> </ul> <div id="indices" class="asset-category-container"> <div id="indices-tab"> <ul class="inner-tabs assets assets-list"> <li><a class="asset-name" href="#DJIA">DJIA</a></li> <li><a class="asset-name" href="#FTSE">FTSE</a></li> <li><a class="asset-name" href="#NSDQ">NSDQ</a></li> <li><a class="asset-name" href="#SP500">SP500</a></li></ul> <div class="asset-outer-container" id="DJIA"> <div class="asset-inner-container"> <p class="aname">DJIA</p> <p class="arate DJIA"></p> </div> <div class="asset-btns"> <a href="/" class="call left"><span class="arrow-up"><!-- icon --></span>Call</a> <a href="/" class="put right"><span class="arrow-down"><!-- icon --></span>Put</a> </div> </div> <div class="asset-outer-container" id="FTSE"> <div class="asset-inner-container"> <p class="aname">FTSE</p> <p class="arate FTSE"></p> </div> <div class="asset-btns"> <a href="/" class="call left"><span class="arrow-up"><!-- icon --></span>Call</a> <a href="/" class="put right"><span class="arrow-down"><!-- icon --></span>Put</a> </div> </div> <div class="asset-outer-container" id="NSDQ"> <div class="asset-inner-container"> <p class="aname">NSDQ</p> <p class="arate NSDQ"></p> </div> <div class="asset-btns"> <a href="/" class="call left"><span class="arrow-up"><!-- icon --></span>Call</a> <a href="/" class="put right"><span class="arrow-down"><!-- icon --></span>Put</a> </div> </div> <div class="asset-outer-container" id="SP500"> <div class="asset-inner-container"> <p class="aname">SP500</p> <p class="arate SP500"></p> </div> <div class="asset-btns"> <a href="/" class="call left"><span class="arrow-up"><!-- icon --></span>Call</a> <a href="/" class="put right"><span class="arrow-down"><!-- icon --></span>Put</a> </div> </div> <div class="asset-outer-container" id="DAX"> <div class="asset-inner-container"> <p class="aname">DAX</p> <p class="arate DAX"></p> </div> <div class="asset-btns"> <a href="/" class="call left"><span class="arrow-up"><!-- icon --></span>Call</a> <a href="/" class="put right"><span class="arrow-down"><!-- icon --></span>Put</a> </div> </div> </div> </div> <div id="currencies" class="asset-category-container"> <div id="currencies-tab"> <ul class="inner-tabs assets assets-list"> <li><a class="asset-name active" href="#EURUSD">EURUSD</a></li> <li><a class="asset-name" href="#USDJPY">USDJPY</a></li> <li><a class="asset-name" href="#GBPUSD">GBPUSD</a></li> <li><a class="asset-name" href="#USDCHF">USDCHF</a></li> </ul> <div class="asset-outer-container" id="EURUSD"> <div class="asset-inner-container"> <p class="aname">EUR vs USD</p> <p class="arate EURUSD"></p> </div> <div class="asset-btns"> <a href="/" class="call left"><span class="arrow-up"><!-- icon --></span>Call</a> <a href="/" class="put right"><span class="arrow-down"><!-- icon --></span>Put</a> </div> </div> <div class="asset-outer-container" id="USDJPY"> <div class="asset-inner-container"> <p class="aname">USD vs JPY</p> <p class="arate USDJPY"></p> </div> <div class="asset-btns"> <a href="/" class="call left"><span class="arrow-up"><!-- icon --></span>Call</a> <a href="/" class="put right"><span class="arrow-down"><!-- icon --></span>Put</a> </div> </div> <div class="asset-outer-container" id="GBPUSD"> <div class="asset-inner-container"> <p class="aname">GBP vs USD</p> <p class="arate GBPUSD"></p> </div> <div class="asset-btns"> <a href="/" class="call left"><span class="arrow-up"><!-- icon --></span>Call</a> <a href="/" class="put right"><span class="arrow-down"><!-- icon --></span>Put</a> </div> </div> <div class="asset-outer-container" id="USDCHF"> <div class="asset-inner-container"> <p class="aname">USD vs CHF</p> <p class="arate USDCHF"></p> </div> <div class="asset-btns"> <a href="/" class="call left"><span class="arrow-up"><!-- icon --></span>Call</a> <a href="/" class="put right"><span class="arrow-down"><!-- icon --></span>Put</a> </div> </div> <div class="asset-outer-container" id="USDCAD"> <div class="asset-inner-container"> <p class="aname">USD vs CAD</p> <p class="arate USDCAD"></p> </div> <div class="asset-btns"> <a href="/" class="call left"><span class="arrow-up"><!-- icon --></span>Call</a> <a href="/" class="put right"><span class="arrow-down"><!-- icon --></span>Put</a> </div> </div> </div> </div> <div id="commodities" class="asset-category-container"> <div id="commodities-tab"> <ul class="inner-tabs assets assets-list"> <li><a class="asset-name" href="#CrudeOil">Crude Oil</a></li> <li><a class="asset-name" href="#Gold">Gold</a></li> <li><a class="asset-name" href="#Silver">Silver</a></li> <li><a class="asset-name" href="#NaturalGas">Natural Gas</a></li> </ul> <div class="asset-outer-container" id="CrudeOil"> <div class="asset-inner-container"> <p class="aname">Crude Oil</p> <p class="arate CrudeOil"></p> </div> <div class="asset-btns"> <a href="/" class="call left"><span class="arrow-up"><!-- icon --></span>Call</a> <a href="/" class="put right"><span class="arrow-down"><!-- icon --></span>Put</a> </div> </div> <div class="asset-outer-container" id="Gold"> <div class="asset-inner-container"> <p class="aname">Gold</p> <p class="arate Gold"></p> </div> <div class="asset-btns"> <a href="/" class="call left"><span class="arrow-up"><!-- icon --></span>Call</a> <a href="/" class="put right"><span class="arrow-down"><!-- icon --></span>Put</a> </div> </div> <div class="asset-outer-container" id="Silver"> <div class="asset-inner-container"> <p class="aname">Silver</p> <p class="arate Silver"></p> </div> <div class="asset-btns"> <a href="/" class="call left"><span class="arrow-up"><!-- icon --></span>Call</a> <a href="/" class="put right"><span class="arrow-down"><!-- icon --></span>Put</a> </div> </div> <div class="asset-outer-container" id="NaturalGas"> <div class="asset-inner-container"> <p class="aname">Natural Gas</p> <p class="arate NaturalGas"></p> </div> <div class="asset-btns"> <a href="/" class="call left"><span class="arrow-up"><!-- icon --></span>Call</a> <a href="/" class="put right"><span class="arrow-down"><!-- icon --></span>Put</a> </div> </div> </div> </div> <div id="stocks" class="asset-category-container"> <div id="stocks-tab"> <ul class="inner-tabs assets assets-list"> </ul> </div> </div> </div> ';

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

        <p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'marketrateswidget' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_html( $instance['title'] ); ?>" placeholder="optional" /></p>

        <?php
    }

    /**
     * scripts function.
     *
     * only load our js file if our widget is added to sidebar
     *
     * @access public
     * @return void
     */
    public function scripts() {
        $get_assets_js = '/wp-content/plugins/marketrates-widget/getAssets.js';
        $market_rates_js = '/wp-content/plugins/marketrates-widget/js/market-rates.js';
        $market_rates_css = '/wp-content/plugins/marketrates-widget/css/market-rates.css';

        if(is_front_page() ) {
//            wp_enqueue_script( 'jquery_js', '//code.jquery.com/jquery-1.10.2.js', array(), 1.0, true );
            wp_enqueue_script( 'get_assets_js', $get_assets_js, array(), 1.0, true );
            wp_enqueue_script( 'market_rates_js', $market_rates_js, array(), 1.0, true );
            wp_enqueue_style( 'market_rates_css', $market_rates_css );
        }

    }

}

function marketrates_register_widgets() {
    register_widget( 'MarketRatesWidget' );
}

add_action( 'widgets_init', 'marketrates_register_widgets' );
