<?php
/*
 */
if (!class_exists('Dfd_Check_Layout')) {

    class Dfd_Check_Layout {

        function __construct() {
            if (function_exists('add_shortcode_param')) {
                add_shortcode_param('dfd_check_layout', array(&$this, 'radio_image_settings_field'));
            }
        }

        function radio_image_settings_field($settings, $value) {
            ob_start();
            $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
            $type = isset($settings['type']) ? $settings['type'] : '';
            $options = isset($settings['options']) ? $settings['options'] : '';
            $class = isset($settings['class']) ? $settings['class'] : '';
            $fake_checkbox = Dfd_User_Form_Manager::instance()->getFakeParamName();
            $uni = uniqid();
//            $json_js = json_encode($fake_checkbox);
            $output = '';
            ?>
            <input id="radio_image_setting_val_<?php echo $uni; ?>" 
                   class="wpb_vc_param_value
                   <?php echo $param_name . ' ' . $type . ' ' . $class . ' ' . $value . ' vc_ug_gradient"' ?>"
                   name="<?php echo $param_name ?>"  style="display:none"  value="<?php echo $value ?> "/>

            <div class="ult-radio-image-box" data-uniqid="<?php echo $uni ?>">
                <?php
                foreach ($options as $key => $img_url) {
                    if ($value == $key)
                        $checked = 'checked';
                    else
                        $checked = '';
                    ?>
                    <label>
                        <input type="radio" name="radio_image_<?php echo $uni ?>" <?php echo $checked ?> data-value="<?php echo $img_url; ?>" class="radio_pattern_image" value="<?php echo $key ?>" />
                        <span class="pattern-background"></span>
                    </label>
                    <?php
                }
                ?>
            </div>
            <style>
                .ult-radio-image-box label > input{ /* HIDE RADIO */
                    display:none;
                }
                .ult-radio-image-box label > input + img{ /* IMAGE STYLES */
                    cursor:pointer;
                    border:2px solid transparent;
                }
                .ult-radio-image-box .no-bg {
                    border:2px solid #ccc;
                }
                .ult-radio-image-box label > input:checked + img, .ult-radio-image-box label > input:checked + .pattern-background{ /* (CHECKED) IMAGE STYLES */
                    border:2px solid #f00 ;
                }
                .pattern-background {                               
                    width: 100px;
                    height: 100px;
                    border:2px solid #ccc;;
                    display: inline-block;
                }
                .radio_pattern_image{
                    display: none ;
                }
            </style>

            <script type="text/javascript">
                (function ($) {
                    var defaults = {
                        fake_checkbox: '<?php echo $fake_checkbox; ?>'
                    };
                    var Dfd_User_Form = {
                        params: {
                            data_val: "",
                            fake_checkbox: "",
                        },
                        init: function (par) {
                            var options;
                            options = $.extend({}, defaults, par);
                            $(".radio_pattern_image").change(function () {
                                var radio_id = $(this).parent().parent().data("uniqid");
                                var val = $(this).val();
                                var data_val = $(this).data("value");
                                Dfd_User_Form.params.data_val = data_val;
                                Dfd_User_Form.params.fake_checkbox = options.fake_checkbox;
                                $("#radio_image_setting_val_" + radio_id).val(val);
                                Dfd_User_Form.resetCheckboxes();
                            });
                        },
                        resetCheckboxes: function () {
                            $(".fake_check_layout").each(function (index) {
                                $(this).attr("checked", false);
                            });
                            console.log("#" + Dfd_User_Form.params.fake_checkbox + "-" + Dfd_User_Form.params.data_val);
                            $("#" + Dfd_User_Form.params.fake_checkbox + "-" + Dfd_User_Form.params.data_val).click();
                        }
                    };
                    Dfd_User_Form.init();
                })(jQuery)

            </script>
            <?php
            $output .= ob_get_clean();
            return $output;
        }

    }

}

if (class_exists('Dfd_Check_Layout')) {
    $Ultimate_Radio_Image_Param = new Dfd_Check_Layout();
}
