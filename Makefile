.PHONY: deps build start

build: env start

env: ; docker-compose build --no-cache

start: ; docker-compose up -d