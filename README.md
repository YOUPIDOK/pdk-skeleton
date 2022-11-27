
# toupiktv
> TOUPIK-TV youtube manager
## Documentation
### Requirement
* PHP ``8.1``
* Node ``16``
### Dependencies
#### Back-end
* Symfony ``6.1``
* Sonata ``4.1``
* PrestaSitemap ``3.3``
* VichUploader ``1.1``
* Liip Imagine ``2.8``
* KnpMenu ``3.2``
* PagerFanta ``3.7``
* FOSCKEditor ``2.4``
* Axios ``1.1``

#### Front-end
* Webpack ``3.0``
* Hotwired Stimulus ``3.0``
* Hotwired Turbo ``7.1``
* Boostrap ``5.2``
* Font awesome ``6.1``
* ChoiceJs ``10.1``

### Install
```shell
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
yarn install
yarn build
```
### Commands
#### Tool
```shell
php bin/console user:create # Create user
```