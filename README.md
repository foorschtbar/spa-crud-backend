# spa-crud-backend

A demo REST backend with the four basic functions of persistent storage:

* Create
* Read
* Update
* Delete

The backend stores a Members entity in a relational database.

## API-Entpoints

* List all Members `GET /api/members`
* Add new Member `POST /api/member`
* Update Member `POST /api/member/{id}`
* Delete Member `DELETE /api/member/{id}`

## Usage

Create `.env.local` file
```
DATABASE_URL="mysql://symfony:symfony@db:3306/symfony?serverVersion=mariadb-10.5.6"
APP_ENV=prod
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
* https://symfony.com/doc/current/doctrine.html
* https://www.adcisolutions.com/knowledge/getting-started-rest-api-symfony-4
* https://symfony.com/doc/current/page_creation.html

### Doctrone (ORM)
* https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/tutorials/getting-started.html

### Lando
* https://docs.lando.dev/guides/frontend.html
* https://docs.lando.dev/config/symfony.html#getting-started
* https://docs.lando.dev/config/symfony.html#importing-your-database

### Other
* https://developer.okta.com/blog/2018/08/23/symfony-react-php-crud-app
* https://www.fakenamegenerator.com/gen-random-gr-gr.php