<?php
/**
 * Páginas legales (España / UE): Aviso legal (LSSI), Política de privacidad (RGPD) y Política de cookies,
 * en castellano y catalán.
 *
 * Los datos del titular los dio el usuario el 2026-10-02. Lo que aún no se sabe va marcado con
 * mv_pendiente() y se ve con subrayado discontinuo en la web. Estos textos son un punto de partida:
 * conviene que los revise un gestor o un abogado antes de publicar.
 */

const MV_TITULAR = [
	'nombre'    => 'Aaron Sánchez Garrido',
	'nif'       => '45640032M',
	'domicilio' => 'Calle Francia, 39, 08228 Terrassa (Barcelona)',
	'correo'    => 'aaron.empresa.2023@gmail.com',
];

const MV_LEGAL_FECHA = [ 'es' => '2 de octubre de 2026', 'ca' => '2 d’octubre de 2026' ];

function mv_pendiente( string $texto ): string {
	return '<span class="ph">[' . esc_html( $texto ) . ']</span>';
}

/** Rutas de las páginas legales de un idioma: clave => [título, slug, URL]. */
function mv_legales_rutas( string $idioma ): array {
	return 'ca' === $idioma
		? [
			'aviso'      => [ 'Avís legal', 'avis-legal', '/ca/avis-legal/' ],
			'privacidad' => [ 'Política de privacitat', 'politica-de-privacitat', '/ca/politica-de-privacitat/' ],
			'cookies'    => [ 'Política de galetes', 'politica-de-galetes', '/ca/politica-de-galetes/' ],
		]
		: [
			'aviso'      => [ 'Aviso legal', 'aviso-legal', '/aviso-legal/' ],
			'privacidad' => [ 'Política de privacidad', 'politica-de-privacidad', '/politica-de-privacidad/' ],
			'cookies'    => [ 'Política de cookies', 'politica-de-cookies', '/politica-de-cookies/' ],
		];
}

