# Makefile for Symfony project

# Composer
composer = $(shell command -v composer 2> /dev/null)

# Yarn
yarn = $(shell command -v yarn 2> /dev/null)

# Symfony console
console= php bin/console

install: composer-install yarn-install db-create db-migrate ## Install dependencies, create the database, and run migrations

composer-install:
ifdef composer
	$(composer) install
else
	@echo "Composer is not installed. Please install Composer: https://getcomposer.org/"
endif

yarn-install:
ifdef yarn
	$(yarn) install
else
	@echo "Yarn is not installed. Please install Yarn: https://yarnpkg.com/"
endif

db-migrate:
	$(console) doctrine:migrations:migrate --no-interaction

# Add more rules as needed

.PHONY: install composer-install yarn-install db-create db-migrate

db-create-and-grant:
	php bin/console doctrine:database:create --if-not-exists
	php bin/console doctrine:schema:create
	php bin/console doctrine:schema:update --force
	psql -h 127.0.0.1 -U app -d app -c "GRANT ALL PRIVILEGES ON DATABASE app TO app;"

drop:
	$(console) d:d:d --force --if-exists

migrate:
	$(console) d:m:m --no-interaction

reset:
	$(c-c)
	$(console) d:d:d --force --if-exists
	$(console) d:d:c --if-not-exists
	$(console) d:m:m --no-interaction

phpstan:
	$(c-c)
	vendor/bin/phpstan analyse

controller:
	$(console) make:controller

crud:
	$(console) make:crud
c-c:
	$(console) c:c
	$(console) c:w

up:
	$(c-c)
	symfony server:start -d
	yarn encore dev --watch

stop:
	symfony server:stop

encore:
	yarn encore dev --watch