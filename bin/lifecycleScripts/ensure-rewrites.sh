#!/bin/sh
set -eu

# wp-env does not always create .htaccess for an existing installation. The
# editor needs pretty REST routes, so restore only the WordPress marker block.
cd /var/www/html
if ! grep -q '^php_value post_max_size 2G$' .htaccess 2>/dev/null; then
	cat >> .htaccess <<'EOF'
php_value post_max_size 2G
php_value upload_max_filesize 2G
php_value memory_limit 2G
EOF
fi

if ! grep -q '^# BEGIN WordPress$' .htaccess 2>/dev/null; then
	cat >> .htaccess <<'EOF'
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
EOF
fi
