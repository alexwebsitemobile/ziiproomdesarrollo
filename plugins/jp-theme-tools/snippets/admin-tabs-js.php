<script>
	jQuery(function () {
		jQuery('.nav-tab-wrapper a').click(function (e) {
			e.preventDefault();
			jQuery('.data-tab').hide();
			jQuery('.nav-tab-wrapper a').removeClass('nav-tab-active');
			var tabContent = jQuery(this).data('target');
			jQuery(tabContent).stop().show();
			jQuery(this).addClass('nav-tab-active');
		});

		jQuery('a.nav-tab-active').trigger('click');
	});
</script>
