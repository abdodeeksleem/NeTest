<?php

class Dfd_User_Form_template_manager {

    private $_files = array();
    public $template_layout_folder = "/inc/user_form/templetes/";
    public $template_img_folder = "/inc/user_form/templetes/img/";

    /**
     *
     * @var Dfd_User_Form_template_manager $_instance 
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
        $this->findTemplateFiles();
//        print_r($this->_files);
//        echo "=" . $this->getTempleteByName("template-layout2");
    }

    public function getTemplateLayoutFolder() {
        return locate_template($this->template_layout_folder);
    }

    public function gettemplateImgFolder() {
        return locate_template($this->template_img_folder);
    }

    public function findTemplateFiles() {
        $this->_files = array();
        if (is_dir($this->getTemplateLayoutFolder())) {
            if ($handle = opendir($this->getTemplateLayoutFolder())) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != ".." && !is_dir($this->getTemplateLayoutFolder() . $entry)) {
                        $this->_files[basename($entry, ".php")] = $entry;
                    }
                }
                closedir($handle);
            }
        }
    }

    public function getImgNameByTemplate($tempalteName) {
        
    }

    public function getTempleteByName($templateName) {
        if (key_exists($templateName, $this->_files)) {
            return $templateName;
        }
        return '';
    }

    public function getAllTempletes() {
        return $this->_files;
    }

}
