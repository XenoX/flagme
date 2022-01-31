phpcs:
	./vendor/bin/phpcs --standard=PSR12 src/

phpstan:
	./vendor/bin/phpstan analyse -c phpstan.neon

tu:
	./vendor/bin/phpunit --testsuite unit

tf:
	./vendor/bin/phpunit --testsuite functionnal

tu-coverage:
	./vendor/bin/phpunit --coverage-html coverage/

tf-coverage:
	./vendor/bin/phpunit --coverage-html coverage/ --testsuite functionnal
