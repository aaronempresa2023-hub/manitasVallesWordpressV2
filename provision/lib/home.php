<?php
/**
 * Páginas de Manitas Vallés, construidas solo con contenedores y widgets de Elementor Free.
 *
 * mv_home( $T ) y mv_presupuesto( $T ) devuelven la lista de contenedores raíz. $T es el mapa de textos
 * de un idioma (ver textos.php).
 *
 * Lo que Elementor Free no permite (las marcas de la cinta, las cifras condensadas, la palabra enorme,
 * los estados al pasar el ratón…) lo aporta el tema con las clases CSS que llevan los elementos.
 */

const MV_GUTTER   = 'clamp(16px, 4vw, 40px)';
const MV_VERTICAL = 'clamp(56px, 9vw, 112px)';
const MV_RADIO    = 28;

/** Sección a ancho completo con contenido centrado a 1240 px y el margen lateral fluido. */
function mv_seccion( array $ajustes, array $hijos ): array {
	$ajustes += [
		'html_tag'       => 'section',
		'content_width'  => 'boxed',
		'boxed_width'    => mv_size( 1240 ),
		'flex_direction' => 'column',
		'flex_gap'       => mv_gap( 0 ),
		'padding'        => mv_dim( MV_VERTICAL, MV_GUTTER, 0, MV_GUTTER ),
	];
	return mv_box( $ajustes, $hijos, true );
}

/** Título de sección (h2). */
function mv_h2( string $texto, string $color = 'tinta', array $extra = [] ): array {
	return mv_heading( $texto, [
		'tag'    => 'h2',
		'color'  => $color,
		'tam'    => 'clamp(2.25rem, 6vw, 4rem)',
		'margen' => mv_dim( 0, 0, 'clamp(24px, 4vw, 40px)', 0 ),
	] + $extra );
}

/** SVG del logotipo de Manitas Vallés (inline, aria-hidden: el enlace lleva el nombre en aria-label). */
function mv_logo_svg(): string {
	return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 76" fill="none" aria-hidden="true" focusable="false">'
		. '<g transform="translate(6,6)">'
		. '<path d="M32 0L60 16V48L32 64L4 48V16L32 0Z" fill="#121212"/>'
		. '<path d="M32 0L60 16V48L32 64L32 32L60 16Z" fill="#ccff00" fill-opacity="0.2"/>'
		. '<path d="M32 6L54 18.5V45.5L32 58L10 45.5V18.5L32 6Z" stroke="#ccff00" stroke-width="2.5" stroke-linejoin="round"/>'
		. '<path d="M21 23L32 41L43 23" stroke="#f8fafc" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>'
		. '<circle cx="32" cy="20" r="3" fill="#ccff00"/>'
		. '<path d="M26 38L32 47L38 38" stroke="#ccff00" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>'
		. '<circle cx="32" cy="33" r="1.5" fill="#ccff00"/>'
		. '</g>'
		. '<text x="82" y="38" font-family="\'Bricolage Grotesque\',system-ui,sans-serif" font-size="26" font-weight="800" fill="#121212" letter-spacing="-0.5">MANITAS<tspan fill="#ccff00">.</tspan></text>'
		. '<text x="204" y="38" font-family="\'Bricolage Grotesque\',system-ui,sans-serif" font-size="26" font-weight="400" fill="#5e5e5e" letter-spacing="-0.5">VALLÉS</text>'
		. '<text x="83" y="55" font-family="\'Bricolage Grotesque\',system-ui,sans-serif" font-size="9.5" font-weight="700" fill="#5e5e5e" letter-spacing="2.4">PROFESIONALES DEL HOGAR</text>'
		. '</svg>';
}

