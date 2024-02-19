# Makefile for Symfony project

# Composer
COMPOSER = $(shell command -v composer 2> /dev/null)

# Yarn
YARN = $(shell command -v yarn 2> /dev/null)

# Symfony console
console = php bin/console

install: composer-install yarn-install db-create db-migrate ## Install dependencies, create the database, and run migrations

composer-install:
ifdef COMPOSER
	$(COMPOSER) install
else
	@echo "Composer is not installed. Please install Composer: https://getcomposer.org/"
endif

yarn-install:
ifdef YARN
	$(YARN) install
else
	@echo "Yarn is not installed. Please install Yarn: https://yarnpkg.com/"
endif


# Add more rules as needed

.PHONY: install composer-install yarn-install db-create db-migrate

c-c:
	$(console) c:c
	$(console) c:w

create:
	$(console) d:d:c --if-not-exists

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
	vendor/bin/phpstan analyse