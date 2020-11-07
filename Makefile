init:
	npm install

assets:
	npx webpack

generate:
	php src/console generate:actions
	php src/console generate:repertoire

static:
	php vendor/bin/statie generate source --output=public

build:
	make assets
	make generate
	make static

local:
	php -S 0.0.0.0:8000 -t public
