<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo('charset') ?>" />
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="<?php bloginfo('description') ?>" />
        <?php get_template_part('templates/icons'); ?>
        <?php wp_head() ?>

    </head>

    <body <?php body_class() ?> itemscope itemtype="http://schema.org/WebPage">

        <?php
        do_action('before_main_content');
        get_template_part('components/bs-main-navbar');
        ?>
        <?php
        $logo_src = get_option('theme_options_logo_src');
        $header_content = get_option('theme_options_header');
        ?>

        <header>
            <figure class="text-center">
                <a class="logo-ziiproom animated fadeIn" href="<?php echo home_url(); ?>">
                    <img src="<?php echo $logo_src; ?>" alt="<?php echo get_option('theme_options_logo_alt'); ?>">
                </a> 
            </figure>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <?php echo $header_content; ?>
                    </div>
                </div>
            </div>
        </header>

