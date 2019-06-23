.PHONY: deps build start back front consume

build: env start back front

env: ; docker-compose build --no-cache

start: ; docker-compose up -d

back: ; docker-compose exec php-fpm composer install

front: ; docker-compose exec php-fpm npm install

consume: ; docker-compose exec php-fpm php bin/console app:consume