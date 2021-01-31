# spa-crud-backend

A demo REST backend with the four basic functions of persistent storage (CRUD):

* **C**reate
* **R**ead
* **U**pdate
* **D**elete

The backend stores all data in a relational database and provides a JSON based REST API.

## API-Entpoints

| Function          | Methode       | URL |
| :-------------    | :----------:  | -----------: |
| List all Members | `GET`          | `/api/members`|
| Search Member | `GET`          | `/api/members/{lastname}`|
| Add new Member | `POST`         | `/api/member`|
| Update Member | `POST`         | `/api/member/{id}`|
| Delete Member | `DELETE`       | `/api/member/{id}`|

## ToDo

* PHPUnit tests

## Usage

Create `.env.local` file
```
DATABASE_URL="mysql://username:password@db:3306/database?serverVersion=mariadb-10.5.6"
APP_ENV=prod
CORS_ALLOW_ORIGIN='^https?:\/\/(your\.server.\com|localhost|127\.0\.0\.1)(:[0-9]+)?$'
```

Example `docker-compose.yml`
```yml
version: "3"

services:
  app:
    build: .
    volumes:
      - ./.env.local:/var/www/html/.env.local
    environment:
      - UID=1000
      - GUID=1000
    networks:
      - internal
    depends_on:
      - db

  db:
    image: mariadb:10.5
    restart: unless-stopped
    volumes:
      - ./data/db:/var/lib/mysql
    user: 1000:1000
    environment:
      - MYSQL_ROOT_PASSWORD=changeme
      - MYSQL_PASSWORD=changeme
      - MYSQL_DATABASE=symfony
      - MYSQL_USER=symfony
```

## Futher informations

### Symfony
* https://symfony.com/doc/current/page_creation.html
* https://symfony.com/doc/current/doctrine.html
* https://www.adcisolutions.com/knowledge/getting-started-rest-api-symfony-4

### Doctrine (ORM)
* https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/tutorials/getting-started.html

### Other
* https://developer.okta.com/blog/2018/08/23/symfony-react-php-crud-app
* https://www.fakenamegenerator.com/gen-random-gr-gr.php

### Lando
* https://docs.lando.dev/guides/frontend.html
* https://docs.lando.dev/config/symfony.html#getting-started
* https://docs.lando.dev/config/symfony.html#importing-your-database