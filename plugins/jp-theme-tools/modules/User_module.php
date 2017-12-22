<?php

defined('ABSPATH') or die('No direct script access allowed');

class JPTT_Users_module {

	private $max_login_attempts;

	public function __construct() {
		$this->max_login_attempts = (int) get_option('max_login_attemps', -1);
	}

	public function login_user() {
		global $jptt;
		$jptt instanceof JPTT;

		$verify_wpnonce = $jptt->input->verify_wpnonce('frontend_login_user');

		if (!$verify_wpnonce) {
			$jptt->error->method_rejected(__FUNCTION__);
			wp_send_json_error($jptt->error);
		}

		$user_login = $jptt->input->post('user_login', '', FILTER_SANITIZE_STRIPPED);
		$user_password = $jptt->input->post('user_password', '', FILTER_SANITIZE_STRIPPED);
		$remember = $jptt->input->post('remember', '', FILTER_SANITIZE_STRIPPED);
	}

	/**
	 *
	 * @global JPTT $jptt
	 */
	public function user_register() {
		global $jptt;
		$jptt instanceof JPTT;

		$verify_wpnonce = $jptt->input->verify_wpnonce('frontend_user_register');

		if (!$verify_wpnonce) {
			$jptt->error->method_rejected(__FUNCTION__);
			wp_send_json_error($jptt->error);
		}

		$userdata = array(
				'user_pass' => $jptt->input->post('user_pass', '', FILTER_SANITIZE_STRIPPED),
				'user_login' => $jptt->input->post('user_email', '', FILTER_SANITIZE_EMAIL),
				'user_email' => $jptt->input->post('user_email', '', FILTER_SANITIZE_EMAIL)
		);

		$userdata = apply_filters('before_frontend_user_register', $userdata);

		do_action('before_frontend_user_register', $userdata);

		if (!is_email($userdata['user_email'])) {
			$error = new WP_Error('bad_user_email', 'Disculpa, el email suministrado es inválido');
			wp_send_json_error($error);
		}

		$user_id = wp_insert_user($userdata);

		do_action('after_frontend_user_register', $userdata);

		if (is_wp_error($user_id)) {
			wp_send_json_error($user_id);
		} else {
			add_user_meta($user_id, 'show_admin_bar_front', 'false');
			$response[] = array(
					'code' => 'user_register_success',
					'message' => 'Registro exitoso',
			);
			wp_send_json_success($response);
		}
	}

	/**
	 *
	 * @global JPTT $jptt
	 */
	public function update_user_pass() {
		global $jptt;
		$jptt instanceof JPTT;

		$verify_wpnonce = $jptt->input->verify_wpnonce('frontend_update_user_pass');

		if (!$verify_wpnonce) {
			$jptt->error->method_rejected(__FUNCTION__);
			wp_send_json_error($jptt->error);
		}

		$current_pass = $jptt->input->post('current_pass', '', FILTER_SANITIZE_STRIPPED);
		$new_pass = $jptt->input->post('new_pass', '', FILTER_SANITIZE_STRIPPED);
		$verify_pass = $jptt->input->post('verify_pass', '', FILTER_SANITIZE_STRIPPED);

		if (empty($current_pass) || empty($new_pass) || empty($verify_pass)) {
			$jptt->error->incorrect_data(__FUNCTION__);
			wp_send_json_error($jptt->error);
		}

		if ($new_pass != $verify_pass) {
			$jptt->error->add('password_not_macth', "Your new password does not match the verification");
			wp_send_json_error($jptt->error);
		}

		$user_id = get_current_user_id();
		$current_user = get_user_by('id', $user_id);
		$valid_pass = wp_check_password($current_pass, $current_user->get('user_pass'), $user_id);

		if (!$valid_pass) {
			$jptt->error->add('password_not_macth', "The actual password does not match");
			wp_send_json_error($jptt->error);
		}

		wp_set_password($new_pass, $user_id);

		$data[] = array(
				'code' => 'success_update',
				'message' => 'Contraseña actualizada exitosamente'
		);
		wp_send_json_success($data);
	}

}

add_action('wp_ajax_frontend_update_user_pass', array(new JPTT_Users_module, 'update_user_pass'));
//add_action('wp_ajax_nopriv_frontend_login_user', array(new JPTT_Users_module, 'login_user'));
//add_action('wp_ajax_nopriv_frontend_user_register', array(new JPTT_Users_module, 'user_register'));
