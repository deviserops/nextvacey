<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# <p align="center">portalapi.nextvacay.com</p>

## Requirements
###Install all the requirements on the server.
- Git : [Get Git](https://git-scm.com/)
- Composer V2 : [Get Composer](https://getcomposer.org/)
- Server = Apache2
- PHP Version = ^8.0
- Mysql Version = 8.0
- Laravel = v8

## Setup Api (portalapi.nextvacay.com)
### Setup Project
- Extract from zip of download from repo
- Composer update
- Copy ```.env.local``` or ```.env.example``` file to ```.env```
- Add Portal Domain name (```account.nextvacay.com```) to ```.env``` file
    - You will find ```PORTAL_URL``` variable in ```.env``` file.
- Add database entry to ```.env``` file
- You can use ```nano@gmail.com``` email for testing and ```dbdump.sql``` database on root folder.
- You can also use migrations for database
- Run migration command ```php artisan migrate```
- Run seeder to enter dummy data to database ```php artisan db:seed```
    - The Above command will enter 10 user record to the database.
    - Select Any record to test application.

### Setup ```POSTMARK``` SMTP
- Get SMTP detail of ```Postmark``` - [Get Details](https://postmarkapp.com/smtp-service)
- In ```.env``` file add ```Postmark``` SMTP detail like:
    - MAIL_MAILER=smtp
    - MAIL_HOST=```Postmark mail domain```
    - MAIL_PORT=```Postmark port```
    - MAIL_USERNAME=```mail username```
    - MAIL_PASSWORD=```mail password```
    - MAIL_ENCRYPTION=```tls```
    - MAIL_FROM_ADDRESS=```noreply@nextvacey.com```
    - MAIL_FROM_NAME="${APP_NAME}"

### Additional Information
- To expire login request link please add this to cron job. Default login link expire time set to 2 hours.
    
    ```* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1```
