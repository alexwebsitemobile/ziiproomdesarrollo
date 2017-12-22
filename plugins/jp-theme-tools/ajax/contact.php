<?php

if (!function_exists('send_contact_form')) {

	/**
	 * @ignore
	 * @global array $submit
	 * @return boolean
	 */
	function send_contact_form()
	{
		global $submit;
		$address = get_option('contact-form-email');

		if (empty($address)) die('0');

		if ($_SERVER["REQUEST_METHOD"] == 'POST') {
			$submit = wp_parse_args($_POST);
		} else {
			$submit = wp_parse_args($_SERVER["QUERY_STRING"]);
		}

		if (!wp_verify_nonce($submit['_wpnonce'], 'send_contact_form')) return FALSE;

		ob_start();
		jptt_get_template('email/contact-email.php');
		$content = ob_get_clean();

		require_once ABSPATH . WPINC . '/class-phpmailer.php';
		$mail = new PHPMailer();

		$mail->AddAddress($address);
		$mail->From = 'noreply@' . $_SERVER['SERVER_NAME'];
		$mail->FromName = 'Contacto WEB';
		$mail->Subject = 'Contacto WEB ' . date("d/m/Y h:i");
		$mail->Body = $content;
		$mail->IsHTML();
		$mail->CharSet = 'utf-8';

		$result = $mail->Send();
		die((string) ((int) $result));
	}

	add_action('wp_ajax_send_contact_form', 'send_contact_form');
	add_action('wp_ajax_nopriv_send_contact_form', 'send_contact_form');
}