<?php
/**
 * Tema Manitas Vallés (V2).
 *
 * La maquetación se hace con Elementor (Free). Este tema solo aporta lo que Elementor Free no puede:
 *  - la tipografía autoalojada (sin Google Fonts) y los estilos por clase (assets/css/site.css);
 *  - la cinta que se extiende con el desplazamiento (assets/js/site.js);
 *  - idioma por página (castellano / catalán), hreflang y SEO local;
 *  - el enlace para saltar al contenido.
 */

defined( 'ABSPATH' ) || exit;

define( 'MV_VERSION', '0.2.0' );

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', [ 'search-form', 'gallery', 'caption', 'style', 'script' ] );
	}
);

/** Ruta/URL de un archivo del tema con versión por fecha de modificación (evita cachés viejas). */
function mv_asset( string $ruta ): array {
	$archivo = get_theme_file_path( $ruta );
	return [
		'url' => get_theme_file_uri( $ruta ),
		'ver' => file_exists( $archivo ) ? (string) filemtime( $archivo ) : MV_VERSION,
	];
}

/** Meta de la página actual que guarda el aprovisionamiento (_mv_lang, _mv_alt, _mv_seo_title…). */
function mv_meta( string $clave ): string {
	return is_singular() ? (string) get_post_meta( get_queried_object_id(), $clave, true ) : '';
}

/** Idioma de la página actual: «es» o «ca». */
function mv_idioma(): string {
	return 'ca' === mv_meta( '_mv_lang' ) ? 'ca' : 'es';
}

// -------------------------------------------------------------------------------------------------
// Estilos y scripts
// -------------------------------------------------------------------------------------------------
add_action(
	'wp_enqueue_scripts',
	function () {
		$css = mv_asset( 'assets/css/site.css' );
		// Depende de los estilos de Elementor para cargarse después y ganar en igualdad de especificidad.
		wp_enqueue_style( 'manitas-valles', $css['url'], [ 'elementor-frontend' ], $css['ver'] );

		$js = mv_asset( 'assets/js/site.js' );
		wp_enqueue_script( 'manitas-valles', $js['url'], [], $js['ver'], [ 'in_footer' => true, 'strategy' => 'defer' ] );

		// Las páginas son 100 % Elementor: no hace falta el CSS de bloques del editor de WordPress.
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'classic-theme-styles' );
		wp_dequeue_style( 'global-styles' );
	},
	20
);

// Tipografía local: Elementor no debe pedir nada a fonts.googleapis.com.
add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );

// Limpieza de <head>.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );

// -------------------------------------------------------------------------------------------------
// Idioma por página
// -------------------------------------------------------------------------------------------------
add_filter(
	'language_attributes',
	function ( string $salida ): string {
		if ( is_admin() ) {
			return $salida;
		}
		return (string) preg_replace( '/lang="[^"]*"/', 'lang="' . esc_attr( mv_idioma() ) . '"', $salida );
	}
);

// -------------------------------------------------------------------------------------------------
// <head>: tipografía, SEO local, hreflang
// -------------------------------------------------------------------------------------------------
add_filter(
	'pre_get_document_title',
	function ( string $titulo ): string {
		return mv_meta( '_mv_seo_title' ) ?: $titulo;
	}
);

add_action(
	'wp_head',
	function () {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( get_theme_file_uri( 'assets/fonts/bricolage-grotesque.woff2' ) )
		);
		echo '<meta name="theme-color" content="#121212">' . "\n";

		$descripcion = mv_meta( '_mv_seo_description' );
		$url         = get_permalink();
		$titulo      = wp_get_document_title();

		if ( $descripcion ) {
			printf( '<meta name="description" content="%s">' . "\n", esc_attr( $descripcion ) );
			printf( '<meta property="og:type" content="website">' . "\n" );
			printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
			printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $titulo ) );
			printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $descripcion ) );
			printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
			printf( '<meta property="og:locale" content="%s">' . "\n", 'ca' === mv_idioma() ? 'ca_ES' : 'es_ES' );
		}

		$equivalente = (int) mv_meta( '_mv_alt' );
		if ( $equivalente && get_post( $equivalente ) ) {
			$otro = 'ca' === mv_idioma() ? 'es' : 'ca';
			printf( '<link rel="alternate" hreflang="%s" href="%s">' . "\n", esc_attr( mv_idioma() ), esc_url( $url ) );
			printf( '<link rel="alternate" hreflang="%s" href="%s">' . "\n", esc_attr( $otro ), esc_url( get_permalink( $equivalente ) ) );
			printf( '<link rel="alternate" hreflang="x-default" href="%s">' . "\n", esc_url( 'es' === mv_idioma() ? $url : get_permalink( $equivalente ) ) );
		}

		// Datos estructurados del negocio, solo en las portadas. Sin teléfono ni dirección: no se publican.
		if ( 0 === strpos( mv_meta( '_mv_page' ), 'inicio_' ) ) {
			$datos = [
				'@context'    => 'https://schema.org',
				'@type'       => 'HomeAndConstructionBusiness',
				'name'        => 'Manitas Vallés',
				'url'         => $url,
				'description' => $descripcion,
				'areaServed'  => [
					'@type' => 'AdministrativeArea',
					'name'  => 'Vallès Occidental',
				],
			];
			echo '<script type="application/ld+json">' . wp_json_encode( $datos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . "</script>\n";
		}
	},
	2
);

// -------------------------------------------------------------------------------------------------
// <body>: saltar al contenido y la cinta de progreso (la mueve assets/js/site.js)
// -------------------------------------------------------------------------------------------------
add_action(
	'wp_body_open',
	function () {
		$saltar = mv_meta( '_mv_skip' );
		if ( $saltar ) {
			printf( '<a class="saltar" href="#contenido">%s</a>' . "\n", esc_html( $saltar ) );
		}
		echo '<div class="flexo" aria-hidden="true"><div class="flexo__hoja"></div><div class="flexo__tope"><span class="flexo__seccion"></span></div></div>' . "\n";
	}
);

