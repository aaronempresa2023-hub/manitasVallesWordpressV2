<?php
/**
 * Ayudantes para construir datos de Elementor (Free) desde PHP.
 *
 * Solo generan contenedores y widgets clásicos de Elementor Free (heading, text-editor, button, icon,
 * icon-list, image, shortcode). Nada de iframes ni de widgets Pro.
 *
 * Convención de tamaños: un número es px; «1.5rem»/«2em»/«5vw» conservan su unidad; cualquier otra cosa
 * (clamp(), calc(), min()…) se guarda con la unidad «custom» de Elementor.
 */

// ---------------------------------------------------------------------------------------------
// Paleta: nombre → [id del color global en el Kit de Elementor, valor]
// ---------------------------------------------------------------------------------------------
const MV_COLORS = [
	'negro'       => [ 'primary', '#121212', 'Negro (bloques)' ],
	'superficie'  => [ 'secondary', '#EEEDE9', 'Superficie' ],
	'tinta'       => [ 'text', '#121212', 'Tinta' ],
	'lima'        => [ 'accent', '#CCFF00', 'Lima (acento)' ],
	'blanco'      => [ 'blanco', '#FFFFFF', 'Blanco' ],
	'gris'        => [ 'gris', '#5E5E5E', 'Texto secundario' ],
	'sobre-negro' => [ 'sobre-negro', '#C9C9C4', 'Texto secundario sobre negro' ],
	'linea'       => [ 'linea', '#D6D4CE', 'Línea' ],
	'error'       => [ 'error', '#B3261E', 'Error' ],
];

// Una sola familia en toda la web (variable: peso y anchura). Las cifras condensadas las fija el tema por clase.
const MV_ROTULO = 'Bricolage Grotesque';
const MV_TEXTO  = 'Bricolage Grotesque';

/** Marca un ajuste de color para que use el color global del Kit (y guarde también el valor literal). */
function mv_c( string $nombre ): array {
	return [ '__color' => $nombre ];
}

/** Id de elemento de 7 caracteres hexadecimales, determinista (misma web → mismos ids). */
function mv_id(): string {
	static $n = 0;
	return substr( md5( 'manitas-valles-v2-' . ( ++$n ) ), 0, 7 );
}

// ---------------------------------------------------------------------------------------------
// Valores de controles
// ---------------------------------------------------------------------------------------------

/** Slider: 24 → px; «1.5rem» → rem; «clamp(...)» → custom. */
function mv_size( $valor ): array {
	if ( is_int( $valor ) || is_float( $valor ) || ( is_string( $valor ) && is_numeric( $valor ) ) ) {
		return [ 'unit' => 'px', 'size' => 0 + $valor, 'sizes' => [] ];
	}
	if ( is_string( $valor ) && preg_match( '/^(-?[\d.]+)(rem|em|vw|vh|%)$/', $valor, $m ) ) {
		return [ 'unit' => $m[2], 'size' => 0 + $m[1], 'sizes' => [] ];
	}
	return [ 'unit' => 'custom', 'size' => (string) $valor, 'sizes' => [] ];
}

/**
 * Dimensiones estilo CSS: (arriba, derecha, abajo, izquierda). Admite números (px) y cadenas custom.
 * Si alguna es una cadena CSS (clamp(), auto…), todas pasan a la unidad «custom» y los números reciben «px»
 * (un número sin unidad no es CSS válido).
 */
function mv_dim( $t, $r = null, $b = null, $l = null ): array {
	$r ??= $t;
	$b ??= $t;
	$l ??= $r;
	$custom = false;
	foreach ( [ $t, $r, $b, $l ] as $v ) {
		if ( is_string( $v ) && ! is_numeric( $v ) ) {
			$custom = true;
		}
	}
	$css = fn( $v ) => ( $custom && is_numeric( $v ) ) ? ( 0 == $v ? '0' : $v . 'px' ) : (string) $v;
	return [
		'unit'     => $custom ? 'custom' : 'px',
		'top'      => $css( $t ),
		'right'    => $css( $r ),
		'bottom'   => $css( $b ),
		'left'     => $css( $l ),
		'isLinked' => $t === $r && $r === $b && $b === $l,
	];
}

/** Hueco entre hijos: mv_gap(fila, columna). */
function mv_gap( $fila, $columna = null ): array {
	$columna ??= $fila;
	return [
		'column'   => (string) $columna,
		'row'      => (string) $fila,
		'isLinked' => $fila === $columna,
		'unit'     => 'px',
		'size'     => $fila,
	];
}

