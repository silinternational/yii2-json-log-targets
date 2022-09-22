
test:
	docker-compose run --rm php bash -c "./vendor/bin/behat --strict --stop-on-failure"

behatappend:
	docker-compose run --rm php bash -c "./vendor/bin/behat --append-snippets"

composer:
	docker-compose run --rm php bash -c "composer install --no-scripts --no-plugins"

composerupdate:
	docker-compose run --rm php bash -c "composer update --no-scripts"
