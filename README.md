# galleries-api

### deployment

* create database galleries in your mysql
* git clone https://github.com/bokinho91/galleries-api.git
* cd galleries-api
* composer install
* FOR WIN: copy .env.example .env
  LINUX:   cp .env.example .env
* enter your DB_USERNAME and DB_PASSWORD in .env file
* php artisan key:generate
* php artisan jwt:secret
* php artisan migrate
* php artisan serve    (it should run on http://127.0.0.1:8000)