/** Cabecera: nombre, navegación (escritorio), cambio de idioma y botón. */
function mv_cabecera( array $T ): array {
	$enlaces = '';
	foreach ( $T['nav'] as [ $texto, $ancla ] ) {
		$enlaces .= '<a href="' . esc_url( $T['inicio'] . $ancla ) . '">' . esc_html( $texto ) . '</a>';
	}
	[ $otro, $otro_url, $otro_titulo ] = $T['otro_idioma'];

	return mv_box( [
		'html_tag'              => 'header',
		'css_classes'           => 'cabecera',
		'content_width'         => 'boxed',
		'boxed_width'           => mv_size( 1240 ),
		'flex_direction'        => 'row',
		'flex_direction_mobile' => 'row',
		'flex_align_items'      => 'center',
		'flex_justify_content'  => 'space-between',
		'flex_gap'              => mv_gap( 20 ),
		'padding'               => mv_dim( 18, MV_GUTTER ),
	], [
		mv_text( '<a class="marca" href="' . esc_url( $T['inicio'] ) . '" aria-label="Manitas Vallés">' . mv_logo_svg() . '</a>', [ 'clase' => 'cabecera__marca', 'fijo' => true ] ),
		mv_text( '<nav class="menu" aria-label="' . esc_attr( 'es' === $T['idioma'] ? 'Secciones' : 'Seccions' ) . '">' . $enlaces . '</nav>', [ 'clase' => 'cabecera__menu', 'ocultar_mobile' => true, 'ocultar_tablet' => true ] ),
		mv_box( [
			'flex_direction'        => 'row',
			'flex_direction_mobile' => 'row',
			'flex_align_items'      => 'center',
			'flex_gap'              => mv_gap( 18 ),
			'width'                 => mv_size( 'auto' ),
			'width_mobile'          => mv_size( 'auto' ),
		], [
			mv_text(
				'<span class="idiomas"><span aria-current="true">' . esc_html( $T['este_idioma'] ) . '</span><a href="' . esc_url( $otro_url ) . '" hreflang="' . esc_attr( strtolower( $otro ) ) . '" lang="' . esc_attr( strtolower( $otro ) ) . '" title="' . esc_attr( $otro_titulo ) . '">' . esc_html( $otro ) . '</a></span>',
				[ 'clase' => 'cabecera__idiomas', 'fijo' => true ]
			),
			mv_button( $T['cta'], $T['presupuesto'], 'negro', [ 'ocultar_mobile' => true, 'tam' => '1rem', 'relleno' => mv_dim( 13, 22 ), 'fijo' => true ] ),
		] ),
	], true );
}

/** Portada: bloque negro con el titular y, pegada debajo, la cinta con tres precios como lecturas. */
function mv_portada( array $T ): array {
	$lecturas = [];
	foreach ( $T['lecturas'] as [ $precio, $trabajo ] ) {
		$lecturas[] = mv_text(
			'<p class="lectura"><span class="cifra">' . esc_html( $precio ) . '</span><span class="lectura__trabajo">' . esc_html( $trabajo ) . '</span></p>',
			[ 'clase' => 'cinta__lectura' ]
		);
	}

	return mv_box( [
		'html_tag'       => 'section',
		'css_classes'    => 'portada',
		'content_width'  => 'boxed',
		'boxed_width'    => mv_size( 1240 ),
		'flex_direction' => 'column',
		'flex_gap'       => mv_gap( 0 ),
		'padding'        => mv_dim( 0, MV_GUTTER ),
	], [
		mv_box( [
			'css_classes'           => 'portada__bloque sobre-negro',
			'background_background' => 'classic',
			'background_color'      => mv_c( 'negro' ),
			'border_radius'         => mv_dim( MV_RADIO, MV_RADIO, 0, 0 ),
			'flex_direction'        => 'column',
			'flex_gap'              => mv_gap( 0 ),
			'padding'               => mv_dim( 'clamp(32px, 6vw, 80px)', 'clamp(22px, 5vw, 72px)', 'clamp(30px, 5vw, 64px)', 'clamp(22px, 5vw, 72px)' ),
		], [
			mv_heading( $T['h1'], [
				'tag'          => 'h1',
				'color'        => 'blanco',
				'peso'         => 600,
				'tam'          => 'clamp(2rem, 5.2vw, 4.25rem)',
				'interlineado' => 1.02,
				'clase'        => 'portada__titular',
			] ),
			mv_text( '<p>' . esc_html( $T['hero_texto'] ) . '</p>', [
				'color'  => 'sobre-negro',
				'tam'    => [ 'd' => '1.1875rem', 'm' => '1.0625rem' ],
				'clase'  => 'portada__texto',
				'margen' => mv_dim( 'clamp(18px, 2.4vw, 28px)', 0, 'clamp(22px, 3vw, 36px)', 0 ),
			] ),
			mv_box( [
				'flex_direction'        => 'row',
				'flex_direction_mobile' => 'row',
				'flex_wrap'             => 'wrap',
				'flex_align_items'      => 'center',
				'flex_gap'              => mv_gap( 8, 26 ),
			], [
				mv_button( $T['cta'], $T['presupuesto'], 'lima', [ 'fijo' => true, 'tam' => '1.125rem', 'relleno' => mv_dim( 18, 30 ) ] ),
				mv_button( $T['hero_enlace'], '#precios', 'enlace', [ 'color' => 'blanco', 'fijo' => true ] ),
			] ),
		] ),
		mv_box( [
			'css_classes'           => 'cinta cinta--portada',
			'background_background' => 'classic',
			'background_color'      => mv_c( 'lima' ),
			'border_radius'         => mv_dim( 0, 0, MV_RADIO, MV_RADIO ),
			'padding'               => mv_dim( 44, 'clamp(22px, 5vw, 72px)', 'clamp(20px, 3vw, 30px)', 'clamp(22px, 5vw, 72px)' ),
		] + mv_grid( [ 'd' => 'repeat(3, minmax(0, 1fr))', 't' => 'repeat(3, minmax(0, 1fr))', 'm' => 'repeat(3, minmax(0, 1fr))' ], [ 'd' => [ 0, 40 ], 'm' => [ 0, 10 ] ] ), $lecturas ),
	], true );
}

