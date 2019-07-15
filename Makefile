build: deps start frontend backend

deps: ; docker-compose build --no-cache

start: ; docker-compose up -d

backend: ; docker-compose exec php-fpm composer install -o

frontend: ; docker-compose exec php-fpm npm install && npm run build

down: ; docker-compose down

consumer: ; docker-compose exec php-fpm php bin/console app:consume

migration: ; docker-compose exec php-fpm php bin/console make:migration

migrate: ; docker-compose exec php-fpm php bin/console doctrine:migrations:migrate

profile: ; docker exec photos-blackfire blackfire curl --proxy http://photos-nginx:80/ http://www-local.photos.io/