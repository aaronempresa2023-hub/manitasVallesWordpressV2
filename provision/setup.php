<?php
/**
 * Construye Manitas Vallés en WordPress + Elementor Free. Se ejecuta con `wp eval-file` y es idempotente:
 * puede relanzarse tras cambiar provision/lib/*.php y reescribe las páginas (los cambios hechos a mano en
 * Elementor sobre ellas se pierden; duplica la página antes si quieres conservar una variante).
 *
 * Qué hace, en orden:
 *  1. Ajustes generales del sitio.
 *  2. Configura el Kit de Elementor: paleta, tipografía, contenedor.
 *  3. Crea los formularios de Contact Form 7 (uno por idioma) con Turnstile.
 *  4. Crea/actualiza las páginas en castellano y catalán: inicio, pedir presupuesto y las tres legales.
 */

use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/lib/helpers.php';
require_once __DIR__ . '/lib/precios.php';
require_once __DIR__ . '/lib/textos.php';
require_once __DIR__ . '/lib/home.php';
require_once __DIR__ . '/lib/formulario.php';
require_once __DIR__ . '/lib/legales.php';

function mv_log( string $mensaje ): void {
	if ( class_exists( 'WP_CLI' ) ) {
		WP_CLI::log( '  · ' . $mensaje );
	}
}

// ------------------------------------------------------------------------------------------------
// 1 · Ajustes generales
// ------------------------------------------------------------------------------------------------
update_option( 'blogname', 'Manitas Vallés' );
update_option( 'blogdescription', 'Reparaciones del hogar en el Vallès Occidental' );
update_option( 'timezone_string', 'Europe/Madrid' );
update_option( 'date_format', 'j \d\e F \d\e Y' );
update_option( 'time_format', 'H:i' );
update_option( 'start_of_week', 1 );
update_option( 'default_comment_status', 'closed' );
update_option( 'default_ping_status', 'closed' );

// Contenido de ejemplo que trae WordPress.
foreach ( [ 1, 2, 3 ] as $id_ejemplo ) {
	$p = get_post( $id_ejemplo );
	if ( $p && in_array( $p->post_name, [ 'hello-world', 'hola-mundo', 'sample-page', 'pagina-de-ejemplo', 'privacy-policy', 'politica-privacidad' ], true ) ) {
		wp_delete_post( $id_ejemplo, true );
	}
}

// La tipografía es local (ver el tema): que Elementor no cargue Google Fonts.
update_option( 'elementor_google_font', '0' );

// ------------------------------------------------------------------------------------------------
// 2 · Kit de Elementor (ajustes globales)
// ------------------------------------------------------------------------------------------------
mv_log( 'Configurando el Kit de Elementor (paleta, tipografía)…' );

$colores_sistema = [];
$colores_custom  = [];
foreach ( MV_COLORS as $clave => [ $id, $hex, $titulo ] ) {
	if ( in_array( $id, [ 'primary', 'secondary', 'text', 'accent' ], true ) ) {
		$colores_sistema[] = [ '_id' => $id, 'title' => $titulo, 'color' => $hex ];
	} else {
		$colores_custom[] = [ '_id' => $id, 'title' => $titulo, 'color' => $hex ];
	}
}

$kit = Plugin::$instance->kits_manager->get_active_kit();
$kit->save( [ 'settings' => [
	'container_width'       => mv_size( 1240 ),
	'container_padding'     => mv_dim( 0 ),
	'space_between_widgets' => [ 'column' => '0', 'row' => '0', 'isLinked' => true, 'unit' => 'px', 'size' => 0 ],
	'system_colors'         => $colores_sistema,
	'custom_colors'         => $colores_custom,
	'system_typography'     => [
		[ '_id' => 'primary', 'title' => 'Titular', 'typography_typography' => 'custom', 'typography_font_family' => MV_ROTULO, 'typography_font_weight' => '700' ],
		[ '_id' => 'secondary', 'title' => 'Botón', 'typography_typography' => 'custom', 'typography_font_family' => MV_TEXTO, 'typography_font_weight' => '600' ],
		[ '_id' => 'text', 'title' => 'Texto', 'typography_typography' => 'custom', 'typography_font_family' => MV_TEXTO, 'typography_font_weight' => '400' ],
		[ '_id' => 'accent', 'title' => 'Texto en negrita', 'typography_typography' => 'custom', 'typography_font_family' => MV_TEXTO, 'typography_font_weight' => '600' ],
	],
	'default_generic_fonts'       => 'system-ui, sans-serif',
	'body_background_background'  => 'classic',
	'body_background_color'       => '#FFFFFF',
	'body_typography_typography'  => 'custom',
	'body_typography_font_family' => MV_TEXTO,
	'body_typography_font_weight' => '400',
	'body_typography_font_size'   => mv_size( '1.0625rem' ),
	'body_typography_line_height' => [ 'unit' => 'custom', 'size' => '1.5', 'sizes' => [] ],
] ] );

