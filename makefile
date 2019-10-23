#!/usr/bin/make

up: ## up
	docker-compose up

migrate: ## migrate
	docker-compose exec --user=$GID -it php7 bash -c "php artisan migrate"

seed: ## Perform seeds
	docker-compose exec php7 php artisan db:seed

tinker: ## interative terminal
	docker-compose exec php7 bash -c "php artisan tinker"
