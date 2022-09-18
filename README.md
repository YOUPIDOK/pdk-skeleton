# PdkSkeleton
> This project is Symfony Web app skeleton
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

#### Front-end
* Webpack ``3.0``
* Hotwired Stimulus ``3.0``
* Hotwired Turbo ``7.1``
* Boostrap ``5.2``
* Font awesome ``6.1``
* AOS ``2.3``
* ChoiceJs ``10.1``

#### Pdk Bundles
* Rgpd ``1.0``

### Clone project
```shell
git clone git@github.com:YOUPIDOK/pdk-skeleton.git
cd symfony
git remote remove origin
git remote add origin git@github.com:{ user }/{ project_name }.git
git flow init
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
yarn install
yarn build
git push
```
### Config
#### User rights
```php
// src/Enum/User/RoleEnum.php
// Add new constant for manage roles available in admin group configuration
// 

// ...

class RoleEnum
{
    const DEFAULT_ROLE = 'ROLE_USER';

    const ROLE_TEST_1 = 'ROLE_TEST_1';
    const ROLE_TEST_2 = 'ROLE_TEST_2';

    public static array $roles = [
        self::ROLE_TEST_1 => 'Accès test n°1',
        self::ROLE_TEST_2 => 'Accès test n°2',
    ];
    
    // ...
}
```
###
### Command
```shell
php bin\console user:create # Create user
```
### Cron
```
0 3 * * * php bin/console presta:sitemaps:dump  # PrestaSitemap - Everyday at 03:00
```