/** Contenido HTML de las tres páginas en un idioma: clave => HTML. */
function mv_legales_contenido( string $idioma ): array {
	$t      = array_map( 'esc_html', MV_TITULAR );
	$correo = '<a href="mailto:' . esc_attr( MV_TITULAR['correo'] ) . '">' . $t['correo'] . '</a>';
	$r      = mv_legales_rutas( $idioma );
	$enlace = fn( string $clave ) => '<a href="' . esc_url( $r[ $clave ][2] ) . '">' . esc_html( mb_strtolower( $r[ $clave ][0] ) ) . '</a>';
	$fecha  = MV_LEGAL_FECHA[ $idioma ];

	if ( 'ca' === $idioma ) {
		$hosting   = mv_pendiente( 'PENDENT: nom i país del proveïdor d’allotjament' );
		$plazo     = 'Les sol·licituds de pressupost es conserven durant dotze mesos des que es reben i després s’esborren';
		$dominio   = mv_pendiente( 'PENDENT: domini definitiu' );
		$duracion  = mv_pendiente( 'PENDENT: comprovar amb les claus reals' );
		return [
			'aviso' => <<<HTML
<h2>Titular del lloc web</h2>
<p>En compliment de l’article 10 de la Llei 34/2002, de serveis de la societat de la informació i de comerç electrònic (LSSI-CE), s’informa de les dades del titular d’aquest lloc web:</p>
<dl class="ficha">
<div><dt>Titular</dt><dd>{$t['nombre']}</dd></div>
<div><dt>NIF</dt><dd>{$t['nif']}</dd></div>
<div><dt>Domicili</dt><dd>{$t['domicilio']}</dd></div>
<div><dt>Correu electrònic</dt><dd>{$correo}</dd></div>
<div><dt>Nom comercial</dt><dd>Manitas Vallés</dd></div>
<div><dt>Lloc web</dt><dd>{$dominio}</dd></div>
</dl>
<h2>Objecte</h2>
<p>Aquest lloc web informa dels serveis de reparacions de la llar, lampisteria, electricitat i muntatge que Manitas Vallés presta a domicili al Vallès Occidental, i permet demanar un pressupost mitjançant un formulari.</p>
<h2>Condicions d’ús</h2>
<p>L’accés al lloc web és gratuït i n’atribueix la condició d’usuari. L’usuari es compromet a fer-ne un ús lícit i a no enviar pel formulari continguts falsos, il·lícits o que vulnerin drets de tercers.</p>
<h2>Preus</h2>
<p>Els preus publicats inclouen l’IVA i corresponen només a la mà d’obra, tret que s’indiqui el contrari. Tenen caràcter informatiu: el preu que obliga és el del pressupost que s’envia a cada client després de la seva sol·licitud.</p>
<h2>Propietat intel·lectual i industrial</h2>
<p>Els textos, el disseny, el logotip i el codi d’aquest lloc web pertanyen al titular o s’utilitzen amb llicència. No se’n permet la reproducció, distribució o transformació sense autorització, excepte per a l’ús personal i privat.</p>
<h2>Responsabilitat</h2>
<p>El titular procura que la informació sigui exacta i estigui actualitzada, però no en pot garantir l’absència d’errors ni la disponibilitat ininterrompuda del lloc web. El titular no respon dels continguts de llocs web de tercers.</p>
<h2>Protecció de dades i galetes</h2>
<p>El tractament de les dades personals es descriu a la {$enlace( 'privacidad' )} i l’ús de galetes, a la {$enlace( 'cookies' )}.</p>
<h2>Llei aplicable</h2>
<p>Aquest avís legal es regeix per la legislació espanyola. Si l’usuari és consumidor, per a qualsevol controvèrsia seran competents els jutjats i tribunals del seu domicili.</p>
<p class="legal__fecha">Darrera actualització: {$fecha}.</p>
HTML,
			'privacidad' => <<<HTML
<h2>Responsable del tractament</h2>
<dl class="ficha">
<div><dt>Responsable</dt><dd>{$t['nombre']} (Manitas Vallés)</dd></div>
<div><dt>NIF</dt><dd>{$t['nif']}</dd></div>
<div><dt>Domicili</dt><dd>{$t['domicilio']}</dd></div>
<div><dt>Correu electrònic</dt><dd>{$correo}</dd></div>
</dl>
<h2>Quines dades tractem</h2>
<p>Només les que ens envies pel formulari de pressupost: nom, telèfon, correu electrònic si l’indiques, municipi, la descripció de la feina i les fotos que hi adjuntis. Evita enviar fotos on apareguin persones o dades que no calguin per al pressupost.</p>
<h2>Per a què les fem servir</h2>
<p>Per respondre la teva sol·licitud, preparar el pressupost i, si l’acceptes, prestar el servei. No fem servir les teves dades per enviar publicitat ni per elaborar perfils, i no prenem decisions automatitzades.</p>
<h2>Base jurídica</h2>
<p>L’aplicació de mesures precontractuals a petició teva (article 6.1.b del Reglament (UE) 2016/679, RGPD) i el consentiment que dones en marcar la casella del formulari (article 6.1.a). Pots retirar el consentiment en qualsevol moment.</p>
<h2>Quant de temps les conservem</h2>
<p>{$plazo}. Si es presta el servei, les dades de facturació es conserven durant els terminis que exigeix la normativa fiscal.</p>
<h2>A qui es comuniquen</h2>
<p>No cedim les teves dades a tercers, tret d’obligació legal. Hi tenen accés, com a encarregats del tractament, els proveïdors necessaris perquè el lloc web funcioni:</p>
<ul>
<li>El proveïdor d’allotjament web i de correu: {$hosting}.</li>
<li>Cloudflare, Inc. (Estats Units), pel servei Turnstile, que comprova que el formulari l’envia una persona i no un programa. Per fer-ho tracta dades tècniques del navegador i l’adreça IP. Cloudflare està adherida al Marc de Privacitat de Dades UE-EUA.</li>
</ul>
<h2>Els teus drets</h2>
<p>Pots exercir els drets d’accés, rectificació, supressió, oposició, limitació del tractament i portabilitat escrivint a {$correo} i indicant quin dret vols exercir. Si consideres que no hem atès bé la teva petició, pots presentar una reclamació davant l’Agència Espanyola de Protecció de Dades (<a href="https://www.aepd.es" rel="noopener">www.aepd.es</a>) o l’Autoritat Catalana de Protecció de Dades.</p>
<h2>Seguretat</h2>
<p>El formulari s’envia per connexió xifrada, les fotos adjuntes es comproven abans d’acceptar-les i l’accés a les sol·licituds està restringit al titular.</p>
<p class="legal__fecha">Darrera actualització: {$fecha}.</p>
HTML,
			'cookies' => <<<HTML
<h2>Què són les galetes</h2>
<p>Les galetes són petits fitxers que un lloc web desa al teu navegador. Hi ha tecnologies semblants, com l’emmagatzematge local, que compleixen la mateixa funció.</p>
<h2>Quines fa servir aquest lloc web</h2>
<p>Aquest lloc web <strong>no fa servir galetes d’anàlisi, de publicitat ni de xarxes socials</strong>. Només utilitza el que és estrictament necessari perquè funcioni, i per això no cal el teu consentiment:</p>
<div class="tabla-desplazable">
<table class="tabla-legal">
<thead><tr><th scope="col">Nom</th><th scope="col">Qui el posa</th><th scope="col">Per a què</th><th scope="col">Durada</th></tr></thead>
<tbody>
<tr><td><code>mv_aviso_cookies</code> (emmagatzematge local)</td><td>Aquest lloc web</td><td>Recorda que ja has vist l’avís de galetes.</td><td>Fins que l’esborris</td></tr>
<tr><td>Galetes tècniques de Cloudflare Turnstile</td><td>Cloudflare, Inc.</td><td>Comprovar, només a la pàgina del formulari, que qui l’envia és una persona. No s’utilitzen per fer seguiment.</td><td>{$duracion}</td></tr>
</tbody>
</table>
</div>
<h2>Com esborrar-les o bloquejar-les</h2>
<p>Pots esborrar o bloquejar les galetes des de la configuració del teu navegador. Si bloqueges les de Cloudflare, és possible que el formulari no es pugui enviar.</p>
<h2>Canvis</h2>
<p>Si en el futur s’hi afegeixen galetes d’anàlisi o de tercers, no es carregaran fins que hi donis el teu consentiment, i aquesta política s’actualitzarà. El tractament de les teves dades es descriu a la {$enlace( 'privacidad' )}.</p>
<p class="legal__fecha">Darrera actualització: {$fecha}.</p>
HTML,
		];
	}

	$hosting = mv_pendiente( 'PENDIENTE: nombre y país del proveedor de alojamiento' );
	$plazo   = 'Las solicitudes de presupuesto se conservan durante doce meses desde que se reciben y después se borran';
	$dominio = mv_pendiente( 'PENDIENTE: dominio definitivo' );
	$duracion = mv_pendiente( 'PENDIENTE: comprobar con las claves reales' );
	return [
		'aviso' => <<<HTML
<h2>Titular del sitio web</h2>
<p>En cumplimiento del artículo 10 de la Ley 34/2002, de servicios de la sociedad de la información y de comercio electrónico (LSSI-CE), se informa de los datos del titular de este sitio web:</p>
<dl class="ficha">
<div><dt>Titular</dt><dd>{$t['nombre']}</dd></div>
<div><dt>NIF</dt><dd>{$t['nif']}</dd></div>
<div><dt>Domicilio</dt><dd>{$t['domicilio']}</dd></div>
<div><dt>Correo electrónico</dt><dd>{$correo}</dd></div>
<div><dt>Nombre comercial</dt><dd>Manitas Vallés</dd></div>
<div><dt>Sitio web</dt><dd>{$dominio}</dd></div>
</dl>
<h2>Objeto</h2>
<p>Este sitio web informa de los servicios de reparaciones del hogar, fontanería, electricidad y montaje que Manitas Vallés presta a domicilio en el Vallès Occidental, y permite pedir un presupuesto mediante un formulario.</p>
<h2>Condiciones de uso</h2>
<p>El acceso al sitio web es gratuito y atribuye la condición de usuario. El usuario se compromete a hacer un uso lícito del sitio y a no enviar por el formulario contenidos falsos, ilícitos o que vulneren derechos de terceros.</p>
<h2>Precios</h2>
<p>Los precios publicados incluyen el IVA y corresponden solo a la mano de obra, salvo que se indique lo contrario. Tienen carácter informativo: el precio que obliga es el del presupuesto que se envía a cada cliente tras su solicitud.</p>
<h2>Propiedad intelectual e industrial</h2>
<p>Los textos, el diseño, el logotipo y el código de este sitio web pertenecen al titular o se utilizan con licencia. No se permite su reproducción, distribución o transformación sin autorización, salvo para el uso personal y privado.</p>
<h2>Responsabilidad</h2>
<p>El titular procura que la información sea exacta y esté actualizada, pero no puede garantizar la ausencia de errores ni la disponibilidad ininterrumpida del sitio web. El titular no responde de los contenidos de sitios web de terceros.</p>
<h2>Protección de datos y cookies</h2>
<p>El tratamiento de los datos personales se describe en la {$enlace( 'privacidad' )} y el uso de cookies, en la {$enlace( 'cookies' )}.</p>
<h2>Ley aplicable</h2>
<p>Este aviso legal se rige por la legislación española. Si el usuario es consumidor, para cualquier controversia serán competentes los juzgados y tribunales de su domicilio.</p>
<p class="legal__fecha">Última actualización: {$fecha}.</p>
HTML,
		'privacidad' => <<<HTML
<h2>Responsable del tratamiento</h2>
<dl class="ficha">
<div><dt>Responsable</dt><dd>{$t['nombre']} (Manitas Vallés)</dd></div>
<div><dt>NIF</dt><dd>{$t['nif']}</dd></div>
<div><dt>Domicilio</dt><dd>{$t['domicilio']}</dd></div>
<div><dt>Correo electrónico</dt><dd>{$correo}</dd></div>
</dl>
<h2>Qué datos tratamos</h2>
<p>Solo los que nos envías por el formulario de presupuesto: nombre, teléfono, correo electrónico si lo indicas, municipio, la descripción del trabajo y las fotos que adjuntes. Evita enviar fotos en las que aparezcan personas o datos que no hagan falta para el presupuesto.</p>
<h2>Para qué los usamos</h2>
<p>Para responder a tu solicitud, preparar el presupuesto y, si lo aceptas, prestar el servicio. No usamos tus datos para enviar publicidad ni para elaborar perfiles, y no tomamos decisiones automatizadas.</p>
<h2>Base jurídica</h2>
<p>La aplicación de medidas precontractuales a petición tuya (artículo 6.1.b del Reglamento (UE) 2016/679, RGPD) y el consentimiento que das al marcar la casilla del formulario (artículo 6.1.a). Puedes retirar el consentimiento en cualquier momento.</p>
<h2>Cuánto tiempo los conservamos</h2>
<p>{$plazo}. Si se presta el servicio, los datos de facturación se conservan durante los plazos que exige la normativa fiscal.</p>
<h2>A quién se comunican</h2>
<p>No cedemos tus datos a terceros, salvo obligación legal. Tienen acceso a ellos, como encargados del tratamiento, los proveedores necesarios para que el sitio web funcione:</p>
<ul>
<li>El proveedor de alojamiento web y de correo: {$hosting}.</li>
<li>Cloudflare, Inc. (Estados Unidos), por el servicio Turnstile, que comprueba que el formulario lo envía una persona y no un programa. Para ello trata datos técnicos del navegador y la dirección IP. Cloudflare está adherida al Marco de Privacidad de Datos UE-EE. UU.</li>
</ul>
<h2>Tus derechos</h2>
<p>Puedes ejercer los derechos de acceso, rectificación, supresión, oposición, limitación del tratamiento y portabilidad escribiendo a {$correo} e indicando qué derecho quieres ejercer. Si consideras que no hemos atendido bien tu petición, puedes presentar una reclamación ante la Agencia Española de Protección de Datos (<a href="https://www.aepd.es" rel="noopener">www.aepd.es</a>).</p>
<h2>Seguridad</h2>
<p>El formulario se envía por conexión cifrada, las fotos adjuntas se comprueban antes de aceptarlas y el acceso a las solicitudes está restringido al titular.</p>
<p class="legal__fecha">Última actualización: {$fecha}.</p>
HTML,
		'cookies' => <<<HTML
<h2>Qué son las cookies</h2>
<p>Las cookies son pequeños archivos que un sitio web guarda en tu navegador. Hay tecnologías parecidas, como el almacenamiento local, que cumplen la misma función.</p>
<h2>Cuáles usa este sitio web</h2>
<p>Este sitio web <strong>no usa cookies de análisis, de publicidad ni de redes sociales</strong>. Solo utiliza lo estrictamente necesario para funcionar, y por eso no hace falta tu consentimiento:</p>
<div class="tabla-desplazable">
<table class="tabla-legal">
<thead><tr><th scope="col">Nombre</th><th scope="col">Quién la pone</th><th scope="col">Para qué</th><th scope="col">Duración</th></tr></thead>
<tbody>
<tr><td><code>mv_aviso_cookies</code> (almacenamiento local)</td><td>Este sitio web</td><td>Recuerda que ya has visto el aviso de cookies.</td><td>Hasta que lo borres</td></tr>
<tr><td>Cookies técnicas de Cloudflare Turnstile</td><td>Cloudflare, Inc.</td><td>Comprobar, solo en la página del formulario, que quien lo envía es una persona. No se usan para hacer seguimiento.</td><td>{$duracion}</td></tr>
</tbody>
</table>
</div>
<h2>Cómo borrarlas o bloquearlas</h2>
<p>Puedes borrar o bloquear las cookies desde la configuración de tu navegador. Si bloqueas las de Cloudflare, es posible que el formulario no se pueda enviar.</p>
<h2>Cambios</h2>
<p>Si en el futuro se añaden cookies de análisis o de terceros, no se cargarán hasta que des tu consentimiento, y esta política se actualizará. El tratamiento de tus datos se describe en la {$enlace( 'privacidad' )}.</p>
<p class="legal__fecha">Última actualización: {$fecha}.</p>
HTML,
	];
}
