Slim in DDD
========================

![Php 8.0.10](https://img.shields.io/badge/Php-8.0.10-9cf.svg?style=flat-square&logo=php)
![MySQL 8.0](https://img.shields.io/badge/MySQL-8.0-red.svg?style=flat-square&logo=mysql)
![Slim 4.7](https://img.shields.io/badge/Slim-4.7-purple.svg?style=flat-square&logo=slimphp)
![Docker 20.10](https://img.shields.io/badge/Docker-20.10-blue.svg?style=flat-square&logo=docker)
![Node 16.12.0](https://img.shields.io/badge/Node.js-16.12.0-green.svg?style=flat-square&logo=nodedotjs)

#### Requirement:
- Make
- Docker
- Docker compose

If you use Linux or Mac a *Makefile* is included, so you can run these commands to start and stop all containers at once.
Go to project root and run:

To start docker
```
make up
make console
composer install
```

#### Internal / External Ports
Base url: ``` http://localhost:8080 ```
In the additional folder you will have a collection of postman, please import it

* Nginx 8080 / 80
* Mysql 3306 / 3306
* PHP-FPM 9000 (User & pass defined in docker-compose.yml)
## Development

#### Go container php
```
make console
```

#### run unitTest (inside the php container)
```
vendor/bin/phpunit
```

### Main File
* apps/FreepikApp/Core/routes.php

### Main Directories
* apps
* src


## Tools

#### Run fix of code style
```
make cs-fix
```

#### Run phpstan
```
make phpstan
```

#### List make commands
```
make help
```

### Tools
* [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)
* [PHP CS Fixer configs](https://mlocati.github.io/php-cs-fixer-configurator)
* [PHPStan](https://github.com/phpstan/phpstan)

<br>
If you have come this far, thank you very much for your time.
You can ask me questions to my email jairo@group-celit.com