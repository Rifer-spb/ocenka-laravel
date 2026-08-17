docker-up:
	docker compose up -d --build

docker-build:
	docker compose build

docker-down:
	docker compose down --remove-orphans

cli:
	docker compose exec -it php bash

chown:
	sudo chown -R $USER:$USER database/migrations

redis-cli:
	 docker exec -it ocenka_laravel_redis redis-cli

tinker:
	docker exec -it ocenka_laravel_php php artisan tinker

test:
	docker exec -it ocenka_laravel_php php artisan test
