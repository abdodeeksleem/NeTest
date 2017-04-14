<?php /* Template Name: Landing Page */ ?>

    <section id="layout" class="blog-page dfd-equal-height-children landing-page-bonus">
        <div class="row">

            <?php
            set_layout('pages');

            get_template_part('templates/content', 'page');

            set_layout('pages', false);

            ?>
        </div>
    </section>


