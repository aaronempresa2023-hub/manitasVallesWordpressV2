# Manitas Vallés: especificación del proyecto

> Documento de referencia para Claude Code. Léelo al empezar cada sesión.
> Estado y avance del trabajo: ver `PROGRESS.md`.

## 1. Objetivo

Sitio web profesional y limpio para **Manitas Vallés**, servicio de reparaciones del hogar, fontanería, electricidad y pequeñas instalaciones (manitas / handyman) en el **Vallès Occidental** (Cataluña).

Objetivo principal: que clientes locales (propietarios e inquilinos que necesitan soluciones rápidas, profesionales y de confianza) soliciten **presupuesto mediante formulario**. Objetivo secundario: mostrar **precios cerrados** para las tareas más comunes.

Rol esperado: desarrollador frontend experto y diseñador UI/UX especializado en webs locales de servicios a domicilio de alta conversión.

## 2. Decisiones pendientes (resolver antes de escribir código definitivo)

| # | Tema | Estado |
|---|---|---|
| 1 | **Tecnología: HTML/CSS puro o WordPress.** El brief original pedía ambas cosas (ver sección 5). | **Resuelta (2026-10-02): WordPress + Elementor Free** |
| 2 | Paleta de colores: proponer 3 combinaciones y esperar elección. | **Resuelta (2026-10-02): paleta A · Lima** (ver sección 9) |
| 3 | Correo de destino del formulario. | **Resuelta (2026-10-02)**: el correo del titular (`provision/lib/legales.php`) |
| 4 | Proveedor de captcha (hCaptcha, Cloudflare Turnstile o reCAPTCHA). | **Resuelta (2026-10-02): Cloudflare Turnstile.** Ahora con claves de prueba; faltan las claves reales |
| 8 | Plugin de formulario. | **Resuelta (2026-10-02): Contact Form 7, con Flamingo para guardar los envíos** |
| 5 | Datos legales del titular (nombre/razón social, NIF, domicilio, correo) para Aviso legal. | **Resuelta (2026-10-02)**: están en `provision/lib/legales.php`. Falta confirmar la grafía del nombre y el número de la calle |
| 6 | Testimonios reales (ver sección 4.5). | Pendiente |
| 7 | Dominio y hosting. | Pendiente |

## 3. Flujo de trabajo obligatorio

1. Proponer **3 combinaciones de colores** profesionales adecuadas para un negocio de confianza en el hogar (por ejemplo azul/gris, verde/blanco) y **esperar la elección** del usuario.
2. Con la paleta elegida, crear la estructura de archivos en este directorio.
3. Generar el código completo, limpio, sin saltarse secciones y listo para producción.

## 4. Requisitos funcionales

### 4.1 Diseño y marca

- Moderno y diferenciado: no debe parecer una plantilla preestablecida.
- Competidores de referencia en la zona (analizar para diferenciarse):
  - https://terrassa.manitasadomicilio.es/
  - https://prontopro.es/sabadell-manitas-a-domicilio
- Diseñar un **logo** acorde con la actividad y el alcance (Vallès Occidental).
- Usar el análisis de diseño de la carpeta `./visune-design` (elaborado con skillui).
- Usar los skills disponibles para realizar las tareas.

### 4.2 Secciones de la web

1. **Hero.** Título impactante con propuesta de valor clara, lista de ventajas rápidas (por ejemplo "Rápidos, limpios y con garantía") y botón CTA muy visible: **"Pedir presupuesto"**.
2. **Servicios.** Cuadrícula limpia con iconos o tarjetas: Fontanería, Electricidad, Montaje de muebles, Reparaciones, etc.
3. **Trabajos con precio cerrado.** Tabla de la sección 6.
4. **Cómo trabajamos.** Para otros trabajos, 3 pasos: (1) Nos contactas, (2) Te damos presupuesto, (3) Lo reparamos.
5. **Opiniones / reseñas.** Zona de testimonios que genere confianza. **Solo con reseñas reales** (ver nota abajo).
6. **Contacto.** El formulario está en una **página aparte**, enlazada desde el botón del hero y desde un segundo CTA llamativo en otra zona de la web.

