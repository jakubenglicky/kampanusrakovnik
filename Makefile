init:
	npm install
	composer install --prefer-dist --no-progress --no-suggest --no-interaction --optimize-autoloader

run-tests:
	php vendor/bin/phpunit --testdox tests

assets:
	npx webpack

generate:
	php src/console generate:actions
	php src/console generate:repertoire

static:
	php vendor/bin/statie generate source --output=public

build:
	make run-tests
	make assets
	make generate
	make static
	php src/console generate:sitemap public

local:
	php vendor/bin/statie generate source --output=public --config=statie_local.yml

dev:
	php -S 0.0.0.0:8000 -t public
