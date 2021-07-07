<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# <p align="center">account.nextvacay.com</p>

## Requirements

### Install all the requirements on the server.

- Git : [Get Git](https://git-scm.com/)
- Composer V2 : [Get Composer](https://getcomposer.org/)
- Server = Apache2
- PHP Version = ^8.0
- Mysql Version = 8.0
- Laravel = v8

## Setup Portal (account.nextvacay.com)

### Setup Project

- Extract from zip of download from repo
- Composer update
- Copy ```.env.local``` or ```.env.example``` file to ```.env```
- Add API Portal Domain name (```portalapi.nextvacay.com```) to ```.env``` file
    - You will find ```PORTAL_HOST``` variable in ```.env``` file.
    - Same for api version ```API_VERSION``` variable in ```.env``` file, current version is ```v1```

### Additional Information

- In this application ```auth()->user()``` or ```Auth::user()``` will not used, because this fetch user detail from
  database which is not allowed.
- In any ```view``` you can access authentication detail by ```$authUser``` variable.
- you wish to access authorized user detail in controller you can access by ```$this->authUser```
- For authorized and unauthorized url you will find new middleware in web.php file.
- For api call you don't need to add ```token``` and ```uuid``` manually to any api, It will add automatically add to
  authenticated api headers. 
- To call any api use ```ApiCall``` helper you will find in code.
