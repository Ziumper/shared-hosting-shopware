# Shopware for Shared hosting

## TODOs

* autoload splitting


## Debugging

```
docker compose exec -e XDEBUG_MODE=debug -e XDEBUG_CONFIG="start_with_request=trigger idekey=netbeans client_host=host.docker.internal client_port=9003" shop php /var/www/html/test.php
```