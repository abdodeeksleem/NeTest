<?php

class Dfd_User_Form_Manager {

    private $param_name = "check_layout";
    private $fake_param_name = "fake_check_layout";
    private $param_type = "dfd_check_layout";

    /**
     *
     * @var Dfd_User_Form_Manager $_instance 
     */
    private static $_instance = null;

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function __construct() {
        $this->init();
    }

    public function init() {
        require_once locate_template("/inc/user_form/template_manager.php");
    }

    public function getParamName() {
        return $this->param_name;
    }

    public function getFakeParamName() {
        return $this->fake_param_name;
    }

    public function getParamType() {
        return $this->param_type;
    }

    public function getoptions() {
        
        $files =  Dfd_User_Form_template_manager::instance()->getAllTempletes();
        $res_arr= array();
        //revers key and  value
        foreach ($files as $key => $value) {
            $res_arr[$value] = $key;
        }
        return $res_arr;

    }
    public function generateDependencys() {
        return 1;
    }
    public function getParams() {
        return array(
                array(
                        'type' => 'dfd_check_layout',
                        'heading' => __('Category title', 'dfd'),
                        'param_name' => $this->param_name,
                        'description' => __('Please enter the title of the category in sort panel for this item', 'dfd'),
                        'options' => $this->getoptions()
                ),
                array(
                        'type' => 'checkbox',
                        'class' => '',
                        'heading' => __('Enable sort panel', 'dfd'),
                        'param_name' => $this->fake_param_name,
                        'value' => $this->getoptions()
                ),
                array(
                        'type' => 'textfield',
                        'heading' => __('Extra class name', 'js_composer'),
                        'param_name' => 'el_class',
                        'dependency' => Array('element' => $this->fake_param_name, 'value' => array('val2')),
                        'group' => __('Design Options', 'js_composer'),
                        'description' => __('If you wish to style particular content element differently.', 'js_composer')
                ),                
                $this->generateDependencys(),
        );
    }

}
