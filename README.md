# Polanco
A retreat management application written in Laravel based in part on CiviCRM

## Getting Started with Development
We will be setting up our development envrionment in `Laravel Homestead`, a virtual machine provided by `Laravel` that meets all the system requirements needed for the Laravel framework. This will make setting up for development a breeze 💨.

### Step 1: Clone the repo
```
git clone https://github.com/arborrow/montserrat.git
```

### Step 2: Install the dependencies
**Must have the following installed:**
* Composer
* Node (Node is not required if using Laravel Sail as your virtual environment)
#### Backend Dependencies
Running the following command will also add `Homestead` to the current project.
```
composer install
```
#### Frontend Dependencies
```
yarn install
```

### Step 3: Setup Virtual Environment (Laravel Homestead or Laravel Sail)
For Laravel Homestead, install:
* [VirtualBox 5.2](https://www.virtualbox.org/wiki/Downloads)
* [Vagrant](https://www.vagrantup.com/downloads.html)
* [Read more about using Laravel Homestead](https://laravel.com/docs/8.x/homestead)

For Laravel Sail, install:
* [Docker](https://docs.docker.com/get-docker/)
** For [installing Docker in Ubuntu](https://docs.docker.com/engine/install/ubuntu/#installation-methods) or you can follow the [Digital Ocean instructions](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-20-04)
* [docker-compose](https://docs.docker.com/compose/install/)
* [Read more about using Laravel Sail](https://laravel.com/docs/8.x/sail)

### Step 4: Setup the Database

If not creating inside of vagrant, you may need to create your .env file by copying .env.example to .env and providing
the database configuration settings (host, name, username and password).

Following commands must be executed **inside** your vagrant box.
* `cd code`
* `php artisan migrate:fresh --seed`
*

### Step 5: Generate and Set Application Key
#### Generating Key
Run the following command to generate an application key
```
php artisan key:generate
```
**Output**
```
Application key [...] set successfully.
```
#### Setting the Key
Copy the text inside the `[]` and uncomment `APP_KEY={app_key}` in your `.env` file. Replace `{app_key}` with the copied text.

### Step 6: Generate API keys (Google People API for SocialLite Login, Twilio, and Google Calendar)

#### Google+ API for SocialLite
Navigate to [Google Cloud Console](https://console.cloud.google.com/) and login in with your preferred Google account.

* Create a new project
* Navigate to `APIs & Service`
* Once in `APIs & Service`, navigate to `Library`
* Search for `Google People API` and select it (Socialite previously used Google+ API; however, Google+ API was suspended in 2019)
* Enable the API and create a new OAuth client ID.
* Set your redirect URI as `http://localhost:8000/login/google/callback`

#### Twilio
Navigate to [Twilio](https://www.twilio.com/) and login/signup.

* Navigate to your console.
* Navigate to your dashboard where you will see `ACCOUNT SID` and `AUTH TOKEN`.
* Navigate to Phone Numbers and under Active Numbers create a new number.

#### Set .env variables
Uncomment the following lines in your `.env` file
```
GOOGLE_CLIENT_ID={google_client_id}
GOOGLE_CLIENT_SECRET={google_client_secret}

TWILIO_SID={twilio_sid}
TWILIO_TOKEN={twilio_token}

GOOGLE_CALENDAR_ID={google_calendar_id}
```
For **Google People API** replace `{google_client_id}` with your `client ID` and `{google_client_secret}` with your `client secret`.

For **Twilio** replace `{twilio_sid}` with your `ACCOUNT SID`, `{twilio_token}` with your `AUTH TOKEN`, and `{twilio_number}` with your Twilio phone number. (Do not add dashes and parentheses.)

For **Google Calendar** replace `{google_calendar_id}` with your `Calendar ID`. See [here](https://github.com/spatie/laravel-google-calendar#how-to-obtain-the-credentials-to-communicate-with-google-calendar) for more instructions on how to obtain the Google calendar ID.

### Step 7: Get Proper Permissions
Once you have done everything above navigate to `localhost:8000` (Laravel Homestead) or `localhost` (Laravel Sail) . Once you login using Google Auth, your user will not have any role assigned to it. Hence you will not be able to do anything. **You must do this before trying to get superuser access**

#### Become the Superuser
Run the following command to assign yourself (given that you are the first user to login) as the `superuser`.
```
php artisan db:seed --class=RoleUserTableSeeder
```
The command above will assign the very first user as the superuser. The command will fail if no user exists.

### Step 8: Follow Good Coding Practices!! 🤗
You're all set!

### Step 9: Testing
Prior to committing code changes, it is suggested to run the phpunit tests. Test development remains a work in progress. The test environment requires extensive setup and makes use of a fresh MySQL database. The initial database migration and seeding helps to ensure that things are setup to run well. It is recommended that you copy the .env.example file and set it up to use a testing database. Then migrate and seed the database.

* php artisan --env=testing migrate:fresh --seed
* php artisan --env=testing db:seed --class=TestPermissionRolesSeeder
