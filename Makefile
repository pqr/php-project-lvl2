install:
	composer install

lint:
	composer run-script phpcs -- --standard=PSR12 src bin

test:
	composer run-script phpunit

test-with-coverage:
	composer run-script phpunit -- --coverage-clover build/logs/clover.xml