/** Valores responsivos: mv_r('padding', ['d' => .., 't' => .., 'm' => ..], 'mv_dim') → padding, padding_tablet, padding_mobile. */
function mv_r( string $clave, array $valores, ?callable $convertir = null ): array {
	$convertir ??= fn( $v ) => $v;
	$salida      = [];
	foreach ( [ 'd' => '', 't' => '_tablet', 'm' => '_mobile' ] as $k => $sufijo ) {
		if ( array_key_exists( $k, $valores ) ) {
			$salida[ $clave . $sufijo ] = $convertir( $valores[ $k ] );
		}
	}
	return $salida;
}

/**
 * Contenedor grid. $cols/$filas: plantilla por breakpoint ['d','t','m'] como texto CSS (p. ej. 'repeat(3, minmax(0, 1fr))').
 * $hueco: [fila, columna] o un número, también por breakpoint si es un array con claves d/t/m.
 */
function mv_grid( array $cols, $hueco = 0, array $filas = [] ): array {
	$s = [ 'container_type' => 'grid' ];
	$s += mv_r( 'grid_columns_grid', $cols, 'mv_size' );
	$s += mv_r( 'grid_rows_grid', $filas ?: [ 'd' => 'auto', 't' => 'auto', 'm' => 'auto' ], 'mv_size' );
	if ( is_array( $hueco ) && array_intersect( array_keys( $hueco ), [ 'd', 't', 'm' ] ) ) {
		$s += mv_r( 'grid_gaps', $hueco, fn( $h ) => is_array( $h ) ? mv_gap( ...$h ) : mv_gap( $h ) );
	} else {
		$s['grid_gaps'] = is_array( $hueco ) ? mv_gap( ...$hueco ) : mv_gap( $hueco );
	}
	return $s;
}

/** Tipografía: familia, peso y, opcionalmente, tamaño (escalar o ['d','t','m']), interlineado, tracking, mayúsculas. */
function mv_t( string $familia, $peso, $tam = null, $interlineado = null, $tracking = null, ?string $transformar = null, string $prefijo = 'typography', ?string $decoracion = null ): array {
	$s = [
		"{$prefijo}_typography"  => 'custom',
		"{$prefijo}_font_family" => $familia,
		"{$prefijo}_font_weight" => (string) $peso,
	];
	if ( null !== $tam ) {
		$s += is_array( $tam ) ? mv_r( "{$prefijo}_font_size", $tam, 'mv_size' ) : [ "{$prefijo}_font_size" => mv_size( $tam ) ];
	}
	if ( null !== $interlineado ) {
		// Sin unidad (custom): con «em» el navegador hereda píxeles absolutos y los hijos con otro tamaño se desajustan.
		$s["{$prefijo}_line_height"] = [ 'unit' => 'custom', 'size' => (string) $interlineado, 'sizes' => [] ];
	}
	if ( null !== $tracking ) {
		$s["{$prefijo}_letter_spacing"] = [ 'unit' => 'em', 'size' => $tracking, 'sizes' => [] ];
	}
	if ( $transformar ) {
		$s["{$prefijo}_text_transform"] = $transformar;
	}
	if ( $decoracion ) {
		$s["{$prefijo}_text_decoration"] = $decoracion;
	}
	return $s;
}

/** Enlace de Elementor. */
function mv_link( string $url, bool $externo = false ): array {
	return [ 'url' => $url, 'is_external' => $externo ? 'on' : '', 'nofollow' => '', 'custom_attributes' => '' ];
}

/**
 * Sustituye las marcas de color por valores y añade __globals__ para enlazar con el Kit.
 * Solo mira las claves de primer nivel (todas las que usamos).
 */
function mv_finish( array $ajustes ): array {
	$globales = [];
	foreach ( $ajustes as $k => $v ) {
		if ( is_array( $v ) && isset( $v['__color'] ) ) {
			[ $id, $hex ] = MV_COLORS[ $v['__color'] ];
			$ajustes[ $k ]  = $hex;
			$globales[ $k ] = 'globals/colors?id=' . $id;
		}
	}
	if ( $globales ) {
		$ajustes['__globals__'] = ( $ajustes['__globals__'] ?? [] ) + $globales;
	}
	return $ajustes;
}

// ---------------------------------------------------------------------------------------------
// Elementos
// ---------------------------------------------------------------------------------------------

/**
 * Contenedor. $ajustes usa los nombres de control de Elementor.
 * Por defecto ocupa todo el ancho (content_width = full) y es hijo; con $raiz = true es de primer nivel.
 */
