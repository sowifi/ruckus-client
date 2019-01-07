Ruckus Client
===============
Ruckus WLAN controller API client

Requirements
------------
* [docker](https://www.docker.com/)
* [docker-compose](https://docs.docker.com/compose/install/) 

Example Usage
-------
#### Get the list of Access Points
```php
$client = new SoConnect\RuckusClient\Client($host);
$res = $client->apConfig()->listAll();
```

#### Create new hotspot WLAN
```php
$client = new SoConnect\RuckusClient\Client($host);
$res = $client->wlan()->createWispr($zoneId, $body);
```

Configuration 
-------
Configuration is done using environment variables following 12-factor app methodology. Look at `getenv()` PHP function for details.
`.env.example` file contains possible config variables. Create `.env` file to use in the test execution.

Development
-------
### Running
```bash
docker-compose up -d
```

### Installing Dependencies
```bash
docker-compose exec client composer install
```

### Testing
Unit & integration tests are provided in the `/tests` folder. To run these tests simply run following command from the project root.

```bash
docker-compose exec client bin/phpunit
```

#### VCR
Project is using `PHP-VCR` snapshots for the integration testing of Ruckus API responses integrated with PHPUnit through `phpunit-testlistener-vcr`.
* See [php-vcr](https://github.com/php-vcr/php-vcr) for details
