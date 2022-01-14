phpcs:
	./vendor/bin/phpcs --standard=PSR12 src/

phpstan:
	./vendor/bin/phpstan analyse -c phpstan.neon 