function mv_box( array $ajustes, array $hijos = [], bool $raiz = false ): array {
	$ajustes += [ 'content_width' => 'full' ];
	return [
		'id'       => mv_id(),
		'elType'   => 'container',
		'isInner'  => ! $raiz,
		'settings' => mv_finish( $ajustes ),
		'elements' => $hijos,
	];
}

function mv_widget( string $tipo, array $ajustes ): array {
	return [
		'id'         => mv_id(),
		'elType'     => 'widget',
		'widgetType' => $tipo,
		'settings'   => mv_finish( $ajustes ),
		'elements'   => [],
	];
}

/** Ajustes comunes de widget: márgenes a cero salvo que se indique, clases, id, visibilidad. */
function mv_comun( array $o ): array {
	$s = [];
	if ( isset( $o['clase'] ) ) {
		$s['_css_classes'] = $o['clase'];
	}
	if ( isset( $o['id'] ) ) {
		$s['_element_id'] = $o['id'];
	}
	if ( isset( $o['margen'] ) ) {
		$s['_margin'] = $o['margen'];
	}
	if ( ! empty( $o['fijo'] ) ) { // ni crece ni se encoge dentro de una fila flex
		$s['_flex_size'] = 'none';
	}
	foreach ( [ 'desktop', 'tablet', 'mobile' ] as $bp ) {
		if ( ! empty( $o[ 'ocultar_' . $bp ] ) ) {
			$s[ 'hide_' . $bp ] = 'hidden-' . $bp;
		}
	}
	return $s;
}

/**
 * Título. $o: tag, color, alinear, tam, interlineado, tracking, transformar, peso, familia, enlace, clase, id, margen.
 */
function mv_heading( string $titulo, array $o = [] ): array {
	$s = [
		'title'       => $titulo,
		'header_size' => $o['tag'] ?? 'h2',
		'title_color' => mv_c( $o['color'] ?? 'tinta' ),
	] + mv_t(
		$o['familia'] ?? MV_ROTULO,
		$o['peso'] ?? 700,
		$o['tam'] ?? null,
		$o['interlineado'] ?? 1,
		$o['tracking'] ?? -0.02,
		$o['transformar'] ?? null
	) + mv_comun( $o );
	if ( isset( $o['enlace'] ) ) {
		$s['link'] = $o['enlace'];
	}
	if ( isset( $o['alinear'] ) ) {
		$s['align'] = $o['alinear'];
	}
	return mv_widget( 'heading', $s );
}

/** Texto (editor de texto). $o: color, tam, peso, interlineado, alinear, clase, id, margen. */
function mv_text( string $html, array $o = [] ): array {
	$s = [
		'editor'     => $html,
		'text_color' => mv_c( $o['color'] ?? 'tinta' ),
	] + mv_t( $o['familia'] ?? MV_TEXTO, $o['peso'] ?? 400, $o['tam'] ?? '1.0625rem', $o['interlineado'] ?? 1.5 ) + mv_comun( $o );
	if ( isset( $o['alinear'] ) ) {
		$s['align'] = $o['alinear'];
	}
	return mv_widget( 'text-editor', $s );
}

/**
 * Botón en píldora. $variante: lima | negro | linea | enlace.
 * Los colores al pasar el ratón los pone el tema (dependen del fondo sobre el que esté el botón).
 * $o: tam, relleno, alinear (['d','m']), color (solo enlace), clase, id, ocultar_*.
 */
