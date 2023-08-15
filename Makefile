test:
	docker compose exec php php artisan test
seed:
	docker compose exec php php artisan db:seed
migrate:
	docker compose exec php php artisan migrate
down:
	docker compose down --remove-orphans
down-v:
	docker compose down --remove-orphans --volumes
restart:
	@make down
	@make up
up:
	docker compose up -d