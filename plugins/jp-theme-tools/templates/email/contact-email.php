<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<title>Contacto WEB</title>
	</head>
	<body>

		<div style="color:#444; max-width: 600px; border: 1px solid #cccccc; padding: 15px; box-shadow: 0 0 2px #999999; margin: auto; font-family:Open-sans, sans-serif;">
			<h2 style="margin-bottom: 2px; margin-top: 2px;"><?php _e( 'Web Contact') ?></h2>
			<p style="margin-top: 2px; margin-bottom: 2px">Enviado el <?php echo date( "d/m/Y h:i" ) ?></p>
			<hr style="border: solid 2px #444">
			<div style="border: solid 1px #cccccc; background-color: #eeeeee; padding: 15px; margin-top: 15px;">
				<?php
				global $contact_fields, $submit;
				if ( empty( $contact_fields ) ) {
					$contact_fields = array(
						'contact-name' => 'Nombres',
						'contact-email' => 'Email',
						'contact-comments' => 'Comentarios'
					);
				}
				foreach ( $contact_fields as $key => $field ) {
					$field_value = apply_filters( 'mailto', $submit[$key] );
					printf( '<p style="margin: 5px 0;"><strong>%s</strong>: %s</p>', $field, $field_value );
				}
				?>
			</div>
		</div>

	</body>
</html>