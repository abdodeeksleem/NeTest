<?php
/**
 * @author    DGMedialink <info@dgmedialink.com>
 * @link      http://www.dgmedialink.com/
 * @copyright 2015
 */

if( !defined( 'ABSPATH') ) exit();


class VentureAdmin {

    const VIEW_SLIDER = "slider";
    const VIEW_SLIDER_TEMPLATE = "slider_template"; //obsolete
    const VIEW_SLIDERS = "sliders";
    const VIEW_SLIDES = "slides";
    const VIEW_SLIDE = "slide";

    /**
     * the constructor
     */

    public function __construct(){

        $this->init();

    }


    /**
     * init all actions
     */
    private function init(){
        // Hook for adding admin menus
        add_action('admin_menu',array('VentureAdmin','mt_add_pages'));

    }


    public function mt_add_pages() {

        require_once(VENTURE_PLUGIN_PATH.'/admin/admin-view/venture-admin-view.php');
        // Add a new top-level menu :
        add_menu_page(__('Venture Plugin','menu-test'), __('Venture Plugin','menu-test'), 'manage_options', 'venture-top', 'mt_toplevel_page' );
        // Add a submenu to the custom top-level menu:
        add_submenu_page('venture-top', __('Email Configuration','menu-test'), __('Test Sublevel','menu-test'), 'manage_options', 'sub-page', 'mt_sublevel_page');

    }


    /**
     * a must function. please don't remove it.
     * process activate event - install the db (with delta).
     */




}
?>