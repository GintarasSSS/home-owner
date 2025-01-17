<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Launching
 - Clone repository and go into directory: `cd home-owner`
 - Build container: `docker-compose up -d`
 - Run composer: `docker-compose exec php composer install`
 - Run npm: `docker-compose exec php npm install`
 - Go inside of container: `docker compose exec -it php bash`
 - Inside of container run: 
   - `cp .env.example .env`
   - `php artisan key:generate`
   - `php artisan migrate:fresh`

## Tests
- Inside of container run: `XDEBUG_MODE=coverage php artisan test --coverage`

![img.png](img.png)

## UI
- Use url: `http://localhost/`
![img_1.png](img_1.png)

## Logs
![img_2.png](img_2.png)
