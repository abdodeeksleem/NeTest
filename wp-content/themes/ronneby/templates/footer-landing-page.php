<?php /* Template Name: Footer Landing Page */ ?>
<?php
//$pageTitle=str_replace(' ', '-', strtolower($post->post_title));
function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
?>
<div id="footer-wrap-landing">
    <section id="footer-landing " class="<?php echo 'footer-'; echo clean(strtolower($post->post_title));?>">
        <div class="row">
            <?php if($post->post_title == 'Bonus') { ?>
            <div class="columns six"><h6 class="title-header">
            <?php
            echo __("Connect with the world’s most profitable traders and start generating profits.", "text");?></h6>
                <?php echo do_shortcode('[lead_registration_lp]');
            ?>
            </div>


            <div class="columns six">
                <h6 class="title-header">
                    <?php
                    echo __("Trade with Ettemad and access the world markets", "text");?></h6>
                <ul class="footer-list-landing">
                    <li><span></span><?php echo __("Follow and copy successful traders", "text");?></li>
                    <li><span></span><?php echo __("Personal manager for each customer", "text");?></li>
                    <li><span></span><?php echo __(" Learn and practice free", "text");?></li>
                    <li><span></span><?php echo __("Best social trading platform - SIRIX", "text");?></li>
                    <li><span></span><?php echo __("Daily  promotions", "text");?></li>
                    <li><span></span><?php echo __("Leverage up to 1:500", "text");?></li>
                    <li><span></span><?php echo __("Free forex eBook", "text");?></li>
                    <li><span></span><?php echo __("Security of funds", "text");?></li>
                </ul>

            </div>
            <?php }else if($post->post_title == 'New to forex trading?') {?>
            <div class="columns six"><h6 class="title-header">
                    <?php
                    echo __("Learn how to trade the financial markets with Ettemad Social Trading!", "text");?></h6>
                <?php echo do_shortcode('[lead_registration_lp]');
                ?>
            </div>


            <div class="columns six">
                <h6 class="title-header">
                    <?php
                    echo __("Key trading features", "text");?></h6>
                <ul class="footer-list-landing">

                    <li><span></span><?php echo __("Free eBook", "text");?></li>
                    <li><span></span><?php echo __("One click order", "text");?></li>
                    <li><span></span><?php echo __("Multi-language support", "text");?></li>
                    <li><span></span><?php echo __("User friendly trading environment", "text");?></li>
                    <li><span></span><?php echo __("The opportunity to observe and follow other traders' trading strategies", "text");?></li>
                    <li><span></span><?php echo __(" Intuitive charts and graphs", "text");?></li>
                </ul>

            </div>
            <?php } ?>
        </div>

        <div class="row-fluid legal-info">

            <div class="logo columns one">
                <a href="<?php echo home_url(); ?>/" class="fixed-header-logo">
                    <span class="footer-logo"></span>
                </a>
            </div>
            <div class="legal columns ten">
                <p><span><?php echo __("&copy;2016 Ettemad.com Legal Information Privacy Policy Terms & Conditions", "text");?></span></p>

                <p>
                    <?php
                    $url = '/terms-and-conditions';
                    $link = sprintf( wp_kses( __( 'Trading in Forex and CFDs carry a high level of risk and can result in loss of part or all of your investment (deposit). The high degree of leverage that is obtainable in the trading of Forex and CFDs can work both against you as well as for you. You should not invest money that you cannot afford to lose. Should you have any doubts, you should seek advice from an independent and suitably licensed financial advisor. You should further make sure that you have sufficient time to manage your investments on an active basis. Ettemad does not provide investment advice and the information provided herein is intended for marketing purposes only and should not relied on an investment advice. Any indication of past performance of a financial instrument is not a reliable indicator of current and/or future performance of such financial instrument. Please read our <a href="%s">terms and condition</a> and Risk Disclosure before conducting and trades.', 'text' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( $url ) );
                    echo $link;
                    ?>
                </p>

                </div>
        </div>
        </section>
</div>

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5HVJCJ"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5HVJCJ');</script>
<!-- End Google Tag Manager -->
