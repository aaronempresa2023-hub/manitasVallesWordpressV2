<?php
/**
 * Precios de Manitas Vallés (IVA incluido, 21%).
 *
 * Modifica SOLO este fichero para cambiar cualquier precio. textos.php lo usa; si añades un precio
 * nuevo aquí añade también la clave correspondiente en textos.php.
 *
 * Formato: número con coma decimal si procede + espacio + símbolo "€".
 */

const MV_P = [
	// ── Electricidad ─────────────────────────────────────────────────────────
	'lampara'        => '48 €',    // Instalación de lámpara o aplique
	'enchufe'        => '42 €',    // Cambio de enchufe, interruptor o conmutador (1.ª unidad)
	'enchufe_adic'   => '18 €',    // Cada unidad adicional de enchufe/interruptor
	'ventilador'     => '79 €',    // Instalación de ventilador de techo

	// ── Fontanería ────────────────────────────────────────────────────────────
	'grifo'          => '66 €',    // Cambio de grifo
	'cisterna'       => '60 €',    // Reparación del mecanismo de cisterna
	'silicona'       => '72 €',    // Sellado con silicona de bañera o ducha
	'sifon'          => '66 €',    // Cambio de sifón o desagüe
	'desatasco'      => '72 €',    // Desatasco simple

	// ── Bricolaje y montaje ───────────────────────────────────────────────────
	'mueble'         => '48 €',    // Montaje de mueble pequeño o mediano
	'armario'        => '119 €', // Montaje de armario 2-3 puertas
	'balda'          => '39 €',    // Colgar balda, cuadro o espejo (1.ª unidad)
	'balda_adic'     => '15 €',    // Cada unidad adicional de balda/cuadro/espejo
	'cortinas'       => '39 €',    // Cortinas, estores o rieles (1.ª unidad)
	'cortinas_adic'  => '22 €',    // Cada unidad adicional de cortina/estor
	'persiana'       => '55 €',    // Cambio de cinta o cordón de persiana
	'puerta'         => '48 €',    // Ajuste de puerta que roza
	'maneta'         => '39 €',    // Cambio de maneta (1.ª unidad)
	'maneta_adic'    => '13 €',    // Cada unidad adicional de maneta

	// ── Condiciones generales ─────────────────────────────────────────────────
	'hora'           => '42 €', // Trabajos fuera del catálogo (precio por hora)
	'minimo'         => '42 €', // Mínimo por visita
	'km_10_25'       => '9 €',  // Suplemento de desplazamiento de 10 a 25 km
	'km_mas_25'      => '18 €', // Suplemento de desplazamiento a partir de 25 km
];
