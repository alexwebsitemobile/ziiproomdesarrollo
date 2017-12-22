<?php

defined('ABSPATH') or die('No direct script access allowed');

class Head_Actions {

	private $current_post;
	private $attachmet_image = false;

	private function get_post_data() {
		if (empty($this->current_post)) {
			$this->current_post = get_post();
			$attachment_id = get_post_thumbnail_id($this->current_post->ID);
			if ($attachment_id) {
				$this->attachmet_image = wp_get_attachment_image_src($attachment_id, 'full');
			}
		}
	}

	function open_graph_meta() {
		$has_open_graph_meta = (bool) get_option('open-graph-meta', TRUE);

		if (!$has_open_graph_meta)
			return;

		$meta['og:type'] = 'website';
		$meta['og:site_name'] = get_bloginfo('name');

		if (is_page() || is_singular()) {

			$this->get_post_data();

			$meta['og:title'] = esc_attr($this->current_post->post_title);
			$meta['og:description'] = esc_attr($this->current_post->post_excerpt);
			$meta['og:url'] = get_permalink($this->current_post->ID);


			if ($this->attachmet_image) {
				$meta['og:image'] = $this->attachmet_image[0];
				$meta['og:image:width'] = $this->attachmet_image[1];
				$meta['og:image:height'] = $this->attachmet_image[2];
			}

			if (!is_front_page()) {
				$meta['og:type'] = 'article';
				$meta['article:published_time'] = mysql2date('c', $this->current_post->post_date);
				$meta['article:modified_time'] = mysql2date('c', $this->current_post->post_modified);
			}

		}

		$meta = (array) apply_filters('open_graph_meta', $meta);

		echo "<!-- Open Graph -->\n";
		foreach ($meta as $key => $value) {
			if (!empty($value)) {
				printf('<meta property="%s" content="%s" />' . "\n", $key, $value);
			}
		}
	}

	function twitter_card_meta() {
		$has_twitter_card_meta = (bool) get_option('twitter-card-meta', TRUE);

		if (!$has_twitter_card_meta)
			return;

		$meta['twitter:card'] = 'summary';

		if (is_page() or is_singular()) {

			$this->get_post_data();

			$meta['twitter:title'] = esc_attr($this->current_post->post_title);
			$meta['twitter:description'] = esc_attr($this->current_post->post_excerpt);
			$meta['twitter:url'] = get_permalink($this->current_post->ID);

			if ($this->attachmet_image) {
				$meta['twitter:card'] = 'summary_large_image';
				$meta['twitter:image:src'] = $this->attachmet_image[0];
				$meta['twitter:image:width'] = $this->attachmet_image[1];
				$meta['twitter:image:height'] = $this->attachmet_image[2];
			}
		}

		$meta = (array) apply_filters('twitter_card_meta', $meta);

		echo "<!-- Twitter Card -->\n";
		foreach ($meta as $key => $value) {
			if (!empty($value)) {
				printf('<meta name="%s" content="%s" />' . "\n", $key, $value);
			}
		}
	}

	function facebook_meta() {

		echo "<!-- Facebook -->\n";

		$facebook_admins = (string) get_option('social-facebook-admins', TRUE);
		$fb_explode = explode(',', $facebook_admins);
		foreach ($fb_explode as $admin) {
			$admin_id = (int) $admin;
			if ($admin_id > 1) {
				printf('<meta property="fb:admins" content="%s" />' . "\n", $admin_id);
			}
		}

		$facebook_app_id = (string) get_option('social-facebook-app_id', TRUE);
		$fb_explode = explode(',', $facebook_app_id);
		foreach ($fb_explode as $admin) {
			$admin_id = (int) $admin;
			if ($admin_id > 1) {
				printf('<meta property="fb:app_id" content="%s" />' . "\n", $admin_id);
			}
		}
	}

	function admin_ajax() {
		$admin_ajax = apply_filters('admin_ajax', admin_url('admin-ajax.php'));
		printf("<script>var admin_url = '%s';</script>\n", $admin_ajax);
	}

	function google_analytics_tracking_code() {
		$google_analytics = get_option('google-analytics', '');
		$has_tags = !is_bool(strpos($google_analytics, '<script>'));

		$format = ($has_tags) ? "%s\n": "<script>\n%s\n</script>\n";

		if (!empty($google_analytics)) {
			printf($format, $google_analytics);
		}
	}

	function google_tag_manager_code() {
		$google_tag_manager = get_option('google-tag-manager', '');

		if (!empty($google_tag_manager)) {
			echo "\n {$google_tag_manager} \n";
		}
	}

	function google_site_verification() {
		$google_site_verification = esc_attr(get_option('google-site-verification', ''));
		if (!empty($google_site_verification)) {
			printf('<meta name="google-site-verification" content="%s" />' . "\n", $google_site_verification);
		}
	}

	function bing_site_verification() {
		$bing_site_verification = esc_attr(get_option('bing-site-verification', ''));
		if (!empty($bing_site_verification)) {
			printf('<meta name="msvalidate.01" content="%s" />' . "\n", $bing_site_verification);
		}
	}

	function remove_header_links() {
		// Remove WordPress Version Number
		if ((bool) get_option('remove-generator'))
			remove_action('wp_head', 'wp_generator');
		// Remove Category Feeds
		if ((bool) get_option('remove-feed-links-extra'))
			remove_action('wp_head', 'feed_links_extra', 3);
		// Remove Post and Comment Feeds
		if ((bool) get_option('remove-feed-links'))
			remove_action('wp_head', 'feed_links', 2);
		// Remove EditURI link
		if ((bool) get_option('remove-rsd-link'))
			remove_action('wp_head', 'rsd_link');
		// Remove Windows Live Writer
		if ((bool) get_option('remove-wlwmanifest-link'))
			remove_action('wp_head', 'wlwmanifest_link');
		// Remove index link
		if ((bool) get_option('remove-index-rel-link'))
			remove_action('wp_head', 'index_rel_link');
		// Remove previous link
		if ((bool) get_option('remove-parent-post-rel-link'))
			remove_action('wp_head', 'parent_post_rel_link', 10, 0);
		// Remove start link
		if ((bool) get_option('remove-start_post-rel-link'))
			remove_action('wp_head', 'start_post_rel_link', 10, 0);
		// Remove Links for Adjacent Posts
		if ((bool) get_option('remove-adjacent_posts-rel-link-wp_head'))
			remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	}

}

$Head_Actions = new Head_Actions();
add_action('init', array($Head_Actions, 'remove_header_links'), 1);
add_action('wp_head', array($Head_Actions, 'open_graph_meta'), 1);
add_action('wp_head', array($Head_Actions, 'twitter_card_meta'), 1);
add_action('wp_head', array($Head_Actions, 'facebook_meta'), 1);
add_action('wp_head', array($Head_Actions, 'google_site_verification'), 1);
add_action('wp_head', array($Head_Actions, 'bing_site_verification'), 1);
add_action('wp_head', array($Head_Actions, 'google_analytics_tracking_code'), 99);
//add_action('wp_head', array($Head_Actions, 'google_tag_manager_code'), 99);
add_action('wp_head', array($Head_Actions, 'admin_ajax'), 99);
