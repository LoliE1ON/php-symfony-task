## Outputs this help screen
help:
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## Refresh dev database
dev-database-refresh:
	APP_ENV=dev php bin/console doctrine:database:drop --force --if-exists
	APP_ENV=dev php bin/console doctrine:database:create
	APP_ENV=dev php bin/console doctrine:migrations:migrate -n

jwt-generate:
	php bin/console lexik:jwt:generate-keypair

lint:
	php -d memory_limit=512M ./vendor/bin/phpcs
	php -d memory_limit=512M ./vendor/bin/phpstan