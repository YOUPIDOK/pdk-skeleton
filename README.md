# Symfony
> This project is Symfony Web app skeleton
## Documentation
### Requirement
* PHP 8.1
* Node 16
### Dependencies
* Symfony 6.1
* Easy admin 4.3

### Install
```shell
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
yarn install
yarn build
```