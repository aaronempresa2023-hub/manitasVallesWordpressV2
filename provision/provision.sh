#!/bin/sh
# Aprovisiona WordPress desde cero (idempotente). Se ejecuta dentro del contenedor wp-cli.
set -eu

cd /var/www/html

echo "▸ Esperando a que WordPress copie sus archivos…"
until [ -f wp-config.php ]; do sleep 2; done
until wp db query "SELECT 1" >/dev/null 2>&1; do sleep 3; done

if ! wp core is-installed 2>/dev/null; then
  echo "▸ Instalando WordPress…"
  wp core install \
    --url="$WP_URL" \
    --title="Manitas Vallés" \
    --admin_user="$WP_ADMIN_USER" \
    --admin_password="$WP_ADMIN_PASSWORD" \
    --admin_email="$WP_ADMIN_EMAIL" \
    --skip-email
fi

# La dirección del sitio sigue a WP_URL. Si cambia (p. ej. de localhost a la IP de la máquina), se actualiza y se
# reescriben las URL ya guardadas para que nada apunte a la anterior.
URL_ACTUAL="$(wp option get siteurl)"
if [ "$URL_ACTUAL" != "$WP_URL" ]; then
  echo "▸ Cambiando la dirección del sitio: $URL_ACTUAL → $WP_URL"
  wp option update home "$WP_URL"
  wp option update siteurl "$WP_URL"
  wp search-replace "$URL_ACTUAL" "$WP_URL" --all-tables --skip-columns=guid 2>&1 | tail -1
fi

echo "▸ Idioma español…"
wp language core install es_ES --activate 2>&1 | tail -1 || true

echo "▸ Plugins: Elementor (Free), Contact Form 7 y Flamingo…"
# Versión probada. Con ELEMENTOR_VERSION=latest se instala la última publicada.
instalar_plugin() {
  slug="$1"; version="$2"
  if [ "$version" = "latest" ]; then
    wp plugin install "$slug" --activate 2>&1 | tail -1
  elif [ "$(wp plugin get "$slug" --field=version 2>/dev/null || true)" != "$version" ]; then
    wp plugin install "$slug" --version="$version" --force --activate 2>&1 | tail -1
  else
    wp plugin activate "$slug" 2>&1 | tail -1
  fi
}
instalar_plugin elementor "${ELEMENTOR_VERSION:-4.2.4}"
instalar_plugin contact-form-7 "${CF7_VERSION:-6.1.7}"
instalar_plugin flamingo "${FLAMINGO_VERSION:-2.6.4}"
wp language plugin install elementor es_ES 2>&1 | tail -1 || true
wp language plugin install contact-form-7 es_ES ca 2>&1 | tail -1 || true
wp language plugin install flamingo es_ES 2>&1 | tail -1 || true

echo "▸ Tema manitas-valles…"
wp theme activate manitas-valles

# Elementor: sin los colores/tipografías por defecto (la paleta y las fuentes salen del Kit de la web).
wp option update elementor_disable_color_schemes yes
wp option update elementor_disable_typography_schemes yes
wp option update elementor_load_fa4_shim ''
wp option update elementor_css_print_method external

echo "▸ Construyendo las páginas con Elementor…"
wp eval-file /provision/setup.php --user="$WP_ADMIN_USER"

wp elementor flush-css 2>&1 | tail -1 || true
wp rewrite structure '/%postname%/' --hard 2>&1 | tail -1 || true
wp rewrite flush 2>&1 | tail -1 || true

echo "✔ Listo: $WP_URL  (admin: $WP_ADMIN_USER)"
