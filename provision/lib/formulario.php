<?php
/**
 * Formulario de presupuesto con Contact Form 7 (Elementor Free no trae widget de formulario).
 *
 * mv_formulario( $T ) crea o actualiza el formulario de un idioma y devuelve su id. Los campos son los de
 * SPEC.md sección 4.3. El captcha es Cloudflare Turnstile (lo verifica CF7 en el servidor) y los envíos se
 * guardan además en Flamingo.
 *
 * La validación del tipo real de las imágenes y el límite de envíos por IP están en el tema (functions.php),
 * porque tienen que funcionar también en producción, donde este directorio no se despliega.
 */

/** Guarda las claves de Turnstile en CF7. Por defecto, las claves de prueba de Cloudflare (siempre aprueban). */
function mv_turnstile(): void {
	$sitekey = getenv( 'TURNSTILE_SITEKEY' ) ?: '1x00000000000000000000AA';
	$secret  = getenv( 'TURNSTILE_SECRET' ) ?: '1x0000000000000000000000000000000AA';
	WPCF7::update_option( 'turnstile', [ $sitekey => $secret ] );
}

function mv_formulario( array $T ): int {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		WP_CLI::warning( 'Contact Form 7 no está activo: el formulario no se creará.' );
		return 0;
	}

	$F      = $T['form'];
	$idioma = $T['idioma'];
	$e      = 'esc_html';

	$opciones = fn( array $lista ) => implode( ' ', array_map( fn( $o ) => '"' . $o . '"', $lista ) );

	$fotos = '';
	foreach ( [ 1, 2, 3 ] as $n ) {
		$fotos .= '<div class="campo campo--foto"><label for="mv-foto' . $n . '">' . $e( sprintf( $F['foto_n'], $n ) ) . '</label>'
			. '[file foto' . $n . ' id:mv-foto' . $n . ' limit:5mb filetypes:jpg|jpeg|png|webp]</div>';
	}

	$plantilla = <<<HTML
<fieldset class="grupo">
<legend>{$e( $F['legend_trabajo'] )}</legend>
<div class="campo">
<label for="mv-titulo">{$e( $F['titulo'] )} <small>{$e( $F['titulo_ayuda'] )}</small></label>
[text* titulo id:mv-titulo maxlength:120]
</div>
<div class="campo campo--medio">
<label for="mv-tipo">{$e( $F['tipo'] )}</label>
[select* tipo id:mv-tipo first_as_label "{$F['elige']}" {$opciones( $F['tipos'] )}]
</div>
<div class="campo campo--medio">
<label for="mv-municipio">{$e( $F['municipio'] )}</label>
[select* municipio id:mv-municipio first_as_label "{$F['elige']}" {$opciones( MV_MUNICIPIOS )}]
</div>
<div class="campo campo--medio">
<label for="mv-materiales">{$e( $F['materiales'] )}</label>
[select* materiales id:mv-materiales first_as_label "{$F['elige']}" {$opciones( $F['si_no'] )}]
</div>
<div class="campo">
<label for="mv-descripcion">{$e( $F['descripcion'] )}</label>
[textarea* descripcion id:mv-descripcion x5 maxlength:2000 placeholder "{$F['descripcion_ayuda']}"]
</div>
<div class="campo campo--fotos">
<p class="campo__titulo">{$e( $F['fotos'] )} <small>{$e( $F['opcional'] )}</small></p>
<p class="campo__ayuda">{$e( $F['fotos_ayuda'] )} {$e( $F['fotos_limite'] )}</p>
<div class="fotos">{$fotos}</div>
</div>
</fieldset>

<fieldset class="grupo">
<legend>{$e( $F['legend_datos'] )}</legend>
<div class="campo campo--medio">
<label for="mv-nombre">{$e( $F['nombre'] )}</label>
[text* nombre id:mv-nombre autocomplete:name maxlength:80]
</div>
<div class="campo campo--medio">
<label for="mv-telefono">{$e( $F['telefono'] )}</label>
[tel* telefono id:mv-telefono autocomplete:tel maxlength:20]
</div>
<div class="campo">
<label for="mv-correo">{$e( $F['correo'] )} <small>{$e( $F['opcional'] )}</small></label>
[email correo id:mv-correo autocomplete:email maxlength:120]
</div>
</fieldset>

<div class="consentimiento">
[acceptance privacidad] {$F['privacidad']} [/acceptance]
</div>

[turnstile size:flexible theme:light language:{$idioma}]

[submit "{$F['enviar']}"]
HTML;

	$dominio = wp_parse_url( home_url(), PHP_URL_HOST ) ?: 'localhost';
	if ( false === strpos( $dominio, '.' ) || filter_var( $dominio, FILTER_VALIDATE_IP ) ) {
		$dominio = 'manitasvalles.local'; // «localhost» o una IP: no valen como dominio de remitente
	}
	$cuerpo = "Nueva solicitud de presupuesto desde la web ({$idioma}).\n\n"
		. "Título: [titulo]\nTipo de tarea: [tipo]\nMunicipio: [municipio]\nEl cliente aporta los materiales: [materiales]\n\n"
		. "Descripción:\n[descripcion]\n\n"
		. "Nombre: [nombre]\nTeléfono: [telefono]\nCorreo: [correo]\n\n"
		. "Política de privacidad aceptada: [privacidad]\n\n"
		. "--\nEnviado desde [_site_url] el [_date] a las [_time].";

	$nombre_form = 'Solicitud de presupuesto (' . $idioma . ')';
	$existentes  = get_posts( [ 'post_type' => 'wpcf7_contact_form', 'title' => $nombre_form, 'numberposts' => 1, 'post_status' => 'any' ] );
	$form        = $existentes
		? WPCF7_ContactForm::get_instance( $existentes[0]->ID )
		: WPCF7_ContactForm::get_template( [ 'title' => $nombre_form ] );

	$propiedades           = $form->get_properties();
	$propiedades['form']   = $plantilla;
	$propiedades['mail']   = [
		'active'             => true,
		'subject'            => 'Presupuesto: [tipo] en [municipio] · [titulo]',
		'sender'             => "[_site_title] <wordpress@{$dominio}>",
		'recipient'          => MV_TITULAR['correo'], // en local lo intercepta Mailpit
		'body'               => $cuerpo,
		'additional_headers' => '',
		'attachments'        => "[foto1]\n[foto2]\n[foto3]",
		'use_html'           => false,
		'exclude_blank'      => true,
	];
	$propiedades['mail_2']   = [ 'active' => false ] + ( $propiedades['mail_2'] ?? [] );
	$propiedades['messages'] = $F['mensajes'] + ( $propiedades['messages'] ?? [] );
	// El consentimiento no deshabilita el botón: al pulsar sin marcarlo se muestra el error junto a la casilla.
	$propiedades['additional_settings'] = "acceptance_as_validation: on\n"
		. "flamingo_name: \"[nombre]\"\nflamingo_email: \"[correo]\"\nflamingo_subject: \"[titulo]\"";

	$form->set_properties( $propiedades );
	$form->set_locale( 'ca' === $idioma ? 'ca' : 'es_ES' );
	$form->save();

	return $form->id();
}

/** Borra el formulario de ejemplo que crea CF7 al activarse. */
function mv_formulario_limpiar(): void {
	foreach ( [ 'Formulario de contacto 1', 'Contact form 1' ] as $titulo ) {
		foreach ( get_posts( [ 'post_type' => 'wpcf7_contact_form', 'title' => $titulo, 'numberposts' => -1, 'post_status' => 'any' ] ) as $p ) {
			wp_delete_post( $p->ID, true );
		}
	}
}
