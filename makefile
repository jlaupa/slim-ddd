# Static            ————————————————————————————————————————————————————————————————————————————————————————————————————
DEFAULT_GOAL 		:= help
SHELL 				= /bin/bash
PROJECT_NAME        = $(shell basename $(shell pwd) | tr '[:upper:]' '[:lower:]')
PHP_STAGED_FILES	= $(shell git diff --name-only --cached --diff-filter=ACMR -- '*.php' | sed 's| |\\ |g')
# Setup             ————————————————————————————————————————————————————————————————————————————————————————————————————
php_container		:= slim-php
docker_compose_exec := docker-compose
compose				:= $(docker_compose_exec) --file .docker/docker-compose.yml --file .docker/docker-compose.override.yml
# End configuration ————————————————————————————————————————————————————————————————————————————————————————————————————

.PHONY: start
start: ## start containers
		$(compose) -p $(PROJECT_NAME) start

.PHONY: stop
stop: ## stop containers
		$(compose) -p $(PROJECT_NAME) stop $(s)

.PHONY: up
up: ## run docker compose up
		$(compose) -p $(PROJECT_NAME) up -d --remove-orphans

.PHONY: console
console: ## go container php
		$(compose) -p $(PROJECT_NAME) exec $(php_container) bash

.PHONY: rebuild
rebuild: ## run rebuild of software
		$(compose) -p $(PROJECT_NAME) up -d --build

.PHONY: build
build: ## run build of software
		$(compose) -p $(PROJECT_NAME) build

.PHONY: composer-update
composer-update:  ## run composer update
		$(compose) -p $(PROJECT_NAME) run --rm $(php_container) sh -lc 'COMPOSER_MEMORY_LIMIT=-1 composer update'

.PHONY: composer-install
composer-install:  ## run composer install
		$(compose) -p $(PROJECT_NAME) run --rm $(php_container) sh -lc 'COMPOSER_MEMORY_LIMIT=-1 composer install'

.PHONY: phpunit
phpunit: ## run phpunit
		$(compose) -p $(PROJECT_NAME) exec -T $(php_container) sh -lc "php vendor/bin/phpunit"

.PHONY: cs-fix
cs-fix: ## run cs fixer
		$(compose) -p $(PROJECT_NAME) exec -T $(php_container) sh -lc "php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php"

.PHONY: phpstan
phpstan: ## run phpstan
		$(compose) -p $(PROJECT_NAME) exec -T $(php_container) sh -lc 'php ./vendor/bin/phpstan analyse src'

.PHONY: help
help: ## list make commands
		@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
