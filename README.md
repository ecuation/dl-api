# Docline API with Lumen (Laravel microframework)

Simple API technical test using a prebuild MySQL database schema and data.
### Installation

Download project, install dependencies with composer and db migrations .
```sh
$ git clone git@github.com:ecuation/docline-api.git docline-api.development
$ cd docline-api.development
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

Install Laravel Passport

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
Save credentials in your clipboard from the client with the ID: 2 
(You will need these credentials to set it in your .env frontend project file
in order to make the Client->API connection)

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