// ------------------------------------------------------------------------------------------------
// 3 · Páginas
// ------------------------------------------------------------------------------------------------
/**
 * Crea o actualiza una página de Elementor. $clave identifica la página entre ejecuciones (opción mv_page_<clave>).
 * El idioma se guarda en el meta _mv_lang; el tema lo usa para el atributo lang, los hreflang y las metas SEO.
 */
function mv_pagina( string $clave, string $titulo, string $slug, int $padre, string $idioma, array $elementos ): int {
	$id = (int) get_option( "mv_page_{$clave}" );
	if ( $id && get_post( $id ) ) {
		$doc = Plugin::$instance->documents->get( $id );
	} else {
		$doc = Plugin::$instance->documents->create( 'wp-page', [
			'post_title'  => $titulo,
			'post_name'   => $slug,
			'post_status' => 'publish',
			'post_type'   => 'page',
			'post_parent' => $padre,
		] );
		update_option( "mv_page_{$clave}", $doc->get_main_id() );
	}
	$id = $doc->get_main_id();

	$doc->save( [
		'elements' => $elementos,
		'settings' => [
			'post_title' => $titulo,
			'template'   => 'elementor_canvas', // Cabecera y pie van dentro de la página: Elementor Free no trae Theme Builder.
		],
	] );
	wp_update_post( [ 'ID' => $id, 'post_status' => 'publish', 'post_name' => $slug, 'post_title' => $titulo, 'post_parent' => $padre ] );
	update_post_meta( $id, '_mv_lang', $idioma );
	update_post_meta( $id, '_mv_page', $clave );

	mv_log( "Página «{$titulo}» ({$idioma}) lista (ID {$id})." );
	return $id;
}

$es = mv_textos( 'es' );
$ca = mv_textos( 'ca' );

mv_log( 'Creando los formularios de Contact Form 7 (castellano y catalán)…' );
mv_turnstile();
mv_formulario_limpiar();
$form_es = mv_formulario( $es );
$form_ca = mv_formulario( $ca );

mv_log( 'Construyendo las páginas con Elementor…' );

$id_inicio      = mv_pagina( 'inicio_es', 'Inicio', 'inicio', 0, 'es', mv_home( $es ) );
$id_presupuesto = mv_pagina( 'presupuesto_es', 'Pedir presupuesto', 'presupuesto', 0, 'es', mv_presupuesto( $es, $form_es ) );
$id_inici       = mv_pagina( 'inicio_ca', 'Inici', 'ca', 0, 'ca', mv_home( $ca ) );
$id_pressupost  = mv_pagina( 'presupuesto_ca', 'Demanar pressupost', 'pressupost', $id_inici, 'ca', mv_presupuesto( $ca, $form_ca ) );

// Páginas legales: tres por idioma. Las catalanas cuelgan de /ca/.
$ids_legales = [];
foreach ( [ 'es' => [ $es, 0 ], 'ca' => [ $ca, $id_inici ] ] as $idioma => [ $T, $padre ] ) {
	$contenido = mv_legales_contenido( $idioma );
	foreach ( mv_legales_rutas( $idioma ) as $clave => [ $titulo, $slug ] ) {
		$ids_legales[ $idioma ][ $clave ] = mv_pagina( "{$clave}_{$idioma}", $titulo, $slug, $padre, $idioma, mv_legal( $T, $titulo, $contenido[ $clave ] ) );
	}
}
foreach ( [ 'es' => 'ca', 'ca' => 'es' ] as $idioma => $otro ) {
	foreach ( $ids_legales[ $idioma ] as $clave => $id ) {
		update_post_meta( $id, '_mv_alt', $ids_legales[ $otro ][ $clave ] );
		update_post_meta( $id, '_mv_seo_title', get_the_title( $id ) . ' · Manitas Vallés' );
		update_post_meta( $id, '_mv_skip', 'es' === $idioma ? $es['saltar'] : $ca['saltar'] );
	}
}
// El tema enlaza la política de cookies desde el aviso.
update_option( 'mv_cookies_page', [ 'es' => $ids_legales['es']['cookies'], 'ca' => $ids_legales['ca']['cookies'] ] );

// Metas SEO y página equivalente en el otro idioma (el tema las lee para <title>, description y hreflang).
foreach ( [
	[ $id_inicio, $id_inici, $es['seo_titulo'], $es['seo_descripcion'] ],
	[ $id_inici, $id_inicio, $ca['seo_titulo'], $ca['seo_descripcion'] ],
	[ $id_presupuesto, $id_pressupost, $es['seo_presupuesto'], $es['presupuesto_texto'] ],
	[ $id_pressupost, $id_presupuesto, $ca['seo_presupuesto'], $ca['presupuesto_texto'] ],
] as [ $id, $equivalente, $titulo, $descripcion ] ) {
	update_post_meta( $id, '_mv_alt', $equivalente );
	update_post_meta( $id, '_mv_seo_title', $titulo );
	update_post_meta( $id, '_mv_seo_description', $descripcion );
	update_post_meta( $id, '_mv_skip', 'es' === get_post_meta( $id, '_mv_lang', true ) ? $es['saltar'] : $ca['saltar'] );
}

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $id_inicio );

Plugin::$instance->files_manager->clear_cache();
