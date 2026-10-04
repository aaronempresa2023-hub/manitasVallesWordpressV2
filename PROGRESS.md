# PROGRESS

Estado del proyecto `manitasVallesWordpressV2`. Se lee al empezar cada sesión y se actualiza al terminar cada tarea importante (ver `CLAUDE.md`). Qué construir: ver `SPEC.md`.

Última actualización: 2026-10-04

## Estado actual

Entorno WordPress local funcionando con Elementor Free. `SPEC.md`, el estudio de tarifas y `PRODUCT.md` están hechos. La paleta (A · Lima) y la dirección visual (Flexómetro) están elegidas, y **la portada y el formulario de presupuesto están construidos en castellano y catalán**. El captcha usa claves de prueba. Las páginas legales y el aviso de cookies están hechos, con varios datos marcados como pendientes. Faltan el logo y la revisión final del diseño con `DESIGN.md`.

## Decisiones tomadas

### Técnicas
- La web es un **WordPress con Elementor Free** (sin widgets Pro). Esto resuelve el conflicto "HTML puro vs WordPress" de `SPEC.md`: se desarrolla en WordPress.
- El proyecto es **completamente nuevo**: no se reutilizan `PRODUCT.md` ni `DESIGN.md` de `manitasVallesWordpress`.
- Convive con los otros proyectos de esta máquina, por eso usa los puertos 8082 (web) y 8026 (Mailpit). `manitasVallesWordpress` usa 8081/8025 y `manitasVallesV1` usa 8080.

### Técnicas del formulario
- **Contact Form 7 6.1.7** para el formulario, **Cloudflare Turnstile** como captcha y **Flamingo 2.6.4** para guardar los envíos en el panel de WordPress.
- Las claves de Turnstile se pasan por las variables `TURNSTILE_SITEKEY` y `TURNSTILE_SECRET` (en `.env`, que no se versiona). Sin definir se usan las claves de prueba de Cloudflare, que siempre aprueban: **no protegen de nada y no valen para producción**.
- Fotos: tres campos opcionales, solo JPG, PNG o WebP, hasta 5 MB cada uno. El tema comprueba el tipo real del archivo.
- Límite de 5 envíos por hora desde la misma IP (en el tema).
- Las solicitudes se envían al correo del titular y se conservan **doce meses**: una tarea diaria del tema borra de Flamingo lo que supere ese plazo.
- Los datos del titular (nombre, NIF, domicilio, correo) se quedan en el fichero versionado `provision/lib/legales.php`, por decisión del usuario.
- Contact Form 7 y el script de Turnstile solo se cargan en las páginas del formulario.

### De negocio y precios
- Precios publicados **con IVA incluido (21%)**: el cliente particular no deduce el IVA y lo que cuenta es el precio final. Tabla completa en `SPEC.md` sección 6.
- Modelo de cobro **mixto**: precios cerrados para las tareas del catálogo y 42,35 €/h (IVA incl.) para lo demás. Mínimo por visita de 42,35 €. Suplemento de desplazamiento por distancia (ver `SPEC.md`).
- Posicionamiento: **precio medio, ligeramente por encima de la media** del Vallès Occidental (la media de mercado ronda 31-34 €/h sin IVA). Sin reseñas todavía, se compite por servicio y garantía.
- Materiales: los compra el profesional (coste real + 10-15%) o los aporta el cliente.
- **No inventar reseñas**: la sección de opiniones solo se publica con testimonios reales.
- **El único canal de contacto es el formulario**: no se publica teléfono, WhatsApp ni horario.
- Datos de contacto del cliente en el formulario: nombre y teléfono obligatorios, correo opcional.
- La web se diseña **sin fotografías reales** por ahora.

