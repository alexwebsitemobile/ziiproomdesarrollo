<?php

defined('ABSPATH') or die("No script kiddies please!");

require_once JPTT_BASEPATH . 'core/class-error.php';

class User_Actions {

	/**
	 * Maximum login attempts
	 * @var int
	 */
	private $max_login_attempts;

	/**
	 *
	 * @var \jptt\core\Error
	 */
	private $error;

	public function __construct() {
		$this->max_login_attempts = (int) get_option('max-login-attemps', -1);
		$this->error = new \jptt\core\Error();
	}

	/**
	 * Inicio de sesion de usuarios
	 * JSON
	 */
	public function user_signon() {
		$nonce = filter_input(INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING);
		$verify_nonce = (bool) wp_verify_nonce($nonce, 'user_signon');

		if (!$verify_nonce) {
			$this->error->method_rejected(__FUNCTION__);
			wp_send_json_error($this->error);
		}

		$submit = array(
				'user_login' => filter_input(INPUT_POST, 'user_login', FILTER_SANITIZE_STRING),
				'user_password' => filter_input(INPUT_POST, 'user_password', FILTER_SANITIZE_STRING),
				'remember' => filter_input(INPUT_POST, 'remember', FILTER_SANITIZE_STRING)
		);

		$user_id = username_exists($submit['user_login']);
		$user_blocked = (bool) $this->is_user_blocked($user_id);

		if ($user_blocked) {
			$this->error->add('user_blocked', 'Disculpa, usuario bloqueado');
			wp_send_json_error($this->error);
		}

		$user = wp_signon($submit, false);

		if (is_wp_error($user)) {
			$this->add_user_attempt($user_id);

			$user_blocked = (bool) $this->is_user_blocked($user_id);

			if ($user_blocked) {
				$error = new WP_Error('user_blocked', 'Disculpa, usuario bloqueado');
				wp_send_json_error($error);
			} else {
				wp_send_json_error($user);
			}
		} else {
			$this->clear_user_attempt($user_id);
			$response[] = array(
					'code' => 'user_signon_success',
					'message' => 'Has iniciado sesión exitosamente',
			);
			wp_send_json_success($response);
		}
	}

	/**
	 * Registro de usuarios
	 * JSON
	 */
	public function user_register() {
		$nonce = filter_input(INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING);
		$verify_nonce = (bool) wp_verify_nonce($nonce, 'user_register');


		if (!$verify_nonce) {
			$error = new WP_Error('method_error', 'Método no adimitido');
			wp_send_json_error($error);
		}

		do_action('pre_user_register');

		$userdata = array(
				'user_pass' => filter_input(INPUT_POST, 'user_password'),
				'user_login' => filter_input(INPUT_POST, 'user_email'),
				'user_email' => filter_input(INPUT_POST, 'user_email')
		);

		if (!is_email($userdata['user_email'])) {
			$error = new WP_Error('bad_user_email', 'Disculpa, el email suministrado es inválido');
			wp_send_json_error($error);
		}

		$user_id = wp_insert_user($userdata);

		do_action('post_user_register', $user_id);

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
	 * Verifica si el usuario esta bloqueado
	 * @param int|string $user_id
	 * @return boolean
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
	 */
	private function block_user($user_id) {
		add_user_meta($user_id, 'user_blocked', TRUE, TRUE);
	}

	/**
	 * Agregar intentos fallidos al contador de usuarios
	 * @param int $user_id
	 */
	private function add_user_attempt($user_id) {
		$login_attempts = (int) get_user_meta($user_id, 'login_attempts', TRUE);
		$login_attempts++;
		update_user_meta($user_id, 'login_attempts', $login_attempts);
	}

	/**
	 * Desbloquear usuarios y borrar intentos fallidos
	 * @param int $user_id
	 */
	private function clear_user_attempt($user_id) {
		update_user_meta($user_id, 'login_attempts', 0);
	}

	public function update_user_pass() {
		$nonce = filter_input(INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING);
		$verify_nonce = (bool) wp_verify_nonce($nonce, 'update_user_pass');

		// Verificar si el _wpnonce es valido
		if (!$verify_nonce) {
			$this->error->method_rejected(__FUNCTION__);
			wp_send_json_error($this->error);
		}

		if (!is_user_logged_in()) {
			$this->error->user_not_logged(__FUNCTION__);
			wp_send_json_error($this->error);
		}

		$current_pass = filter_input(INPUT_POST, 'current_pass');
		$user_id = get_current_user_id();
		$current_user = get_user_by('id', $user_id);

		$valid_pass = wp_check_password($current_pass, $current_user->get('user_pass'), $user_id);

		if (!$valid_pass) {
			$this->error->add('invalid_pass', 'Contraseña actual inválida');
			wp_send_json_error($this->error);
		}

		$new_pass = filter_input(INPUT_POST, 'new_user_pass');

		if (empty($new_pass)) {
			$this->error->add('invalid_pass', 'Nueva contraseña inválida');
			wp_send_json_error($this->error);
		}

		wp_set_password($new_pass, $user_id);

		$data[] = array(
				'code' => 'success_update',
				'message' => 'Contraseña actualizada exitosamente'
		);
		wp_send_json_success($data);
	}

}

$User_Actions = new User_Actions();
add_action('wp_ajax_nopriv_user_signon', array($User_Actions, 'user_signon'));

add_action('wp_ajax_update_user_pass', array($User_Actions, 'update_user_pass'));

add_action('wp_ajax_nopriv_update_user_pass', function() {
	$error = new WP_Error('is_user_registered', 'Debes iniciar sesion');
	wp_send_json_error($error);
});

add_action('wp_ajax_user_signon', function() {
	$error = new WP_Error('is_user_registered', 'Ya estas registrado');
	wp_send_json_error($error);
});

add_action('wp_ajax_user_register', function() {
	$error = new WP_Error('is_user_logged_in', 'Ya has iniciado sesion');
	wp_send_json_error($error);
});
