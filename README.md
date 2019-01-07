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
* Node
#### Backend Dependencies
Running the following command will also add `Homestead` to the current project.
```
composer install
```
#### Frontend Dependencies
```
yarn install
```

### Step 3: Setup Laravel Homestead
Must have the following installed:
* [VirtualBox 5.2](https://www.virtualbox.org/wiki/Downloads) installed.
* [Vagrant](https://www.vagrantup.com/downloads.html)

#### Starting Vagrant
Run the following command to wake up Vagrant. When running for the first time this command will take a while
```
vagrant up
```
Once the command has executed sucessfully `ssh` into the Vagrant box by running the following commmand.
```
vagrant ssh
```

### Step 4: Setup the Database
Following commands must be executed **inside** your vagrant box.
* `cd code`
* `php artisan migrate`
* `php artisan db:seed` 

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

### Step 6: Generate a Google People API for SocialLite Login
Navigate to [Google Cloud Console](https://console.cloud.google.com/) and login in with your preferred Google account.

* Create a new project
* Navigate to `APIs & Service`
* Once in `APIs & Service`, navigate to `Library`
* Search for `Google People API` and select it (Socialite previously used Google+ API; however, Google+ API was suspended in 2019)
* Enable the API and create a new OAuth client ID.
* Set your redirect URI as `http://localhost:8000/login/google/callback`

#### Setting Client ID and Secret
Uncomment the following lines in your `.env` file
```
GOOGLE_CLIENT_ID={google_client_id}
GOOGLE_CLIENT_SECRET={google_client_secret}
```
Replace `{google_client_id}` with your `client ID` and `{google_client_secret}` with your `client secret`.

### Step 7: Get Proper Permissions
Once you have done everything above navigate to `localhost:8000`. Once you login using Google Auth, your user will not have any role assigned to it. Hence you will not be able to do anything. **You must do this before trying to get superuser access**

#### Become the Superuser
Run the following command to assign yourself (given that you are the first user to login) as the `superuser`.
```
php artisan db:seed --class=RoleUserTableSeeder
```
The command above will assign the very first user as the superuser. The command will fail if no user exists.

### Step 8: Follow Good Coding Practices!! 🤗
You're all set!
