.PHONY: build start backend frontend end consumer

build: start frontend backend

start: ; docker-compose up -d

backend: ; docker-compose exec php-fpm composer install -o

frontend: ; docker-compose exec php-fpm npm install && npm run build

consumer: ; docker-compose exec php-fpm php bin/console app:consume

end: ; docker-compose down