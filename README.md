# Polanco
A retreat management application written in Laravel based in part on CiviCRM

## Getting Started with Development
We will be setting up our development envrionment in `Laravel Homestead`, a virtual machine provided by `Laravel` that meets all the system requirements needed for the Laravel framework. This will make setting up for development a breeze 💨.

### Installing the dependencies
#### Backend Dependencies
Running the following command will also add `Homestead` to the current project.
```
composer install
```
#### Frontend Dependencies
```
npm install
```

#### Getting Started with Laravel Homestead
Must have the following installed:
* [VirtualBox 5.2](https://www.virtualbox.org/wiki/Downloads) installed.
* [Vagrant](https://www.vagrantup.com/downloads.html)

#### Starting Vagrant
Run the following command to wake up Vagrant.
```
vagrant up
```
Once the command has executed sucessfully `ssh` into the Vagrant box by running the following commmand.
```
vagrant ssh
```

#### Setting up the Database
**Following commands must be executed inside your vagrant box**
* Run `php artisan migrate`
* Seed the database (base seed for retreat types, etc. and an option for fake development data) 

#### Generating application key
* Run `php artisan key:generate`
