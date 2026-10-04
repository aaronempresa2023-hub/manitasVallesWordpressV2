<?php
/**
 * Textos de la web en castellano y catalán. mv_textos( 'es' | 'ca' ) devuelve el mapa de un idioma.
 *
 * Los precios vienen de precios.php (MV_P). Para cambiar un precio, edita solo ese fichero.
 * Los municipios salen de SPEC.md sección 7 (pendiente de verificar con Idescat).
 */

const MV_MUNICIPIOS = [
	'Badia del Vallès', 'Barberà del Vallès', 'Castellar del Vallès', 'Castellbisbal', 'Cerdanyola del Vallès',
	'Gallifa', 'Matadepera', 'Montcada i Reixac', 'Palau-solità i Plegamans', 'Polinyà', 'Ripollet', 'Rubí',
	'Sabadell', 'Sant Cugat del Vallès', 'Sant Llorenç Savall', 'Sant Quirze del Vallès',
	'Santa Perpètua de Mogoda', 'Sentmenat', 'Terrassa', 'Ullastrell', 'Vacarisses', 'Viladecavalls',
];

function mv_textos( string $idioma ): array {
	$t = [
		'es' => [
			'idioma'      => 'es',
			'inicio'      => '/',
			'presupuesto' => '/presupuesto/',
			'otro_idioma' => [ 'CA', '/ca/', 'Versió en català' ],
			'este_idioma' => 'ES',
			'saltar'      => 'Saltar al contenido',
			'cta'         => 'Pedir presupuesto',
			'nav'         => [ [ 'Servicios', '#servicios' ], [ 'Precios', '#precios' ], [ 'Cómo trabajamos', '#como' ] ],

			'h1'          => 'Arreglos en casa con el <span class="enorme">precio</span> por delante',
			'hero_texto'  => 'Fontanería, electricidad y montaje a domicilio en el Vallès Occidental. Los trabajos habituales tienen precio cerrado, con el IVA incluido.',
			'hero_enlace' => 'Ver los precios',
			'lecturas'    => [ [ MV_P['enchufe'], 'Cambiar un enchufe' ], [ MV_P['lampara'], 'Instalar una lámpara' ], [ MV_P['grifo'], 'Cambiar un grifo' ] ],

			'servicios_h2' => 'Qué arreglamos',
			'servicios'    => [
				[ 'fontaneria',   'Fontanería',        'Grifos, cisternas, sifones, desatascos y sellados.',                          'desde',    MV_P['cisterna'] ],
				[ 'electricidad', 'Electricidad',      'Lámparas, enchufes, interruptores y ventiladores de techo.',                  'desde',    MV_P['enchufe'] ],
				[ 'montaje',      'Montaje de muebles','Muebles, armarios, baldas, cuadros, cortinas y estores.',                     'desde',    MV_P['balda'] ],
				[ 'reparaciones', 'Reparaciones',      'Persianas, puertas que rozan, manetas y lo que no esté en la lista.',         'por hora', MV_P['hora'] ],
			],

			'precios_h2'    => 'Precios cerrados',
			'precios_intro' => 'Solo mano de obra, con el IVA incluido. Los materiales van aparte, salvo que se indique.',
			'col_trabajo'   => 'Trabajo',
			'col_precio'    => 'Precio con IVA',
			'tablas'        => [
				'Electricidad' => [
					[ 'Instalación de lámpara o aplique',        'Aportada por el cliente',                                         MV_P['lampara'] ],
					[ 'Cambio de enchufe, interruptor o conmutador', 'La primera unidad; +' . MV_P['enchufe_adic'] . ' cada una adicional', MV_P['enchufe'] ],
					[ 'Instalación de ventilador de techo',      'Con punto de luz existente',                                      MV_P['ventilador'] ],
				],
				'Fontanería' => [
					[ 'Cambio de grifo',                         'Cocina o baño',                                                   MV_P['grifo'] ],
					[ 'Reparación del mecanismo de cisterna',    'Más las piezas',                                                  MV_P['cisterna'] ],
					[ 'Sellado con silicona de bañera o ducha',  'Más la silicona',                                                 MV_P['silicona'] ],
					[ 'Cambio de sifón o desagüe',               '',                                                                MV_P['sifon'] ],
					[ 'Desatasco simple',                        'Sifón, muelle o ventosa',                                         MV_P['desatasco'] ],
				],
				'Bricolaje y montaje' => [
					[ 'Montaje de mueble pequeño o mediano',     'Tipo IKEA',                                                       MV_P['mueble'] ],
					[ 'Montaje de armario',                      'De 2 o 3 puertas',                                                MV_P['armario'] ],
					[ 'Colgar balda, cuadro o espejo',           'La primera unidad; +' . MV_P['balda_adic'] . ' cada una adicional',    MV_P['balda'] ],
					[ 'Cortinas, estores o rieles',              'La primera unidad; +' . MV_P['cortinas_adic'] . ' cada una adicional', MV_P['cortinas'] ],
					[ 'Cambio de cinta o cordón de persiana',    'Más la cinta',                                                    MV_P['persiana'] ],
					[ 'Ajuste de puerta que roza',               '',                                                                MV_P['puerta'] ],
					[ 'Cambio de maneta',                        'La primera unidad; +' . MV_P['maneta_adic'] . ' cada una adicional',   MV_P['maneta'] ],
				],
			],

			'como_h2' => 'Cómo trabajamos',
			'pasos'   => [
				[ 'Nos contactas', 'Rellenas el formulario y, si puedes, añades fotos.' ],
				[ 'Te damos presupuesto', 'Te respondemos con un precio antes de empezar.' ],
				[ 'Lo reparamos', 'Vamos a tu casa y lo dejamos hecho.' ],
			],

			'zona_h2'    => 'Dónde trabajamos',
			'zona_texto' => 'En los municipios del Vallès Occidental.',

			'cierre_h2'    => '¿Qué hay que arreglar?',
			'cierre_texto' => 'Cuéntanoslo y te respondemos con un precio.',

			'pie_lema' => 'Reparaciones del hogar en el Vallès Occidental.',

			'presupuesto_h1'    => 'Pedir presupuesto',
			'presupuesto_texto' => 'Cuéntanos qué hay que arreglar y te respondemos con un precio.',
			'volver'            => 'Volver al inicio',

			'form' => [
				'legend_trabajo'    => 'El trabajo',
				'legend_datos'      => 'Tus datos',
				'titulo'            => 'Título',
				'titulo_ayuda'      => 'Un resumen breve, por ejemplo: grifo que gotea en la cocina',
				'tipo'              => 'Tipo de tarea',
				'tipos'             => [ 'Electricidad', 'Fontanería', 'Bricolaje y montaje', 'Otros' ],
				'elige'             => 'Elige una opción',
				'municipio'         => 'Municipio',
				'materiales'        => '¿Aportas tú los materiales?',
				'si_no'             => [ 'Sí', 'No' ],
				'descripcion'       => 'Descripción',
				'descripcion_ayuda' => 'Añade la descripción más detallada posible para recibir un presupuesto ajustado',
				'fotos'             => 'Fotos',
				'foto_n'            => 'Foto %d',
				'fotos_ayuda'       => 'Si aportas imágenes de la reparación o del sitio de instalación podremos ajustar mejor el presupuesto.',
				'fotos_limite'      => 'JPG, PNG o WebP, hasta 5 MB cada una.',
				'opcional'          => 'Opcional',
				'nombre'            => 'Nombre',
				'telefono'          => 'Teléfono',
				'correo'            => 'Correo electrónico',
				'privacidad'        => 'He leído la <a href="/politica-de-privacidad/" target="_blank" rel="noopener">política de privacidad</a> y acepto que Manitas Vallés use mis datos para responder a mi solicitud.',
				'enviar'            => 'Enviar solicitud',
				'mensajes'          => [
					'mail_sent_ok'             => 'Hemos recibido tu solicitud. Te responderemos con un presupuesto.',
					'mail_sent_ng'             => 'No hemos podido enviar la solicitud. Inténtalo de nuevo dentro de unos minutos.',
					'validation_error'         => 'Revisa los campos marcados y vuelve a enviar.',
					'spam'                     => 'No hemos podido comprobar que no eres un robot. Recarga la página e inténtalo de nuevo.',
					'accept_terms'             => 'Marca la casilla de la política de privacidad para poder enviar.',
					'invalid_required'         => 'Este campo es obligatorio.',
					'invalid_too_long'         => 'El texto es demasiado largo.',
					'invalid_email'            => 'Escribe un correo válido.',
					'invalid_tel'              => 'Escribe un teléfono válido.',
					'upload_failed'            => 'No se ha podido subir la imagen. Inténtalo de nuevo.',
					'upload_file_type_invalid' => 'Solo se admiten imágenes JPG, PNG o WebP.',
					'upload_file_too_large'    => 'La imagen supera los 5 MB.',
					'upload_failed_php_error'  => 'No se ha podido subir la imagen. Inténtalo de nuevo.',
				],
			],

			'seo_titulo'      => 'Manitas Vallés · Reparaciones del hogar a precio cerrado en el Vallès Occidental',
			'seo_descripcion' => 'Fontanería, electricidad y montaje de muebles a domicilio en Terrassa, Sabadell, Rubí, Sant Cugat y todo el Vallès Occidental. Precios cerrados con IVA incluido.',
			'seo_presupuesto' => 'Pedir presupuesto · Manitas Vallés',
		],

		'ca' => [
			'idioma'      => 'ca',
			'inicio'      => '/ca/',
			'presupuesto' => '/ca/pressupost/',
			'otro_idioma' => [ 'ES', '/', 'Versión en castellano' ],
			'este_idioma' => 'CA',
			'saltar'      => 'Salta al contingut',
			'cta'         => 'Demanar pressupost',
			'nav'         => [ [ 'Serveis', '#servicios' ], [ 'Preus', '#precios' ], [ 'Com treballem', '#como' ] ],

			'h1'          => 'Reparacions a casa amb el <span class="enorme">preu</span> per davant',
			'hero_texto'  => 'Lampisteria, electricitat i muntatge a domicili al Vallès Occidental. Les feines habituals tenen preu tancat, amb l’IVA inclòs.',
			'hero_enlace' => 'Veure els preus',
				'lecturas'    => [ [ MV_P['enchufe'], 'Canviar un endoll' ], [ MV_P['lampara'], 'Instal·lar un llum' ], [ MV_P['grifo'], 'Canviar una aixeta' ] ],

				'servicios_h2' => 'Què arreglem',
				'servicios'    => [
					[ 'fontaneria',   'Lampisteria',        'Aixetes, cisternes, sifons, desembussos i segellats.',                         'des de',   MV_P['cisterna'] ],
					[ 'electricidad', 'Electricitat',       'Llums, endolls, interruptors i ventiladors de sostre.',                        'des de',   MV_P['enchufe'] ],
					[ 'montaje',      'Muntatge de mobles', 'Mobles, armaris, prestatges, quadres, cortines i estors.',                     'des de',   MV_P['balda'] ],
					[ 'reparaciones', 'Reparacions',        'Persianes, portes que freguen, manetes i el que no sigui a la llista.',        'per hora', MV_P['hora'] ],
				],

				'precios_h2'    => 'Preus tancats',
				'precios_intro' => 'Només mà d’obra, amb l’IVA inclòs. Els materials van a part, tret que s’indiqui.',
				'col_trabajo'   => 'Feina',
				'col_precio'    => 'Preu amb IVA',
				'tablas'        => [
					'Electricitat' => [
						[ 'Instal·lació de llum o aplic',              'Aportat pel client',                                                   MV_P['lampara'] ],
						[ 'Canvi d’endoll, interruptor o commutador',         'La primera unitat; +' . MV_P['enchufe_adic'] . ' cada una d’addicional', MV_P['enchufe'] ],
						[ 'Instal·lació de ventilador de sostre',      'Amb punt de llum existent',                                           MV_P['ventilador'] ],
					],
					'Lampisteria' => [
						[ 'Canvi d’aixeta',                                   'Cuina o bany',                                                        MV_P['grifo'] ],
						[ 'Reparació del mecanisme de la cisterna',         'Més les peces',                                                   MV_P['cisterna'] ],
						[ 'Segellat amb silicona de banyera o dutxa',            'Més la silicona',                                                 MV_P['silicona'] ],
						[ 'Canvi de sifó o desguàs',                   '',                                                                    MV_P['sifon'] ],
						[ 'Desembús simple',                                'Sifó, molla o ventosa',                                           MV_P['desatasco'] ],
					],
					'Bricolatge i muntatge' => [
						[ 'Muntatge de moble petit o mitjà',                'Tipus IKEA',                                                          MV_P['mueble'] ],
						[ 'Muntatge d’armari',                                'De 2 o 3 portes',                                                     MV_P['armario'] ],
						[ 'Penjar prestatge, quadre o mirall',                   'La primera unitat; +' . MV_P['balda_adic'] . ' cada una d’addicional',    MV_P['balda'] ],
						[ 'Cortines, estors o rails',                            'La primera unitat; +' . MV_P['cortinas_adic'] . ' cada una d’addicional', MV_P['cortinas'] ],
						[ 'Canvi de cinta o cordó de persiana',             'Més la cinta',                                                    MV_P['persiana'] ],
						[ 'Ajust de porta que frega',                            '',                                                                    MV_P['puerta'] ],
						[ 'Canvi de maneta',                                     'La primera unitat; +' . MV_P['maneta_adic'] . ' cada una d’addicional',   MV_P['maneta'] ],
					],
				],
			'como_h2' => 'Com treballem',
			'pasos'   => [
				[ 'Ens contactes', 'Omples el formulari i, si pots, hi afegeixes fotos.' ],
				[ 'Et donem pressupost', 'Et responem amb un preu abans de començar.' ],
				[ 'Ho reparem', 'Venim a casa teva i ho deixem fet.' ],
			],

			'zona_h2'    => 'On treballem',
			'zona_texto' => 'Als municipis del Vallès Occidental.',

			'cierre_h2'    => 'Què s’ha d’arreglar?',
			'cierre_texto' => 'Explica’ns-ho i et responem amb un preu.',

			'pie_lema' => 'Reparacions de la llar al Vallès Occidental.',

			'presupuesto_h1'    => 'Demanar pressupost',
			'presupuesto_texto' => 'Explica’ns què s’ha d’arreglar i et responem amb un preu.',
			'volver'            => 'Tornar a l’inici',

			'form' => [
				'legend_trabajo'    => 'La feina',
				'legend_datos'      => 'Les teves dades',
				'titulo'            => 'Títol',
				'titulo_ayuda'      => 'Un resum breu, per exemple: aixeta que goteja a la cuina',
				'tipo'              => 'Tipus de feina',
				'tipos'             => [ 'Electricitat', 'Lampisteria', 'Bricolatge i muntatge', 'Altres' ],
				'elige'             => 'Tria una opció',
				'municipio'         => 'Municipi',
				'materiales'        => 'Aportes tu els materials?',
				'si_no'             => [ 'Sí', 'No' ],
				'descripcion'       => 'Descripció',
				'descripcion_ayuda' => 'Afegeix la descripció més detallada possible per rebre un pressupost ajustat',
				'fotos'             => 'Fotos',
				'foto_n'            => 'Foto %d',
				'fotos_ayuda'       => 'Si aportes imatges de la reparació o del lloc d’instal·lació podrem ajustar millor el pressupost.',
				'fotos_limite'      => 'JPG, PNG o WebP, fins a 5 MB cadascuna.',
				'opcional'          => 'Opcional',
				'nombre'            => 'Nom',
				'telefono'          => 'Telèfon',
				'correo'            => 'Correu electrònic',
				'privacidad'        => 'He llegit la <a href="/ca/politica-de-privacitat/" target="_blank" rel="noopener">política de privacitat</a> i accepto que Manitas Vallés faci servir les meves dades per respondre la meva sol·licitud.',
				'enviar'            => 'Enviar sol·licitud',
				'mensajes'          => [
					'mail_sent_ok'             => 'Hem rebut la teva sol·licitud. Et respondrem amb un pressupost.',
					'mail_sent_ng'             => 'No hem pogut enviar la sol·licitud. Torna-ho a provar d’aquí a uns minuts.',
					'validation_error'         => 'Revisa els camps marcats i torna a enviar.',
					'spam'                     => 'No hem pogut comprovar que no ets un robot. Recarrega la pàgina i torna-ho a provar.',
					'accept_terms'             => 'Marca la casella de la política de privacitat per poder enviar.',
					'invalid_required'         => 'Aquest camp és obligatori.',
					'invalid_too_long'         => 'El text és massa llarg.',
					'invalid_email'            => 'Escriu un correu vàlid.',
					'invalid_tel'              => 'Escriu un telèfon vàlid.',
					'upload_failed'            => 'No s’ha pogut pujar la imatge. Torna-ho a provar.',
					'upload_file_type_invalid' => 'Només s’admeten imatges JPG, PNG o WebP.',
					'upload_file_too_large'    => 'La imatge supera els 5 MB.',
					'upload_failed_php_error'  => 'No s’ha pogut pujar la imatge. Torna-ho a provar.',
				],
			],

			'seo_titulo'      => 'Manitas Vallés · Reparacions de la llar a preu tancat al Vallès Occidental',
			'seo_descripcion' => 'Lampisteria, electricitat i muntatge de mobles a domicili a Terrassa, Sabadell, Rubí, Sant Cugat i tot el Vallès Occidental. Preus tancats amb l’IVA inclòs.',
			'seo_presupuesto' => 'Demanar pressupost · Manitas Vallés',
		],
	];
	return $t[ $idioma ];
}