### De diseño
- **Dirección visual: Flexómetro.** La cinta métrica como sistema: bandas lima con marcas negras a paso fijo, cifras condensadas de ancho constante, bloques negros muy redondeados, botones en píldora, tinta plana. El contrato está en `.impeccable/surfaces/provision-lib-home-php.md`.
- **Tipografía: Bricolage Grotesque** (variable, licencia OFL), autoalojada en el tema. Una sola familia para todo.
- **Bilingüe sin plugin**: cada página existe dos veces (castellano en `/`, catalán en `/ca/`) y el tema pone el atributo `lang`, los `hreflang` y las metas por página. Es una propuesta: si se prefiere Polylang o TranslatePress hay que decirlo antes de seguir añadiendo páginas.
- Las páginas se generan desde `provision/lib/home.php` y `provision/lib/textos.php`; **relanzar el aprovisionamiento borra los cambios hechos a mano en Elementor** sobre ellas.
- La sección de opiniones **no se publica** mientras no haya reseñas reales.
- **Paleta elegida: A · Lima** (blanco, negro `#121212`, acento `#ccff00`). Las alternativas B · Cobalto y C · Pino quedan anotadas con todos sus valores en `SPEC.md` sección 9 por si se quiere cambiar más adelante.
- `./visune-design` es una referencia (análisis de visune.io), no el sistema de diseño del proyecto: se toma su estructura (base neutra, bloques muy redondeados, botones en píldora, un solo acento), no su paleta ni sus fuentes. La tipografía Saans es de pago y no se usa sin licencia.

## Hecho

- 2026-10-04 · **Logo SVG integrado** en la cabecera (fichero `Logo/code.html`). Sustituye el signo de cinta anterior. Estilos de `.marca` actualizados en `site.css`.
- 2026-10-04 · **Precios centralizados** en `provision/lib/precios.php` (`MV_P`). `textos.php` ya no tiene precios en duro: los dos idiomas usan las mismas constantes. Para cambiar un precio: editar solo `precios.php`. `SPEC.md` sección 6 actualizada.
- 2026-10-04 · **Sección "Si tu trabajo no está en la lista" eliminada** de la página de precios. La columna lateral de condiciones generales (`precios__fuera`) desaparece de la maquetación.

- 2026-10-02 · **Páginas legales** en castellano y catalán (Aviso legal, Política de privacidad, Política de cookies), enlazadas desde el pie y desde la casilla del formulario. Los datos del titular están en `provision/lib/legales.php`.
- 2026-10-02 · **Aviso de cookies** en el tema: informativo, porque la web solo usa lo estrictamente necesario (comprobado: no pone ninguna cookie al visitante). Recuerda el cierre en el almacenamiento local.
- 2026-10-02 · **Formulario de presupuesto** en `/presupuesto/` y `/ca/pressupost/` con todos los campos de `SPEC.md` 4.3, captcha Turnstile (claves de prueba), adjuntos de fotos y guardado en Flamingo. Probado: envío válido con foto (llega a Mailpit con el adjunto), archivo falso con extensión .jpg (rechazado), campos obligatorios y privacidad (rechazado con mensajes), envío sin captcha (rechazado) y límite de envíos (bloquea a partir del sexto).
- 2026-10-02 · **Portada construida** en castellano (`/`) y catalán (`/ca/`): cabecera, portada con la cinta de precios, servicios, tablas de precios cerrados con las condiciones, cómo trabajamos, municipios, segundo CTA y pie. Revisada en móvil (390 px) y escritorio (1440 px).
- 2026-10-02 · Página "Pedir presupuesto" (`/presupuesto/` y `/ca/pressupost/`) creada como destino de los botones, con el formulario marcado como pendiente.
- 2026-10-02 · Tema: tipografía autoalojada, estilos por clase, cinta de progreso al desplazarse, SEO por página (título, descripción, Open Graph, `hreflang`, datos estructurados) y enlace de saltar al contenido.
- 2026-10-02 · `PRODUCT.md` escrito (contexto de producto para `impeccable`; enlaza a `SPEC.md` en vez de duplicarlo).
- 2026-10-02 · `SPEC.md` y `CLAUDE.md` actualizados: tecnología resuelta (WordPress + Elementor Free), estructura de tema en lugar de `index.html` + `/css`, campos de contacto del formulario y alcance de las convenciones de código con Elementor.
- 2026-10-02 · Propuesta de 3 paletas (A Lima, B Cobalto, C Pino) publicada como artifact privado para comparar.
- 2026-10-02 · Estudio de tarifas del Vallès Occidental y definición de precios cerrados y condiciones de cobro.
- 2026-10-02 · Redacción de `SPEC.md` (a partir del prompt inicial) y fusión de `CLAUDE.md` con la plantilla base.
- 2026-10-02 · Revisión de la plantilla base: 15 skills del repo completas, 4 subagentes `impeccable-*`, motor de `impeccable` v0.1.5 y hooks funcionando en Linux, `graphify` instalado globalmente.
- 2026-10-02 · Entorno Docker: `docker-compose.yml` (WordPress 6 / PHP 8.3, MariaDB 11, Mailpit, servicio `setup` con WP-CLI) y `provision/provision.sh` (instala WordPress en español, Elementor Free 4.2.4, activa el tema y los enlaces permanentes; idempotente).
- 2026-10-02 · Tema mínimo provisional en `wp-content/themes/manitas-valles/` (`style.css`, `index.php`, `functions.php`), solo para que WordPress lo reconozca.
- 2026-10-02 · `dev/mu-plugins/mailpit-dev.php` (correo de desarrollo a Mailpit), copiado de `manitasVallesWordpress`.

