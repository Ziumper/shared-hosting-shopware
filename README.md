# Shopware for Shared hosting

## TODOs

* autoload splitting [x]
* autoload static splitting [x]
* plugin for disabling notofications in admin panel - extend notification.service.js inside administration panel [x]
* disable queue message probably inside symfony config
* sql lite adapter 
* deployment jobs


## Debugging

```
docker compose exec -e XDEBUG_MODE=debug -e XDEBUG_CONFIG="start_with_request=trigger idekey=netbeans client_host=host.docker.internal client_port=9003" shop php /var/www/html/test.php
```
