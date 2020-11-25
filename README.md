# Laravel API with Lumen (Laravel microframework)

Simple API technical test using a prebuild MySQL database schema and data.
### Installation

Download project, install dependencies with composer and db migrations .
```sh
$ git clone git@github.com:ecuation/dl-api.git dl-api.development
$ cd dl-api.development
$ composer install
```

Copy .env file into the project and setup the necessary project and DB connection environment variables
```sh
$ cp .env.example ./.env
```

Run Laravel migrations with artisan command
```sh
$ php artisan migrate
```

Import the sample employees.sql database into the DB project
```sh
$ cd database/db_dump
$ mysql -u yourDbUserName -p youDatabaseName < employees.sql
```

Install Laravel Passport (run this command in the root project directory)

```sh
$ php artisan passport:install
```

Previous command will return a very similar result as below:
```sh
Client ID: 1
Client secret: 1cYyIHtKfPjJRHrOcngug8H03mvCOvSn05SUviYO
Password grant client created successfully.
Client ID: 2
Client secret: gOV3kfHdI2t6soli5Fhi3n16AqgrAwcTU8Ip2e1G
```
Note: Save the above credentials in your clipboard from the client with the ID: 2 
(You will need these credentials to set it in your .env frontend project file
in order to make the correct WebClient->API connection)


Last backend setup step: Create the default admin user just by running the following seeder command

```sh
$ php artisan db:seed --class=MainUserSeeder
```

Now you can start with the frontend project setup.

## TDD with phpunit

All API endpoints has been developed applying TDD. To make these tests run, please execute the following command in your project root directory

```sh
$ vendor/bin/phpunit
```