/** Servicios: cuatro bloques de distinto peso; cada uno acaba en una lectura de precio. */
function mv_servicios( array $T ): array {
	$fondos = [ 'fontaneria' => 'superficie', 'electricidad' => 'lima', 'montaje' => 'negro', 'reparaciones' => 'superficie' ];
	$bloques = [];
	foreach ( $T['servicios'] as [ $slug, $nombre, $tareas, $etiqueta, $precio ] ) {
		$oscuro    = 'negro' === $fondos[ $slug ];
		$bloques[] = mv_box( [
			'css_classes'           => "servicio servicio--{$slug}" . ( $oscuro ? ' sobre-negro' : '' ),
			'background_background' => 'classic',
			'background_color'      => mv_c( $fondos[ $slug ] ),
			'border_radius'         => mv_dim( MV_RADIO ),
			'flex_direction'        => 'column',
			'flex_justify_content'  => 'space-between',
			'flex_gap'              => mv_gap( 28 ),
			'padding'               => mv_dim( 'clamp(24px, 3vw, 36px)' ),
		], [
			mv_box( [ 'flex_direction' => 'column', 'flex_gap' => mv_gap( 10 ) ], [
				mv_heading( $nombre, [ 'tag' => 'h3', 'color' => $oscuro ? 'blanco' : 'tinta', 'peso' => 600, 'tam' => 'clamp(1.625rem, 3vw, 2.25rem)', 'interlineado' => 1.05 ] ),
				mv_text( '<p>' . esc_html( $tareas ) . '</p>', [ 'color' => $oscuro ? 'sobre-negro' : 'tinta', 'tam' => '1.0625rem', 'clase' => 'servicio__tareas' ] ),
			] ),
			mv_text(
				'<p class="lectura lectura--linea"><span class="lectura__trabajo">' . esc_html( $etiqueta ) . '</span><span class="cifra">' . esc_html( $precio ) . '</span></p>',
				[ 'color' => $oscuro ? 'blanco' : 'tinta', 'clase' => 'servicio__precio' ]
			),
		] );
	}

	return mv_seccion( [ '_element_id' => 'servicios', 'css_classes' => 'servicios' ], [
		mv_h2( $T['servicios_h2'] ),
		mv_box( [ 'css_classes' => 'servicios__rejilla' ] + mv_grid(
			[ 'd' => 'repeat(12, minmax(0, 1fr))', 't' => 'repeat(2, minmax(0, 1fr))', 'm' => 'minmax(0, 1fr)' ],
			[ 'd' => [ 16, 16 ], 'm' => [ 12, 12 ] ]
		), $bloques ),
	] );
}

/** Una tabla de precios como HTML semántico dentro de un widget de texto (Elementor Free no trae tabla). */
function mv_tabla( string $grupo, array $filas, array $T ): array {
	$html  = '<table class="precios"><caption>' . esc_html( $grupo ) . '</caption>';
	$html .= '<thead><tr><th scope="col">' . esc_html( $T['col_trabajo'] ) . '</th><th scope="col">' . esc_html( $T['col_precio'] ) . '</th></tr></thead><tbody>';
	foreach ( $filas as [ $trabajo, $nota, $precio ] ) {
		$html .= '<tr><th scope="row">' . esc_html( $trabajo ) . ( $nota ? '<small>' . esc_html( $nota ) . '</small>' : '' ) . '</th>';
		$html .= '<td class="cifra">' . esc_html( $precio ) . '</td></tr>';
	}
	$html .= '</tbody></table>';
	return mv_text( $html, [ 'clase' => 'precios__grupo' ] );
}

