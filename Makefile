.PHONY: deps build start

build: deps start

deps: ; composer install

start: ; docker-compose up -d