> **Nota sobre reseñas:** el negocio es nuevo. No inventar testimonios (es engañoso y puede constituir publicidad ilícita). Opciones: ocultar la sección hasta tener reseñas reales, o dejar la estructura lista con datos de ejemplo claramente marcados para sustituir.

### 4.3 Formulario de contacto

Envía un correo electrónico a una dirección por determinar. Campos:

| Campo | Tipo | Detalle |
|---|---|---|
| Título | Texto | Asunto breve de la solicitud |
| Tipo de tarea | Desplegable | Electricidad, Fontanería, Bricolaje y montaje, Otros |
| Municipio | Desplegable | Municipios del Vallès Occidental **en orden alfabético** (lista en sección 7) |
| El cliente aporta los materiales | Desplegable | Sí / No |
| Descripción | Área de texto | Placeholder en gris claro: *"Añade la descripción más detallada posible para recibir un presupuesto ajustado"* |
| Fotos | Adjuntar archivos | Aviso debajo: *"Si aportas imágenes de la reparación o del sitio de instalación podremos ajustar mejor el presupuesto"* |

Además: **captcha** obligatorio para evitar bots, casilla de aceptación de la política de privacidad y campos de contacto del cliente: **nombre** (obligatorio), **teléfono** (obligatorio) y **correo** (opcional).

El formulario es el **único canal de contacto**: la web no publica teléfono, WhatsApp ni horario.

## 5. Requisitos técnicos

- HTML5 semántico y CSS3 moderno (Flexbox o CSS Grid).
- **Mobile-first**, totalmente responsivo (la mayoría buscará desde el móvil ante una urgencia).
- Código organizado: las páginas se construyen con Elementor Free; lo que Elementor Free no permite va en el tema propio `wp-content/themes/manitas-valles/` (PHP y CSS limpios).
- **SEO local:** dejar listos los espacios para títulos, metas y etiquetas de encabezado.
- **Bilingüe: castellano y catalán.**
- **Aviso de uso de cookies.**
- **Seguridad:** aplicar todas las medidas necesarias (validación y saneado en servidor, protección CSRF, límites de tamaño y tipo de adjuntos, cabeceras de seguridad, HTTPS, anti-spam con captcha).
- **Cumplimiento legal España/UE:** Aviso legal (LSSI), Política de privacidad (RGPD) y Política de cookies.
- Debe estar en **WordPress**, con **Elementor Free** (sin widgets Pro).

> **Conflicto resuelto (2026-10-02):** el brief pedía a la vez "HTML + CSS puro en `index.html` y `/css`" y "debe estar en WordPress". Se desarrolla en WordPress con Elementor Free y un tema propio de apoyo; no hay versión estática.

## 6. Tabla de precios cerrados (precios con IVA incluido, 21%)

Solo mano de obra. Materiales aparte salvo indicación.

### Electricidad

| Servicio | Precio con IVA |
|---|---|
| Instalación de lámpara o aplique (aportada por el cliente) | 48 € |
| Cambio de enchufe, interruptor o conmutador | 42 € la 1ª unidad, +18 € cada adicional |
| Instalación de ventilador de techo (con punto de luz existente) | 79 € |

### Fontanería

| Servicio | Precio con IVA |
|---|---|
| Cambio de grifo (cocina o baño) | 66 € |
| Reparación del mecanismo de cisterna | 60 € + piezas |
| Sellado con silicona de bañera o ducha | 72 € + silicona |
| Cambio de sifón o desagüe | 66 € |
| Desatasco simple (sifón, muelle, ventosa) | 72 € |

### Bricolaje y montaje

| Servicio | Precio con IVA |
|---|---|
| Montaje de mueble pequeño o mediano (tipo IKEA) | 48 € |
| Montaje de armario (2-3 puertas) | 119,00 € |
| Colgar balda, cuadro o espejo | 39 € la 1ª unidad, +15 € cada adicional |
| Cortinas, estores o rieles | 39 € la 1ª unidad, +22 € cada adicional |
| Cambio de cinta o cordón de persiana | 55 € + cinta |
| Ajuste de puerta que roza | 48 € |
| Cambio de maneta | 39 € la 1ª unidad, +13 € cada adicional |

