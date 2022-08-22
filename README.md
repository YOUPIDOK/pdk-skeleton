# Symfony
> This project is Symfony Web app skeleton
## Documentation
### Requirement
* PHP ``8.1``
* Node ``16``
### Dependencies
#### Back-end
* PHP
  * Symfony ``6.1``
  * Sonata ``4.1``
  * PrestaSitemap ``3.3``
  * VichUploader ``1.1``
  * Liip Imagine ``2.8``
  * KnpMenu ``3.2``
* JS 
  * Webpack ``3.0``
  * Hotwired Stimulus ``3.0``
  * Hotwired Turbo ``7.1``

#### Front-end
* Boostrap ``5.2``
* Font awesome ``6.1``
### Install
```shell
git flow init
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
yarn install
yarn build
```
### Command
```shell
php bin\console user:create # Create user
```
### Cron
```
0 3 * * * php bin/console presta:sitemaps:dump  # PrestaSitemap # Everyday at 03:00
```