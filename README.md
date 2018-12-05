Ruckus Client
===============
Ruckus WLAN controller API client

Requirements
------------
* [PHP 7.2](http://php.net)
* [Composer](https://getcomposer.org) 
* [PHPUnit](https://phpunit.de/getting-started.html)

Running
-----------
```bash
docker-compose up -d
```

Installing Dependencies
-----------
```bash
docker-compose run --rm client composer install
```

Configuration
-----------
All the configuration is stored in the environment variables. For the development/local configuration check `.env` file  

To override any of the config values locally, create `.env.override`  file in the root of the repository

Testing
-------
Unit & integration tests are provided in the `/tests` folder. To run these tests simply run following command from the project root.

```bash
docker-compose run --rm client bin/phpunit
```
