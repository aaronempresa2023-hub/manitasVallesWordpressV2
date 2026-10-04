---
version: 1
slug: "provision-lib-home-php"
primary_target: "provision/lib/home.php"
related_targets: ["wp-content/themes/manitas-valles/assets/css/site.css"]
---

# Portada (Inicio) · Manitas Vallés

Alcance: página de inicio en castellano y catalán, construida con Elementor Free y el tema `manitas-valles`. Modo: Persuade.

Visitante: particular del Vallès Occidental con una avería o un montaje pendiente, casi siempre desde el móvil. Tarea: ver que el trabajo está cubierto, cuánto cuesta y pedir presupuesto. Acción única: "Pedir presupuesto", que lleva a la página del formulario. Prueba disponible: precios cerrados con IVA y lista de municipios. Sin fotos, reseñas ni teléfono.

Restricciones: paleta A · Lima fijada por el usuario (`SPEC.md` sección 9); estructura de la referencia `visune-design` (bloques muy redondeados, botones en píldora, un solo acento); solo widgets de Elementor Free; nada inventado.

Sin resolver: plugin de formulario, captcha, multilenguaje, sección de opiniones mientras no haya reseñas.

## Direction contract

THESIS: El precio es una medida que se lee antes de preguntar. Rechaza la portada del sector: foto de archivo de un operario, cuadrícula de iconos y precios escondidos tras el formulario.

OWN-WORLD: La hoja de un flexómetro. Bandas lima `#ccff00` con marcas negras a paso fijo (marca larga cada cinco) y cifras condensadas de ancho constante; bloques negros `#121212` de radio grande sobre blanco; controles en píldora; tinta plana, sin degradados ni sombras; una sola familia grotesca en todo. Donaciones: posiciones de cifra fijas para cada precio (contador nixie); una palabra enorme que no encoge en móvil (funda TDR); solo tintas planas superpuestas (serigrafía).

STORY: Entiende que hay trabajos con precio cerrado en su municipio; cree que no habrá sorpresas; pide presupuesto.

FIRST VIEWPORT: Móvil 390. Barra con el nombre y ES · CA. Bloque negro redondeado, unos dos tercios del alto, con el titular en tres líneas y el botón lima en píldora abajo a la izquierda. Pegada debajo, a sangre, la cinta lima con sus marcas y tres precios como lecturas en posiciones fijas con su trabajo debajo. Escritorio: titular a la izquierda en siete columnas, cinta horizontal a todo el ancho.

SIGNATURE: La cinta se extiende con el desplazamiento y marca en qué sección se está; con movimiento reducido queda fija y completa.

FORM: Flexómetro, candidato 6 de 7 de la lista propia; clave de tirada 90ef1f3a. Sin generación de imágenes: construcción dirigida por código.

FINISH: unreviewed and undocumented is unfinished; this build ends with the finish review, the verdict, DESIGN.md, and every shipping raster carrying its provenance
