UNAME := $(shell uname -s)
COMPOSE=docker-compose
RUN=$(COMPOSE) run --rm tools
COMPOSER=composer
SYMFONY=bin/console

all: configure start install

configure:
	@touch ./data/.bash_history
	@echo "WWW_DATA_UID=`id -u`\nWWW_DATA_GUID=`id -g`\nLOCAL_IP=`ip route get 1 | awk '{print $$NF;exit}'`" | tee docker/settings/env_access > /dev/null
	$(COMPOSE) build

start:
	$(COMPOSE) up -d

rebuild: configure start

install: composer

composer:
	$(RUN) $(COMPOSER) install --no-interaction --prefer-dist

fixtures:
	$(RUN) "$(SYMFONY) doctrine:database:drop --force ; $(SYMFONY) do:da:cr ; $(SYMFONY) doctrine:migration:migrate --no-interaction ;

cs:
	$(RUN) bin/php-cs-fixer fix
