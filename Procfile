release: php bin/console doctrine:migration:migrate --no-interaction && php bin/console app:create-user XenoX
web: heroku-php-nginx -C nginx_app.conf public/