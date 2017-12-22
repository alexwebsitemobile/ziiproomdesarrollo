<div class="responsive-helper">
	<pre class="modernizr-features hidden"></pre>
	<div>
		<div class="bs-breakpoint" title="Boostrap breakpoint">
			<div class="visible-xxs">xxs</div>
			<div class="visible-xs hidden-xxs">xs</div>
			<div class="visible-sm">sm</div>
			<div class="visible-md">md</div>
			<div class="visible-lg">lg</div>
		</div>
		<div class="modernizr-btn" title="moderinzr features">modernizr</div>
		<div class="info-window" title="Window height & width">
			<div class="info2">H:<span class="rh-height"></span></div>
			<div class="info2">W:<span class="rh-width"></span></div>
		</div>
		<div class="rh-collapse"><span>&raquo;</span><span>&laquo;</span></div>
	</div>
</div>
<script>
  jQuery('.modernizr-btn').click(function (e) {
      e.preventDefault();
      var features = jQuery('html').attr('class');
      jQuery('.modernizr-features').text(features);
      jQuery('.modernizr-features').toggleClass('hidden');
  });
  jQuery('.rh-collapse').click(function () {
      jQuery(this).toggleClass('rh-collapsed');
      if (jQuery('.rh-collapsed').length > 0) {
          jQuery('.responsive-helper').find('.modernizr-features, .bs-breakpoint, .modernizr-btn, .info-window').addClass('hidden');
      } else {
          jQuery('.responsive-helper').find('.bs-breakpoint, .modernizr-btn, .info-window').removeClass('hidden');
      }
  });
  jQuery(window).on('resize scroll', function () {
      jQuery('.responsive-helper .info-window .rh-height').text(jQuery(window).height());
      jQuery('.responsive-helper .info-window .rh-width').text(jQuery(window).width());
  });

  jQuery(window).trigger('resize');
</script>