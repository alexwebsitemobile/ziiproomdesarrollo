<?php

namespace jptt\core;

defined('ABSPATH') or die('No direct script access allowed');

require_once __DIR__ . '/class-error.php';

/**
 * @since  0.9.0
 * @author jprieton
 */
class Users {

	/**
	 * Maximum login attempts
	 * @since v0.9.0
	 * @var int
	 */
	private $max_login_attempts;

	public function __construct() {
		$this->max_login_attempts = (int) get_option('max-login-attemps', -1);
	}

	/**
	 * Inicio de sesion de usuarios
	 * @since v0.9.0
	 */
	public function user_login($submit) {

		$Error = new \jptt\core\Error();

		$user_id = username_exists($submit['user_login']);
		if (empty($user_id)) {
			$Error->add('user_failed', 'Usuario o contraseña incorrectos');
			return $Error;
		}

		$user_blocked = (bool) $this->is_user_blocked($user_id);
		if ($user_blocked) {
			$Error->add('user_blocked', 'Disculpa, usuario bloqueado');
			return $Error;
		}

		$user = wp_signon($submit, false);

		if (is_wp_error($user)) {
			$this->add_user_attempt($user_id);

			$user_blocked = (bool) $this->is_user_blocked($user_id);

			if ($user_blocked) {
				$Error = new WP_Error('user_blocked', 'Disculpa, usuario bloqueado');
				return $Error;
			} else {
				return $user;
			}
		} else {
			$this->clear_user_attempt($user_id);
			$response[] = array(
					'code' => 'user_signon_success',
					'message' => 'Has iniciado sesión exitosamente',
			);
			return $response;
		}
	}

	public function user_register($userdata) {
		$user_id = wp_insert_user($userdata);

		if (is_wp_error($user_id)) {
			return $user_id;
		} else {
			add_user_meta($user_id, 'show_admin_bar_front', 'false');
			$response[] = array(
					'code' => 'user_register_success',
					'message' => 'Registro exitoso',
					'user_id' => $user_id,
			);
			return $response;
		}
	}

	/**
	 * Verifica si el usuario esta bloqueado
	 * @param int|string $user_id
	 * @return boolean
	 * @since v0.9.0
	 */
	private function is_user_blocked($user_id) {

		if (!is_int($user_id)) {
			$user_id = (bool) username_exists($user_id);
		}

		if ($user_id == 0) {
			return FALSE;
		}

		$user_blocked = (bool) get_user_meta($user_id, 'user_blocked', FALSE);

		if ($this->max_login_attempts < 0) return FALSE;

		if ($user_blocked) return TRUE;

		$user_attemps = get_user_meta($user_id, 'login_attempts', TRUE);

		if ($user_attemps > $this->max_login_attempts) {
			$this->block_user($user_id);
			$user_blocked = TRUE;
		}
		return $user_blocked;
	}

	/**
	 * Bloquear usuarios
	 * @param int $user_id
	 * @since v0.9.0
	 */
	private function block_user($user_id) {
		add_user_meta($user_id, 'user_blocked', TRUE, TRUE);
	}

	/**
	 * Agregar intentos fallidos al contador de usuarios
	 * @param int $user_id
	 * @since v0.9.0
	 */
	private function add_user_attempt($user_id) {
		$login_attempts = (int) get_user_meta($user_id, 'login_attempts', TRUE);
		$login_attempts++;
		update_user_meta($user_id, 'login_attempts', $login_attempts);
	}

	/**
	 * Desbloquear usuarios y borrar intentos fallidos
	 * @param int $user_id
	 * @since v0.9.0
	 */
	private function clear_user_attempt($user_id) {
		update_user_meta($user_id, 'login_attempts', 0);
	}

	public function update_user_pass($current_pass, $new_pass) {

		$Error = new \jptt\core\Error();

		if (!is_user_logged_in()) {
			$Error->user_not_logged(__FUNCTION__);
			return $Error;
		}

		$user_id = get_current_user_id();
		$current_user = get_user_by('id', $user_id);

		$valid_pass = wp_check_password($current_pass, $current_user->get('user_pass'), $user_id);

		if (!$valid_pass) {
			$Error->add('bad_user_pass', __('Current pass invalid', 'jpwp'));
			return $Error;
		}

		wp_set_password($new_pass, $user_id);

		$data[] = array(
				'code' => 'success_update',
				'message' => 'Contraseña actualizada exitosamente'
		);
		return $data;
	}

}
