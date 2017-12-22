<?php
get_header();
$bg_src = get_option('theme_options_bg_src');
$contact_form = get_option('theme_options_contact_form');
?>
<div class="bg-picture" style="background: url(<?php echo $bg_src; ?>) center center no-repeat; background-size: cover;">
    <div class="pattern"></div>
</div>

<div class="content-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 text-center">
                <h2>Please join our mailing list to stay informed</h2>
                <?php echo do_shortcode('[contact-form-7 id="311" title="Contact form 1"]'); ?>
				<div class="footer-page">
				<?php echo get_option('theme_options_footer'); ?>
				</div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>