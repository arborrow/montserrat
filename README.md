# Polanco
A retreat management application written in Laravel based in part on CiviCRM

## Getting Started with Development

* Run the following command to switch to the updated Polanco branch:
```
git checkout polanco_56
```

### Development Environment
We will be setting up our development envrionment in `Laravel Homestead`, a virtual machine provided by `Laravel` that meets all the system requirements needed for the Laravel framework. This will make setting up for development a breeze 💨.

#### Getting Started with Laravel Homestead
Must have the following installed:
* [VirtualBox 5.2](https://www.virtualbox.org/wiki/Downloads) installed.
* [Vagrant](https://www.vagrantup.com/downloads.html)

Add `laravel/homestead` box to your `Vagrant` installation by running the following command:
```
vagrant box add laravel/homestead
```

### Installing the dependencies
#### Backend Dependencies
```
composer install
```
#### Frontend Dependencies
```
npm install
```

### Setup the database
* Modify `.env` file to include database settings (database host, database name, database username, and database password, etc.)
* Run `php artisan migrate`
* Seed the database (base seed for retreat types, etc. and an option for fake development data) 

### Create application key
* Run `php artisan key:generate`
