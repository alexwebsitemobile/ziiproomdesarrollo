<?php

/**
 *
 */
class GitHubUpdater {

	private $slug;
	private $pluginData;
	private $username;
	private $repo;
	private $plugin_file;
	private $githubAPIResult;
	private $access_token;
	private $plugin_activated;

	/**
	 * Class constructor.
	 *
	 * @param  string $plugin_file
	 * @param  string $gitHubUsername
	 * @param  string $gitHubProjectName
	 * @param  string $access_token
	 * @return null
	 */
	function __construct( $plugin_file, $gitHubUsername, $gitHubProjectName, $access_token = '' ) {
		$this->plugin_file = $plugin_file;
		$this->username = $gitHubUsername;
		$this->repo = $gitHubProjectName;
		$this->access_token = $access_token;

		add_filter( "pre_set_site_transient_update_plugins", array( $this, "setTransitent" ) );
		add_filter( "plugins_api", array( $this, "setPluginInfo" ), 10, 3 );
		add_filter( "upgrader_post_install", array( $this, "post_install" ), 10, 3 );
		add_filter( "upgrader_pre_install", array( $this, "pre_install" ), 10, 3 );
	}

	/**
	 * Get information regarding our plugin from WordPress
	 *
	 * @return null
	 */
	private function init_plugin_data() {
		$this->slug = plugin_basename( $this->plugin_file );

		$this->pluginData = get_plugin_data( $this->plugin_file );
	}

	/**
	 * Get information regarding our plugin from GitHub
	 *
	 * @return null
	 */
	private function getRepoReleaseInfo() {
		if ( !empty( $this->githubAPIResult ) ) {
			return;
		}

		$latest_release = jptt_get_option( 'latest_release', false );

		if ( $latest_release ) {
			$too_old = ((time() - $latest_release->last_check) > 3600); // 1 Hour
		} else {
			$too_old = true;
		}


		if ( $too_old ) {
			$latest_release = $this->get_latest_release();

			if ( $latest_release ) {
				$latest_release->last_check = time();
				jptt_update_option( 'latest_release', $latest_release );
			}
		}

		if ( empty( $latest_release ) ) {
			return;
		}

		$this->githubAPIResult = $latest_release;
	}

	/**
	 * Get GitHub latest release info
	 * @return object|bool
	 */
	private function get_latest_release() {
		// Query the GitHub API
		$url = "https://api.github.com/repos/{$this->username}/{$this->repo}/releases/latest";

		if ( !empty( $this->access_token ) ) {
			$url = add_query_arg( array( "access_token" => $this->access_token ), $url );
		}

		// Get the results
		$github_api_result = wp_remote_retrieve_body( wp_remote_get( $url ) );

		$github_latest_release = json_decode( $github_api_result );

		return ($github_latest_release) ? $github_latest_release : FALSE;
	}

	/**
	 * Push in plugin version information to get the update notification
	 *
	 * @param  object $transient
	 * @return object
	 */
	public function setTransitent( $transient ) {

//		var_dump($transient); die;

		if ( empty( $transient->checked ) ) {
			return $transient;
		}

		// Get plugin & GitHub release information
		$this->init_plugin_data();
		$this->getRepoReleaseInfo();

		$update = version_compare( $this->githubAPIResult->tag_name, $transient->checked[$this->slug] );

		if ( $update ) {
			$package = $this->githubAPIResult->zipball_url;

			if ( !empty( $this->access_token ) ) {
				$package = add_query_arg( array( "access_token" => $this->access_token ), $package );
			}

			// Plugin object
			$obj = new stdClass();
			$obj->slug = $this->slug;
			$obj->new_version = $this->githubAPIResult->tag_name;
			$obj->url = $this->pluginData["PluginURI"];
			$obj->package = $package;

			$transient->response[$this->slug] = $obj;
		}

		return $transient;
	}

	/**
	 * Push in plugin version information to display in the details lightbox
	 *
	 * @param  boolean $false
	 * @param  string $action
	 * @param  object $response
	 * @return object
	 */
	public function setPluginInfo( $false, $action, $response ) {
		$this->init_plugin_data();
		$this->getRepoReleaseInfo();

		if ( empty( $response->slug ) || $response->slug != $this->slug ) {
			return $false;
		}

		// Add our plugin information
		$response->last_updated = $this->githubAPIResult->published_at;
		$response->slug = $this->slug;
		$response->plugin_name = $this->pluginData["Name"];
		$response->name = $this->pluginData["Name"];
		$response->version = $this->githubAPIResult->tag_name;
		$response->author = $this->pluginData["AuthorName"];
		$response->homepage = $this->pluginData["PluginURI"];

		// This is our release download zip file
		$downloadLink = $this->githubAPIResult->zipball_url;

		if ( !empty( $this->access_token ) ) {
			$downloadLink = add_query_arg(
					array( "access_token" => $this->access_token ), $downloadLink
			);
		}

		$response->download_link = $downloadLink;

		// Create tabs in the lightbox
		$response->sections = array(
			'Description' => $this->pluginData["Description"],
			'changelog' => class_exists( "Parsedown" ) ? Parsedown::instance()->parse( $this->githubAPIResult->body ) : $this->githubAPIResult->body
		);

		// Gets the required version of WP if available
		$matches = null;
		preg_match( "/requires:\s([\d\.]+)/i", $this->githubAPIResult->body, $matches );
		if ( !empty( $matches ) ) {
			if ( is_array( $matches ) ) {
				if ( count( $matches ) > 1 ) {
					$response->requires = $matches[1];
				}
			}
		}

		// Gets the tested version of WP if available
		$matches = null;
		preg_match( "/tested:\s([\d\.]+)/i", $this->githubAPIResult->body, $matches );
		if ( !empty( $matches ) ) {
			if ( is_array( $matches ) ) {
				if ( count( $matches ) > 1 ) {
					$response->tested = $matches[1];
				}
			}
		}

		return $response;
	}

	/**
	 * Perform check before installation starts.
	 *
	 * @param  boolean $true
	 * @param  array   $args
	 * @return null
	 */
	public function pre_install( $true, $args ) {
		// Get plugin information
		$this->init_plugin_data();

		// Check if the plugin was installed before...
		$this->plugin_activated = is_plugin_active( $this->slug );
	}

	/**
	 * Perform additional actions to successfully install our plugin
	 *
	 * @param  boolean $true
	 * @param  string $hook_extra
	 * @param  object $result
	 * @return object
	 */
	public function post_install( $true, $hook_extra, $result ) {
		global $wp_filesystem;

		// Since we are hosted in GitHub, our plugin folder would have a dirname of
		// reponame-tagname change it to our original one:
		$plugin_folder = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . dirname( $this->slug );
		$wp_filesystem->move( $result['destination'], $plugin_folder );
		$result['destination'] = $plugin_folder;

		// Re-activate plugin if needed
		if ( $this->plugin_activated ) {
			$activate = activate_plugin( $this->slug );
		}

		return $result;
	}

}