### Condiciones generales (opcional, confirmar si se muestran en la web)

- Trabajos fuera del catálogo: 42,35 €/hora (IVA incluido).
- Mínimo por visita: 42,35 € (IVA incluido).
- Suplemento de desplazamiento: 0 € hasta 10 km; 9,68 € de 10 a 25 km; 18,15 € a partir de 25 km.
- Materiales: coste real + 10-15% de margen, o aportados por el cliente.

> Los precios con IVA solo pueden publicarse tal cual si la actividad se factura con IVA al 21%. Revisar con el gestor antes de publicar (ver `PROGRESS.md`).

## 7. Municipios del Vallès Occidental (orden alfabético)

Verificar contra el listado oficial (por ejemplo Idescat) antes de publicar:

Badia del Vallès, Barberà del Vallès, Castellar del Vallès, Castellbisbal, Cerdanyola del Vallès, Gallifa, Matadepera, Montcada i Reixac, Palau-solità i Plegamans, Polinyà, Ripollet, Rubí, Sabadell, Sant Cugat del Vallès, Sant Llorenç Savall, Sant Quirze del Vallès, Santa Perpètua de Mogoda, Sentmenat, Terrassa, Ullastrell, Vacarisses, Viladecavalls.

## 8. Criterios de "terminado"

- Todas las secciones de 4.2 presentes y responsivas en móvil, tablet y escritorio.
- Formulario funcional: validación, captcha, adjuntos y envío al correo configurado.
- Contenido completo en castellano y catalán, con selector de idioma.
- Aviso de cookies funcional y páginas legales enlazadas.
- Metas, títulos y encabezados SEO rellenados para las dos lenguas.
- Logo entregado en formato vectorial (SVG).
- Revisión de seguridad básica completada.

## 9. Paleta de colores

Elegida el 2026-10-02: **A · Lima**. Las otras dos quedan anotadas por si más adelante se quiere cambiar; las tres comparten estructura (base neutra, un color de bloque oscuro o saturado y un único acento reservado para el CTA), así que el cambio consiste en sustituir estos valores en los colores globales de Elementor y en las variables CSS del tema.

Comparativa visual: https://claude.ai/artifact/6M2P3ExuZz5h4gpZU8Hvt9

| Rol | **A · Lima (elegida)** | B · Cobalto | C · Pino |
|---|---|---|---|
| Fondo | `#ffffff` | `#f3f5f9` | `#f2f4ee` |
| Superficie (tarjetas) | `#eeede9` | `#ffffff` | `#ffffff` |
| Tinta (texto) | `#121212` | `#0e1a36` | `#10261f` |
| Texto secundario | `#5e5e5e` | `#55607a` | `#55645d` |
| Bloque principal (hero) | `#121212` | `#1d44d8` | `#14503c` |
| Texto sobre el bloque | `#ffffff` | `#ffffff` | `#ffffff` |
| Acento (CTA) | `#ccff00` | `#ffc83a` | `#ff7a3d` |
| Texto sobre el acento | `#121212` | `#0e1a36` | `#10261f` |
| Líneas | `#d6d4ce` | `#dfe4ee` | `#dde2d8` |
| Color de los precios | `#121212` | `#1d44d8` | `#14503c` |

Contrastes medidos (WCAG, mínimo 4,5:1 para texto):

| Par | A · Lima | B · Cobalto | C · Pino |
|---|---|---|---|
| Texto del CTA sobre el acento | 15,9:1 | 11,1:1 | 6,1:1 |
| Blanco sobre el bloque principal | 18,7:1 | 7,3:1 | 9,4:1 |
| Texto secundario sobre el fondo | 6,5:1 | 5,8:1 | 5,6:1 |

Reglas de uso:

- **A:** el lima `#ccff00` solo se usa como relleno con texto `#121212` encima. Nunca como color de texto ni de línea fina sobre blanco (no se lee).
- **B:** el amarillo es el acento del CTA; el azul es el color de bloque y de los precios.
- **C:** el naranja lleva siempre texto oscuro; blanco sobre naranja se queda en 2,6:1 y no es válido.
