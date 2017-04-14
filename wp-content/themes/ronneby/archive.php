<?php get_template_part('templates/header/top', 'page'); ?>

<section id="layout" class="blog-page dfd-equal-height-children">
    <div class="row">

        <?php
        set_layout('archive');

        get_template_part('templates/content');

        set_layout('archive', false);

        ?>

    </div>
</section>