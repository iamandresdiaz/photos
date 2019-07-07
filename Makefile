.PHONY: deps build start back front consume

build: start back front

start: ; docker-compose up -d

back: ; docker-compose exec php-fpm composer install

front: ; docker-compose exec php-fpm npm install

consumer: ; docker-compose exec php-fpm php bin/console app:consume