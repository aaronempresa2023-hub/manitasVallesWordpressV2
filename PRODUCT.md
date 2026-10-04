# Product

<!-- impeccable:product-schema 1 -->

> Contexto de producto duradero para `impeccable`. El detalle funcional (secciones, campos del formulario, precios, municipios) vive en `SPEC.md` y aquí solo se enlaza.

## Platform

web

## Stack

WordPress 6 (PHP 8.3) con **Elementor Free**, sin widgets Pro. Tema propio en `wp-content/themes/manitas-valles/` para lo que Elementor Free no permite. Entorno local en Docker (`docker-compose.yml`). Decisión del usuario del 2026-10-02.

## Users

Propietarios e inquilinos del Vallès Occidental con una avería o una pequeña instalación pendiente en casa. La mayoría llega desde el móvil, a menudo con prisa, y busca a alguien rápido, profesional y de confianza. Su tarea en la web es comprobar que el servicio cubre lo que necesitan y su municipio, ver cuánto cuesta y pedir presupuesto.

## Product Purpose

Web de **Manitas Vallés**, servicio de reparaciones del hogar, fontanería, electricidad y pequeñas instalaciones a domicilio. Existe para generar **solicitudes de presupuesto por formulario**; el objetivo secundario es mostrar precios cerrados de las tareas más comunes. El éxito se mide en solicitudes recibidas.

## Positioning

Precios cerrados y publicados, con IVA incluido, para las tareas habituales: el cliente sabe lo que va a pagar antes de pedir nada. Precio medio, ligeramente por encima de la media de la zona; al no haber reseñas todavía, se compite por servicio y garantía, no por ser el más barato.

## Operating Context

- Zona de servicio: los 22 municipios del Vallès Occidental (`SPEC.md` sección 7, pendiente de verificar con Idescat).
- **El único canal de contacto es el formulario**, en una página aparte. No se publica teléfono, WhatsApp ni horario.
- El formulario envía un correo al negocio; el cliente puede adjuntar fotos de la avería o del lugar de instalación para ajustar el presupuesto.
- Modelo de cobro mixto: precios cerrados para el catálogo y tarifa por hora para el resto, con mínimo por visita y suplemento de desplazamiento (`SPEC.md` sección 6).

## Capabilities and Constraints

- Secciones de la web: `SPEC.md` sección 4.2. Campos del formulario: sección 4.3.
- Datos de contacto del cliente en el formulario: nombre, teléfono y correo. **Obligatorios solo nombre y teléfono**; el correo es opcional.
- Bilingüe: castellano y catalán, con selector de idioma. Ningún texto queda en una sola lengua.
- Aviso de cookies y páginas legales (Aviso legal, Privacidad, Cookies) conforme a LSSI y RGPD.
- Seguridad del formulario: validación en servidor, captcha, protección CSRF y adjuntos solo de imagen (`CLAUDE.md`, sección "Security").
- Los precios de `SPEC.md` sección 6 no se modifican sin que el usuario lo pida.
- Sin decidir: plugin de formulario, proveedor de captcha, plugin de multilenguaje, correo de destino, dominio y hosting, datos legales del titular (`PROGRESS.md`).

## Brand Commitments

- Nombre: **Manitas Vallés**.
- Logo: no existe; hay que diseñarlo y entregarlo en SVG, acorde con la actividad y con el ámbito del Vallès Occidental.
- La web debe verse moderna y diferenciada, no como una plantilla. Competidores de los que distinguirse: `terrassa.manitasadomicilio.es` y `prontopro.es/sabadell-manitas-a-domicilio`.
- Referencia de diseño aportada por el usuario: `./visune-design` (análisis de visune.io hecho con skillui).
- Paleta: **A · Lima**, elegida por el usuario el 2026-10-02 (blanco, negro `#121212`, acento `#ccff00`). Valores y alternativas en `SPEC.md` sección 9.

## Evidence on Hand

- Catálogo de precios cerrados y condiciones de cobro (`SPEC.md` sección 6).
- Lista de municipios (`SPEC.md` sección 7).
- **No hay** fotografías reales de trabajos ni del profesional: la web se diseña sin fotografía propia por ahora.
- **No hay** reseñas: el negocio es nuevo. No se inventan testimonios, valoraciones, años de experiencia ni número de clientes.
- **No hay** teléfono, WhatsApp, horario, correo ni datos legales publicables. Lo que falte se marca con `[PENDIENTE: ...]`.

## Product Principles

1. **El precio a la vista.** Lo que distingue a esta web es que dice cuánto cuesta; los precios cerrados no se esconden tras un formulario.
2. **Un solo camino: pedir presupuesto.** Todo lleva al formulario; no hay canales que compitan con él.
3. **Pensada para el móvil y la prisa.** Quien llega tiene un problema en casa y poco tiempo.
4. **Nada inventado.** La confianza se gana con datos ciertos; lo que no existe no se publica.
5. **Dos lenguas en igualdad.** Castellano y catalán completos, sin versión de segunda.

## Accessibility & Inclusion

Contraste suficiente, `alt` en las imágenes, `label` en todos los campos, foco visible y controles utilizables con teclado (`CLAUDE.md`, "Code conventions"). No se ha fijado un nivel WCAG concreto.
