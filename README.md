# Polanco
A retreat management application written in Laravel based in part on CiviCRM

## Getting started with development

* Run `git checkout polanco_56` to switch to the updated Polanco branch

### Local machine requirements
* `MySQL <= 5.7`
* `PHP >=7.1.3`
* `Composer`
* See https://laravel.com/docs/5.6/installation for list of PHP extensions

### Installing the dependencies
* Run `composer install`


### Setup the database
* Modify `.env` file to include database settings (database host, database name, database username, and database password, etc.)
* Run `php artisan migrate`
* Seed the database (base seed for retreat types, etc. and an option for fake development data) 

### Create application key
* Run `php artisan key:generate`
