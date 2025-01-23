#!/bin/bash

docker-compose up -d --build
docker exec laravel_app composer install
docker exec laravel_app cp .env.example .env
sudo chmod -R 777 olx-parser-app/
docker exec laravel_app php artisan key:generate --ansi
docker exec laravel_app php artisan migrate