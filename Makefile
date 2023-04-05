init-php:
	composer install --prefer-dist --no-progress --no-suggest --no-interaction --optimize-autoloader

init-node:
	npm install

run-tests:
	php vendor/bin/phpunit --testdox tests

assets:
	./node_modules/webpack-cli/bin/cli.js

generate:
	php src/console generate:actions
	php src/console generate:repertoire

static:
	php vendor/bin/statie generate source --output=public

build-web:
	make run-tests
	make generate
	make static
	php src/console generate:sitemap public
	cp public/404/index.html public/404.html

build-assets:
	make assets

local:
	php vendor/bin/statie generate source --output=public --config=statie_local.yml

dev:
	php -S 0.0.0.0:8000 -t public
