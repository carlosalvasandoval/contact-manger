## Project Requirements
-  [Server requirements with laravel 7.x](https://laravel.com/docs/7.x#server-requirements).
- This application was build using PHP 7.4
- You need to have Redis installed because It uses cache tags approach.
- [Project github](https://github.com/carlosalvasandoval/contact-manger)

## Project Instructions
In order to run this project locally :

- composer install
- set up your .env, copy .env.example to .env
- set KLAVIYO_API_KEY  and database info  values
- php artisan migrate
- php artisan ui vue --auth
- copy ./sampleCsv.csv to ./storage/app/public
- create a folder ./storage/app/csv 
- php artisan storage:link