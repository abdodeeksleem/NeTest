<?php
global $sitepress;
$default_language = $sitepress->get_default_language();
?>

<script src='//www.mte-media.com/admin2/js/mte.js'></script>

<script>
    var userRef='47fe7ff', language='<?php if ($default_language != ICL_LANGUAGE_CODE) { echo "en"; } else { echo "ar"; } ?>', mte_idx=true, set='Default';
    var products=['pre','ebk','vid','sir','dem'];
    (function($) {
        $(document).on('MTE_IDX_READY', function(){Idx=new Mte_idx(products,set);});
    })(jQuery);
</script>

<section id='learning_center'></section>