// -------------------------------------------------------------------------------------------------
// Formulario de presupuesto (Contact Form 7)
// -------------------------------------------------------------------------------------------------

/** ¿La página actual lleva el formulario? */
function mv_tiene_formulario(): bool {
	return 0 === strpos( mv_meta( '_mv_page' ), 'presupuesto_' );
}

// El marcado del formulario es propio: CF7 no debe añadir <p> ni <br>.
add_filter( 'wpcf7_autop_or_not', '__return_false' );

// CF7 y Turnstile solo se cargan donde hay formulario: la portada no pide nada a Cloudflare.
add_action(
	'wp_enqueue_scripts',
	function () {
		if ( mv_tiene_formulario() ) {
			return;
		}
		wp_dequeue_script( 'cloudflare-turnstile' );
		wp_dequeue_script( 'contact-form-7' );
		wp_dequeue_style( 'contact-form-7' );
	},
	30
);

/**
 * Adjuntos: CF7 solo mira la extensión. Aquí se comprueba el tipo real del archivo y que sea una imagen
 * que se puede leer, para que no entre nada disfrazado de .jpg. Cuando llega este filtro CF7 ya ha movido
 * el archivo a su carpeta temporal y pasa la ruta en $extra['uploaded_files'].
 */
function mv_validar_foto( $resultado, $tag, $extra = [] ) {
	$rutas = $extra['uploaded_files'] ?? [];
	if ( is_wp_error( $rutas ) ) {
		return $resultado;
	}
	foreach ( (array) $rutas as $ruta ) {
		if ( ! $ruta || ! is_file( $ruta ) ) {
			continue;
		}
		$tipo = function_exists( 'finfo_open' ) ? (string) finfo_file( finfo_open( FILEINFO_MIME_TYPE ), $ruta ) : '';
		if ( ! in_array( $tipo, [ 'image/jpeg', 'image/png', 'image/webp' ], true ) || false === @getimagesize( $ruta ) ) { // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
			wp_delete_file( $ruta );
			$resultado->invalidate( $tag, wpcf7_get_message( 'upload_file_type_invalid' ) );
			break;
		}
	}
	return $resultado;
}
add_filter( 'wpcf7_validate_file', 'mv_validar_foto', 20, 3 );
add_filter( 'wpcf7_validate_file*', 'mv_validar_foto', 20, 3 );

/**
 * Límite de envíos: como mucho 5 por hora desde la misma IP. La IP no se guarda: solo un resumen con sal.
 * Se evalúa antes que Turnstile (prioridad 9) para no gastar verificaciones en quien ya ha superado el límite.
 */
add_filter(
	'wpcf7_spam',
	function ( $spam ) {
		if ( $spam ) {
			return $spam;
		}
		$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
		$clave = 'mv_envios_' . md5( wp_salt() . $ip );
		$n     = (int) get_transient( $clave );
		if ( $n >= 5 ) {
			return true;
		}
		set_transient( $clave, $n + 1, HOUR_IN_SECONDS );
		return $spam;
	},
	8
);

// -------------------------------------------------------------------------------------------------
// Aviso de cookies. La web solo usa lo estrictamente necesario, así que el aviso informa y no pide
// consentimiento. Si algún día se añaden analíticas o terceros, tendrán que cargarse solo tras aceptar.
// -------------------------------------------------------------------------------------------------
add_action(
	'wp_footer',
	function () {
		$ca      = 'ca' === mv_idioma();
		$paginas = (array) get_option( 'mv_cookies_page', [] );
		$politica = ! empty( $paginas[ mv_idioma() ] ) ? get_permalink( (int) $paginas[ mv_idioma() ] ) : '';
		if ( ! $politica ) {
			return;
		}
		printf(
			'<div class="aviso-cookies" role="region" aria-label="%1$s" hidden><p>%2$s <a href="%3$s">%4$s</a></p><button type="button" class="aviso-cookies__cerrar">%5$s</button></div>' . "\n",
			esc_attr( $ca ? 'Avís de galetes' : 'Aviso de cookies' ),
			esc_html( $ca ? 'Aquesta web només fa servir galetes tècniques, necessàries perquè funcioni. No n’hi ha d’anàlisi ni de publicitat.' : 'Esta web solo usa cookies técnicas, necesarias para que funcione. No hay de análisis ni de publicidad.' ),
			esc_url( $politica ),
			esc_html( $ca ? 'Política de galetes' : 'Política de cookies' ),
			esc_html( $ca ? 'Entesos' : 'Entendido' )
		);
	},
	5
);

// -------------------------------------------------------------------------------------------------
// Conservación de las solicitudes: doce meses (es lo que dice la política de privacidad).
// Una vez al día se borran de Flamingo los mensajes y contactos con más de doce meses.
// -------------------------------------------------------------------------------------------------
add_action(
	'init',
	function () {
		if ( ! wp_next_scheduled( 'mv_borrar_solicitudes' ) ) {
			wp_schedule_event( time() + HOUR_IN_SECONDS, 'daily', 'mv_borrar_solicitudes' );
		}
	}
);

add_action(
	'mv_borrar_solicitudes',
	function () {
		$antiguas = get_posts( [
			'post_type'   => [ 'flamingo_inbound', 'flamingo_contact' ],
			'post_status' => 'any',
			'date_query'  => [ [ 'before' => '12 months ago' ] ],
			'numberposts' => 200,
			'fields'      => 'ids',
		] );
		foreach ( $antiguas as $id ) {
			wp_delete_post( $id, true );
		}
	}
);
