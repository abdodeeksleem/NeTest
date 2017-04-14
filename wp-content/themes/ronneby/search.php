<?php get_template_part('templates/header/top', 'page'); ?>

<section id="layout" class="search-page blog-page dfd-equal-height-children">
    <div class="row">

        <?php
        set_layout('search');

        get_template_part('templates/content','search');

        set_layout('search', false);

        ?>

    </div>
</section>