
<?php
/*
Template Name: Page with right sidebar
 */
//get_template_part('templates/header/top','page'); ?>

<section id="layout">
    <div class="row">

        <div class="blog-section sidebar-right dfd-equal-height-children">
            <!-- Breadcrumbs -->
            <div class="breadcrumbs">
                <?php
                # Woocommerce: product or product taxonomy
                if (
                    function_exists('is_product_taxonomy') && is_product_taxonomy()
                    ||
                    function_exists('is_product') && is_product()
                )
                {
                    woocommerce_breadcrumb();
                }
                # Portfolio
                elseif ( is_singular( array( 'product' ) ) && function_exists( 'dfd_potfolio_breadcrumbs' ) ) {
                    dfd_potfolio_breadcrumbs();
                }
                # BBpress || ByddyPress
                elseif (
                    function_exists('bbp_breadcrumb')
                    &&
                    (
                        ( function_exists('is_bbpress') && is_bbpress() )
                        ||
                        ( function_exists('is_buddypress') && is_buddypress() )
                    )
                )
                {
                    bbp_breadcrumb();
                }
                # Default breadcrumbs
                elseif (function_exists('dfd_breadcrumbs')) {
                    dfd_breadcrumbs();
                }
                ?>
            </div>

            <!-- Page Title -->
            <div class="page-title-wrapper">
                <h1 class="page-title"><?php the_title(); ?></h1>
            </div>

            <!-- Page Content -->
            <section id="main-content" role="main" class="nine columns dfd-eq-height">
                <?php get_template_part('templates/content', 'page'); ?>

            </section>
            <?php get_template_part('templates/sidebar', 'right'); ?>
        </div>

    </div>
</section>