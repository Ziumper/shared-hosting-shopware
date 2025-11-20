# Shopware for Shared hosting

## Optimzations made
* autoload splitting [x]
* autoload static splitting [x]
* plugin for disabling notofications in admin panel - extend notification.service.js inside administration panel [x]
* disabled queue message probably inside symfony config [x]
* don't upload node_modules inside 'administration' and 'storefront' they are not needed after compilation [ ]

## Folders to deploy:

```
- config
- custom
- files
- public
- var
- vendor
```

## Debugging

```
docker compose exec -e XDEBUG_MODE=debug -e XDEBUG_CONFIG="start_with_request=trigger idekey=netbeans client_host=host.docker.internal client_port=9003" shop php /var/www/html/test.php
```
