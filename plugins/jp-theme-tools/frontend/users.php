<?php

defined('ABSPATH') or die('No direct script access allowed');

/**
 * @since v0.9.0
 * @author jprieton
 */
class Frontend_Users {

	/**
	 * Maximum login attempts
	 * @since v0.9.0
	 * @var int
	 */
	private $max_login_attempts;

	public function __construct() {
		$this->max_login_attempts = (int) get_option('max-login-attemps', -1);
		$this->error = new \jptt\core\Error();
	}

	/**
	 * Bloquear usuario
	 * @since v0.9.0
	 * @param int $user_id
	 */
	public function block_user($user_id) {
		update_user_meta($user_id, 'user_blocked', TRUE);
	}

	/**
	 * Desbloquear usuario
	 * @since v0.9.0
	 * @param int $user_id
	 */
	public function unblock_user($user_id) {
		delete_user_meta($user_id, 'user_blocked');
	}

	/**
	 * Agregar intentos fallidos al contador
	 * @since v0.9.0
	 * @param int $user_id
	 * @return int Login attemps
	 */
	public function add_login_attempt($user_id) {
		$login_attempts = (int) get_user_meta($user_id, 'login_attempts', TRUE);
		$login_attempts++;
		update_user_meta($user_id, 'login_attempts', $login_attempts);
		return $login_attempts;
	}

	/**
	 * Borrar intentos fallidos
	 * @since v0.9.0
	 * @param int $user_id
	 */
	public function remove_user_attempt($user_id) {
		delete_user_meta($user_id, 'login_attempts');
	}

}