function mv_precios( array $T ): array {
	$tablas = [];
	foreach ( $T['tablas'] as $grupo => $filas ) {
		$tablas[] = mv_tabla( $grupo, $filas, $T );
	}

	return mv_seccion( [ '_element_id' => 'precios', 'css_classes' => 'seccion-precios' ], [
		mv_h2( $T['precios_h2'], 'tinta', [ 'margen' => mv_dim( 0, 0, 12, 0 ) ] ),
		mv_text( '<p>' . esc_html( $T['precios_intro'] ) . '</p>', [ 'color' => 'gris', 'tam' => '1.125rem', 'clase' => 'medida', 'margen' => mv_dim( 0, 0, 'clamp(28px, 4vw, 48px)', 0 ) ] ),
		mv_box( [ 'flex_direction' => 'column', 'flex_gap' => mv_gap( 0 ), 'css_classes' => 'precios__lista' ], $tablas ),
	] );
}

/** Cómo trabajamos: tres pasos como marcas numeradas sobre la cinta (el orden sí es información). */
function mv_como( array $T ): array {
	$pasos = '<ol class="pasos">';
	foreach ( $T['pasos'] as [ $titulo, $detalle ] ) {
		$pasos .= '<li><h3>' . esc_html( $titulo ) . '</h3><p>' . esc_html( $detalle ) . '</p></li>';
	}
	$pasos .= '</ol>';

	return mv_seccion( [ '_element_id' => 'como', 'css_classes' => 'como' ], [
		mv_h2( $T['como_h2'] ),
		mv_box( [
			'css_classes'           => 'cinta cinta--pasos',
			'background_background' => 'classic',
			'background_color'      => mv_c( 'lima' ),
			'border_radius'         => mv_dim( MV_RADIO ),
			'padding'               => mv_dim( 52, 'clamp(22px, 4vw, 48px)', 'clamp(24px, 4vw, 40px)', 'clamp(22px, 4vw, 48px)' ),
		], [
			mv_text( $pasos, [ 'clase' => 'como__pasos' ] ),
		] ),
	] );
}

/** Dónde trabajamos: la lista de municipios. */
function mv_zona( array $T ): array {
	$lista = '<ul class="municipios">';
	foreach ( MV_MUNICIPIOS as $municipio ) {
		$lista .= '<li lang="ca">' . esc_html( $municipio ) . '</li>';
	}
	$lista .= '</ul>';

	return mv_seccion( [ '_element_id' => 'zona', 'css_classes' => 'zona' ], [
		mv_h2( $T['zona_h2'], 'tinta', [ 'margen' => mv_dim( 0, 0, 12, 0 ) ] ),
		mv_text( '<p>' . esc_html( $T['zona_texto'] ) . '</p>', [ 'color' => 'gris', 'tam' => '1.125rem', 'margen' => mv_dim( 0, 0, 'clamp(20px, 3vw, 32px)', 0 ) ] ),
		mv_text( $lista, [ 'clase' => 'zona__lista' ] ),
	] );
}

/** Segundo CTA: bloque negro con la pregunta y el botón. */
function mv_cierre( array $T ): array {
	return mv_seccion( [ 'css_classes' => 'cierre' ], [
		mv_box( [
			'css_classes'           => 'cierre__bloque sobre-negro',
			'background_background' => 'classic',
			'background_color'      => mv_c( 'negro' ),
			'border_radius'         => mv_dim( MV_RADIO ),
			'flex_direction'        => 'column',
			'flex_align_items'      => 'flex-start',
			'flex_gap'              => mv_gap( 0 ),
			'padding'               => mv_dim( 'clamp(36px, 7vw, 96px)', 'clamp(22px, 5vw, 72px)' ),
		], [
			mv_heading( $T['cierre_h2'], [ 'tag' => 'h2', 'color' => 'blanco', 'peso' => 600, 'tam' => 'clamp(2.5rem, 8vw, 5.5rem)', 'interlineado' => 0.98, 'clase' => 'cierre__titular' ] ),
			mv_text( '<p>' . esc_html( $T['cierre_texto'] ) . '</p>', [ 'color' => 'sobre-negro', 'tam' => '1.1875rem', 'margen' => mv_dim( 18, 0, 30, 0 ) ] ),
			mv_button( $T['cta'], $T['presupuesto'], 'lima', [ 'tam' => '1.125rem', 'relleno' => mv_dim( 18, 30 ) ] ),
		] ),
	] );
}

