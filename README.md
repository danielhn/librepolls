# Librepolls

Librepolls allows creating and voting polls without registering accounts. Each poll can have one or multiple choices, and votes can be restricted based on IP or web browser. Inspired by the now defunct StrawPoll.me.

## Installation

### Docker

1. Save a [docker compose example](#docker-compose-examples)
2. Change at least `APP_KEY`, `APP_URL`, and the database password. [See available variables](#available-variables) for more variables that can be added.
3. There's a few ways to generate the `APP_KEY` value: 
   1. Execute `echo "base64:$(openssl rand -base64 32)"` in a terminal, and paste it to the `APP_KEY` variable.
   2. Run `docker compose exec librepolls php artisan key:generate --show` when the container is started, copy the result and paste it to the `APP_KEY` variable.
   3. Use an [online generator](https://laravel-encryption-key-generator.vercel.app/), copy the result and paste it to the `APP_KEY` variable.
4. Use `docker compose up -d` in the directory where the `docker-compose.yml` file is to create the containers.

#### Docker compose examples

This example uses MariaDB as the database.

```yaml copy
services:
  php:
    image: ghcr.io/danielhn/librepolls:1.0.1
    restart: unless-stopped
    container_name: librepolls
    ports:
      - "8130:8080"
    environment:
      PHP_OPCACHE_ENABLE: "1"
      APP_DEBUG: false
      APP_ENV: production
      APP_URL: https://example.com
      APP_KEY: set-your-key-here
      DB_HOST: mariadb
      DB_DATABASE: librepolls
      DB_USERNAME: librepolls
      DB_PASSWORD: librepolls
      DB_CONNECTION: mariadb
    depends_on:
      - mariadb

  mariadb:
    image: mariadb:11
    container_name: mariadb
    restart: unless-stopped
    environment:
      MARIADB_DATABASE: librepolls
      MARIADB_USER: librepolls
      MARIADB_ROOT_PASSWORD: rootpassword
      MARIADB_PASSWORD: librepolls
    volumes:
      - librepolls_db_data:/var/lib/mysql

volumes:
  librepolls_db_data:
```

This example uses PostgreSQL as the database.

```yaml copy
services:
  php:
    image: ghcr.io/danielhn/librepolls:1.0.1
    restart: unless-stopped
    container_name: librepolls
    ports:
      - "8130:8080"
    environment:
      PHP_OPCACHE_ENABLE: "1"
      APP_DEBUG: false
      APP_ENV: production
      APP_URL: https://example.com
      APP_KEY: set-your-key-here
      DB_HOST: pgsql
      DB_DATABASE: librepolls
      DB_USERNAME: pgsql
      DB_PASSWORD: librepolls
      DB_CONNECTION: pgsql
    depends_on:
      - pgsql

  pgsql:
    image: postgres:latest
    restart: unless-stopped
    environment:
      POSTGRES_DB: "librepolls"
      POSTGRES_PASSWORD: "librepolls"
    volumes:
      - librepolls_db_data:/var/lib/postgresql

volumes:
  librepolls_db_data:
```

### Manual

1. Clone this project.
2. Install npm dependencies with `npm install`.
3. Generate assets with `npm run build`.
4. Install composer dependencies with `composer install --no-dev --optimize-autoloader`.
5. Copy or rename the `.env.example` file to `.env`.
6. Use `php artisan key:generate` to generate a key that will be added to the `.env` file.
7. Fill the data in the `.env` file, like the database. You'll need to set at least the following variables: `APP_URL`, `APP_ENV` to `production`, `APP_DEBUG` to `false`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD`.
8. Run `php artisan migrate` to execute the migrations.
9. Execute `php artisan optimize`. If you change any environment variable, you'll need to execute this again.

## Configuration

### Available variables

You can see [.env.example](.env.example) for a list of some variables supported by Laravel.

The docker image is based on the [serversideup fpm-nginx image](https://serversideup.net/open-source/docker-php/docs/image-variations/fpm-nginx), so you can [use the same environment variables](https://serversideup.net/open-source/docker-php/docs/image-variations/fpm-nginx#environment-variables) that are supported by it.

#### List of custom variables

- `MAX_CHOICES_PER_POLL`: How many choices can a poll have, at most. By default, is `10`.
- `USE_HTTPS_FOR_URLS`: If set to true, every url that is generated will use `https` as the protocol. By default, is set to `true`.

> [!WARNING]
> You should set the following variables before executing migrations (in case of installing manually), or before creating the container (in case of using docker), because they affect the tables in the database. They shouldn't be changed after that, or you might risk losing data.

- `POLL_TITLE_MAX_LENGTH`: The maximum length of a poll's title. By default, is `255`.
- `POLL_DESCRIPTION_MAX_LENGTH`: The maximum length of a poll's description. By default, is `511`.
- `POLL_SLUG_LENGTH`: The maximum length of a poll's slug. These are used to access polls. By default, is `8`.
- `CHOICE_TEXT_MAX_LENGTH`: The length of the text of a choice. By default, is `127`.
- `VOTER_TOKEN_LENGTH`: This token is stored in a cookie on each voter when a poll has the option of one vote per web browser. This variable controls the length of this token. By default, is `64`.

## License

Librepolls is released under the [AGPLv3 license](LICENSE).
