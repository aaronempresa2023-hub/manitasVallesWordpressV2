<?php
/**
 * Plugin Name: Correo de desarrollo (Mailpit)
 * Description: Solo para el entorno Docker local. Envía el correo de WordPress al contenedor Mailpit.
 *              No se despliega a producción: vive en dev/, no en el tema.
 */

if ( ! defined( 'MANITAS_SMTP_HOST' ) ) {
	return;
}

add_action(
	'phpmailer_init',
	function ( $phpmailer ) {
		$phpmailer->isSMTP();
		$phpmailer->Host       = MANITAS_SMTP_HOST;
		$phpmailer->Port       = defined( 'MANITAS_SMTP_PORT' ) ? MANITAS_SMTP_PORT : 1025;
		$phpmailer->SMTPAuth   = false;
		$phpmailer->SMTPSecure = '';
		$phpmailer->SMTPAutoTLS = false;
	}
);

// En local el sitio es «localhost» o una IP, y PHPMailer no acepta esos dominios como remitente.
add_filter(
	'wp_mail_from',
	function ( $correo ) {
		$dominio = substr( (string) strrchr( (string) $correo, '@' ), 1 );
		return ( false === strpos( $dominio, '.' ) || filter_var( $dominio, FILTER_VALIDATE_IP ) ) ? 'wordpress@manitasvalles.local' : $correo;
	}
);
