# Symfony
> This project is Symfony Web app skeleton
## Documentation
### Requirement
* PHP ``8.1``
* Node ``16``
### Dependencies
* Symfony ``6.1``
* Sonata ``4.1``
* Boostrap ``5.2``
* Font awesome ``6.1``
* Liip Imagine ``2.8``
* Webpack ``3.0``
* Stimulus ``3.0``
* VichUploader ``1.1``
* PrestaSitemap ``3.3``
### Install
```shell
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
yarn install
yarn build
```
### Cron
```
0 */1 * * * php bin/console presta:sitemaps:dump  # PrestaSitemap
```