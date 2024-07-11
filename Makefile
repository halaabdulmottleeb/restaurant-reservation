build:
	docker compose down
	docker compose build --no-cache
	docker compose up -d

db:
	@if [ ! -f .env ]; then cp .env.example .env; fi
	docker-compose exec app php artisan migrate
	docker-compose exec app php artisan migrate:fresh --seed
	docker-compose exec app php artisan passport:install
