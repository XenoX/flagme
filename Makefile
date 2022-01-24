phpcs:
	./vendor/bin/phpcs --standard=PSR12 src/

phpstan:
	./vendor/bin/phpstan analyse -c phpstan.neon 

tu:
	./vendor/bin/phpunit

tu-coverage:
	./vendor/bin/phpunit --coverage-html coverage/
