/**
 * La cinta de progreso: se extiende con el desplazamiento y su tope nombra la sección en la que se está.
 * Sin JavaScript o con movimiento reducido la cinta queda fija y completa (ver site.css).
 */
( function () {
	const flexo = document.querySelector( '.flexo' );
	if ( ! flexo || window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}

	const etiqueta = flexo.querySelector( '.flexo__seccion' );
	const secciones = Array.from( document.querySelectorAll( 'main section' ) )
		.map( ( seccion ) => {
			const titulo = seccion.querySelector( 'h2' );
			return titulo ? { seccion, nombre: titulo.textContent.trim() } : null;
		} )
		.filter( Boolean );

	let pendiente = false;

	function medir() {
		pendiente = false;

		const recorrido = document.documentElement.scrollHeight - window.innerHeight;
		const p = recorrido > 0 ? Math.min( 1, Math.max( 0, window.scrollY / recorrido ) ) : 1;
		flexo.style.setProperty( '--p', p.toFixed( 4 ) );

		// La sección actual es la última cuyo inicio ya ha pasado el 40 % superior de la ventana.
		let actual = '';
		for ( const { seccion, nombre } of secciones ) {
			if ( seccion.getBoundingClientRect().top <= window.innerHeight * 0.4 ) {
				actual = nombre;
			}
		}
		if ( actual ) {
			etiqueta.textContent = actual;
		}
		// Cerca del borde derecho la etiqueta taparía la cabecera al volver arriba; cerca del izquierdo no cabe.
		etiqueta.classList.toggle( 'es-visible', Boolean( actual ) && p > 0.12 );
	}

	function pedir() {
		if ( ! pendiente ) {
			pendiente = true;
			window.requestAnimationFrame( medir );
		}
	}

	window.addEventListener( 'scroll', pedir, { passive: true } );
	window.addEventListener( 'resize', pedir );
	medir();
} )();

/**
 * Aviso de cookies: se muestra hasta que se cierra. La elección se recuerda en el almacenamiento local
 * (no en una cookie). Si el almacenamiento no está disponible, el aviso vuelve a salir en cada visita.
 */
( function () {
	const aviso = document.querySelector( '.aviso-cookies' );
	if ( ! aviso ) {
		return;
	}
	const CLAVE = 'mv_aviso_cookies';
	let visto = false;
	try {
		visto = window.localStorage.getItem( CLAVE ) === '1';
	} catch ( e ) {}
	if ( visto ) {
		return;
	}
	aviso.hidden = false;
	aviso.querySelector( '.aviso-cookies__cerrar' ).addEventListener( 'click', function () {
		aviso.hidden = true;
		try {
			window.localStorage.setItem( CLAVE, '1' );
		} catch ( e ) {}
	} );
} )();