## En curso

- Cierre del diseño de la portada: falta la revisión final de `impeccable` y escribir `DESIGN.md` a partir de lo construido.

## Pendiente

### Bloquea el diseño
- Revisión final de la portada y `DESIGN.md` (ver "En curso").
- Confirmar si las condiciones generales de cobro (precio por hora, mínimo, desplazamiento, materiales) se muestran en la web: ahora se muestran.
- Confirmar la solución bilingüe sin plugin.
- Municipios: la lista de `SPEC.md` tiene 22 y creo que falta Rellinars (el Vallès Occidental tiene 23); verificar con Idescat.

### Decisiones técnicas
- **Claves reales de Turnstile**: crearlas en la cuenta de Cloudflare del usuario cuando haya dominio y ponerlas en `.env`.
- Plugin de multilenguaje para castellano y catalán (por ejemplo Polylang o TranslatePress).
- Dominio y hosting.

### Negocio y legal (fuera del código, pero afectan a la web)
- Consultar con un gestor: alta de autónomo (RETA y/o Hacienda 036/037), IVA aplicable (21% o 10%) y seguro de responsabilidad civil.
- Confirmar que los precios publicados "con IVA" son coherentes con la forma de facturar.
- Confirmar los datos del titular: grafía del nombre (ahora "Aaron Sanchez Garrido", sin tilde) y número de la calle (ahora "Calle Francia" sin número).
- Datos que faltan en los textos legales (marcados en la web): dominio definitivo, proveedor de alojamiento y duración de las cookies de Turnstile.
- Que un gestor o abogado revise los tres textos legales antes de publicar.
- Decidir qué hacer con la sección de reseñas hasta tener opiniones reales.
- Verificar la lista de municipios del Vallès Occidental contra el listado oficial (Idescat).

### Desarrollo
- Logo (SVG)
- Opiniones (cuando haya reseñas reales)
- Cabeceras de seguridad (CSP, X-Content-Type-Options, Referrer-Policy)
- Favicon e imagen para compartir (Open Graph)
- Revisión de seguridad
- Pruebas en móvil, tablet y escritorio

### Mantenimiento del repo
- Crear `.env.example`: los permisos de Claude Code bloquean escribir ese fichero, hay que crearlo a mano (valores por defecto en `docker-compose.yml`).
- Actualizar `SkillsIncluidas.txt`: aún dice binario `windows-x64` y rutas `C:\Users\...`.
- Primer commit: nada de lo anterior está en git todavía.

## Cómo arrancar

```sh
docker compose up -d
docker compose logs -f setup   # aprovisionamiento
```

| Qué | Dónde |
|---|---|
| Web | http://192.168.1.109:8082 |
| Administración | http://192.168.1.109:8082/wp-admin (`admin` / `admin`) |
| Mailpit | http://192.168.1.109:8026 |
