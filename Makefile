docker-up:
	docker compose up -d

docker-build:
	docker compose build

docker-down:
	docker compose down --remove-orphans

cli:
	docker compose exec -it php bash

chown:
	sudo chown -R $USER:$USER database/migrations
