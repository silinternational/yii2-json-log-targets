
test:
	bash -c "./vendor/bin/behat --strict --stop-on-failure"

behatappend:
	bash -c "./vendor/bin/behat --append-snippets"

composer:
	bash -c "composer update --no-scripts --ignore-platform-reqs"