/** Pie: nombre, lema y enlaces a las páginas legales. */
function mv_pie( array $T ): array {
	$legales = '<ul class="legales">';
	foreach ( mv_legales_rutas( $T['idioma'] ) as [ $pagina, , $url ] ) {
		$legales .= '<li><a href="' . esc_url( $url ) . '">' . esc_html( $pagina ) . '</a></li>';
	}
	$legales .= '</ul>';

	return mv_box( [
		'html_tag'              => 'footer',
		'css_classes'           => 'pie',
		'content_width'         => 'boxed',
		'boxed_width'           => mv_size( 1240 ),
		'flex_direction'        => 'row',
		'flex_direction_mobile' => 'column',
		'flex_justify_content'  => 'space-between',
		'flex_align_items'      => 'flex-start',
		'flex_gap'              => mv_gap( 20 ),
		'padding'               => mv_dim( 'clamp(40px, 6vw, 72px)', MV_GUTTER, 'clamp(28px, 4vw, 44px)', MV_GUTTER ),
	], [
		mv_text( '<p><strong>Manitas Vallés</strong><br>' . esc_html( $T['pie_lema'] ) . '</p>', [ 'tam' => '1rem', 'clase' => 'pie__marca' ] ),
		mv_text( $legales, [ 'tam' => '1rem', 'color' => 'gris', 'clase' => 'pie__legales' ] ),
	], true );
}

function mv_principal( array $hijos ): array {
	return mv_box( [
		'html_tag'       => 'main',
		'_element_id'    => 'contenido',
		'flex_direction' => 'column',
		'flex_gap'       => mv_gap( 0 ),
		'padding'        => mv_dim( 0 ),
	], $hijos, true );
}

function mv_home( array $T ): array {
	return [
		mv_cabecera( $T ),
		mv_principal( [ mv_portada( $T ), mv_servicios( $T ), mv_precios( $T ), mv_como( $T ), mv_zona( $T ), mv_cierre( $T ) ] ),
		mv_pie( $T ),
	];
}

/** Página del formulario. $id_form es el formulario de Contact Form 7 de ese idioma (ver formulario.php). */
function mv_presupuesto( array $T, int $id_form ): array {
	return [
		mv_cabecera( $T ),
		mv_principal( [
			mv_seccion( [ 'css_classes' => 'presupuesto', 'padding' => mv_dim( 'clamp(28px, 5vw, 64px)', MV_GUTTER, 0, MV_GUTTER ) ], [
				mv_heading( $T['presupuesto_h1'], [ 'tag' => 'h1', 'peso' => 600, 'tam' => 'clamp(2.5rem, 7vw, 4.5rem)' ] ),
				mv_text( '<p>' . esc_html( $T['presupuesto_texto'] ) . '</p>', [ 'color' => 'gris', 'tam' => '1.1875rem', 'clase' => 'medida', 'margen' => mv_dim( 16, 0, 32, 0 ) ] ),
				mv_shortcode( '[contact-form-7 id="' . $id_form . '" html_class="solicitud"]', [ 'clase' => 'presupuesto__form' ] ),
			] ),
		] ),
		mv_pie( $T ),
	];
}

/** Página legal: título y texto corrido (ver legales.php). */
function mv_legal( array $T, string $titulo, string $html ): array {
	return [
		mv_cabecera( $T ),
		mv_principal( [
			mv_seccion( [ 'css_classes' => 'legal', 'padding' => mv_dim( 'clamp(28px, 5vw, 64px)', MV_GUTTER, 0, MV_GUTTER ) ], [
				mv_heading( $titulo, [ 'tag' => 'h1', 'peso' => 600, 'tam' => 'clamp(2.25rem, 6vw, 4rem)', 'margen' => mv_dim( 0, 0, 'clamp(20px, 3vw, 32px)', 0 ) ] ),
				mv_text( $html, [ 'clase' => 'legal__texto' ] ),
			] ),
		] ),
		mv_pie( $T ),
	];
}