function mv_button( string $texto, string $url, string $variante, array $o = [] ): array {
	$s = [
		'text' => $texto,
		'link' => mv_link( $url ),
		'size' => 'md',
	] + mv_comun( $o + [ 'clase' => '' ] );
	$s['_css_classes'] = trim( 'boton boton--' . $variante . ' ' . ( $o['clase'] ?? '' ) );

	if ( 'enlace' === $variante ) {
		$s += mv_t( MV_TEXTO, 600, $o['tam'] ?? '1rem', 1.4, null, null, 'typography', 'underline' );
		$s += [
			'button_text_color' => mv_c( $o['color'] ?? 'tinta' ),
			'background_color'  => 'rgba(0,0,0,0)',
			'text_padding'      => mv_dim( 12, 0 ),
			'border_radius'     => mv_dim( 0 ),
		];
	} else {
		$s += mv_t( MV_TEXTO, 600, $o['tam'] ?? '1.0625rem', 1.2, -0.01 );
		$s += [
			'text_padding'  => $o['relleno'] ?? mv_dim( 16, 26 ),
			'border_radius' => mv_dim( 999 ),
		];
		if ( 'lima' === $variante ) {
			$s += [ 'button_text_color' => mv_c( 'tinta' ), 'background_color' => mv_c( 'lima' ) ];
		} elseif ( 'negro' === $variante ) {
			$s += [ 'button_text_color' => mv_c( 'blanco' ), 'background_color' => mv_c( 'negro' ) ];
		} else { // linea: borde del color del texto, sobre fondo transparente
			$s += [
				'button_text_color' => mv_c( $o['color'] ?? 'tinta' ),
				'background_color'  => 'rgba(0,0,0,0)',
				'border_border'     => 'solid',
				'border_width'      => mv_dim( 1 ),
				'border_color'      => mv_c( $o['color'] ?? 'tinta' ),
			];
		}
	}
	$s += mv_r( 'align', $o['alinear'] ?? [], fn( $v ) => $v );
	return mv_widget( 'button', $s );
}

/** Icono suelto (SVG propio). */
function mv_icon( array $icono, string $color, $tam = 44, array $o = [] ): array {
	return mv_widget( 'icon', [
		'selected_icon' => [ 'value' => [ 'url' => $icono['url'], 'id' => $icono['id'] ], 'library' => 'svg' ],
		'view'          => 'default',
		'primary_color' => mv_c( $color ),
		'size'          => mv_size( $tam ),
		'align'         => 'left',
	] + mv_comun( $o ) );
}

/**
 * Lista. $items: cada uno ['texto', 'url' (opcional), 'icono' (opcional), 'externo' (opcional)].
 * $o: inline (bool), color, tam, peso, familia, icono_color, icono_tam, separacion, clase, id.
 */
function mv_list( array $items, array $o = [] ): array {
	$lista = [];
	foreach ( $items as $it ) {
		$fila = [
			'_id'           => mv_id(),
			'text'          => $it['texto'],
			'selected_icon' => [ 'value' => '', 'library' => '' ],
		];
		if ( ! empty( $it['icono'] ) ) {
			$fila['selected_icon'] = [ 'value' => [ 'url' => $it['icono']['url'], 'id' => $it['icono']['id'] ], 'library' => 'svg' ];
		}
		if ( ! empty( $it['url'] ) ) {
			$fila['link'] = mv_link( $it['url'], ! empty( $it['externo'] ) );
		}
		$lista[] = $fila;
	}
	$s = [
		'view'       => ! empty( $o['inline'] ) ? 'inline' : 'traditional',
		'icon_list'  => $lista,
		'text_color' => mv_c( $o['color'] ?? 'tinta' ),
		'icon_color' => mv_c( $o['icono_color'] ?? ( $o['color'] ?? 'tinta' ) ),
		'icon_size'  => mv_size( $o['icono_tam'] ?? 24 ),
	] + mv_t( $o['familia'] ?? MV_TEXTO, $o['peso'] ?? 500, $o['tam'] ?? '1.0625rem', $o['interlineado'] ?? 1.55, null, null, 'icon_typography' ) + mv_comun( $o );
	if ( isset( $o['separacion'] ) ) {
		$s['space_between'] = mv_size( $o['separacion'] );
	}
	if ( isset( $o['sangria'] ) ) {
		$s['text_indent'] = mv_size( $o['sangria'] );
	}
	return mv_widget( 'icon-list', $s );
}

/** Imagen de la biblioteca de medios. $o: ancho (escalar o ['d','t','m']), enlace, clase, id. */
function mv_image( array $medio, array $o = [] ): array {
	$s = [
		'image'      => [ 'url' => $medio['url'], 'id' => $medio['id'], 'size' => '', 'alt' => $o['alt'] ?? '' ],
		'image_size' => 'full',
	] + mv_comun( $o );
	if ( isset( $o['ancho'] ) ) {
		$s += is_array( $o['ancho'] ) ? mv_r( 'width', $o['ancho'], 'mv_size' ) : [ 'width' => mv_size( $o['ancho'] ) ];
	}
	if ( isset( $o['enlace'] ) ) {
		$s['link_to'] = 'custom';
		$s['link']    = mv_link( $o['enlace'] );
	}
	return mv_widget( 'image', $s );
}

function mv_shortcode( string $codigo, array $o = [] ): array {
	return mv_widget( 'shortcode', [ 'shortcode' => $codigo ] + mv_comun( $o ) );
}
