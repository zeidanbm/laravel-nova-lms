<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Project Setup

You will need php 7.1+, composer, node 12+, npm/yarn, git and mysql installed on your system before starting.

-   `git clone https://github.com/zeidanbm/laravel-nova-lms`
-   Download nova and unzip the folder into your project directory (rename the directory to 'nova')
-   cd into the newly created directory & run `composer install`
-   run `php artisan nova:install`
-   Create a database and rename .env.example to .env (add your configurations)
-   run `php artisan migrate`
-   run `php artisan db:seed`
-   cd into resources/app & run `yarn install`

If you want to have demo users created, you will need to run `php artisan db:seed --class=UserTableSeeder` which will generate 3 users with admin user credentials below.
- Email: admin@lms.test
- password: 123657

The Admin panel of nova can be accessed from /admin

If you want the Queue jobs to run, you will need to start the worker `php artisan queue:work`. Note that without the queue jobs some app functionality won't work.

## Demo Data

To generate demo data for testing, the command below will create random books, periodics, tags, publishers, sources, quotes etc...

-   `php artisan db:seed --class=DemoDataSeeder`

## Frontend Development

All frontend files are inside resources/app. To start a dev server, simply run `yarn run serve:app` from your project root directory.

## HMR

To get HMR working on development server, you will need to configure your server to proxy 'sockjs-node' calls. Below is an example with an nginx and apache configuration.
\_Note: Tweek the configurations according to your server. Also, this is should not be needed for production build.

### Nginx

```php
location /sockjs-node {
	proxy_set_header X-Real-IP $remote_addr;
	proxy_set_header X-Forwarded-For $remote_addr;
	proxy_set_header Host \$host;
	proxy_pass http://127.0.0.1:3000;
	proxy_redirect off;
	proxy_http_version 1.1;
	proxy_set_header Upgrade $http_upgrade;
	proxy_set_header Connection "upgrade";
}
```

### Apache

Enable proxy, proxy_http and proxy_wstunnel
`a2enmod proxy`
`a2enmod proxy_http`
`a2enmod proxy_wstunnel`

```php
RewriteEngine on
RewriteCond %{HTTP:UPGRADE} ^WebSocket$ [NC]
RewriteCond %{HTTP:CONNECTION} Upgrade$ [NC]
RewriteRule .* ws://localhost:3000%{REQUEST_URI} [P]

ProxyPreserveHost On

ProxyPass /sockjs-node http://127.0.0.1:3000/sockjs-node
ProxyPassReverse /sockjs-node http://127.0.0.1:3000/sockjs-node
```

## Elasticsearch

We are using the [laravel-elastisearch package](https://github.com/cviebrock/laravel-elasticsearch). Refer to their documentation for more info.
The mapping files should be located under storage/app. These files contain the elasticsearch indecies with the mapping and settings.

Project
|-- storage
| |-- app
| | |-- Catalogs.json // index settings and mapping for catalogs

After that we can create the indecies with their mapping
`php artisan laravel-elasticsearch:utils:index-create-or-update-mapping catalogs 'Catalogs.json'`

To index all books into catalogs
`php artisan laravel-elasticsearch:index:indexing catalogs App\\Models\\Book --relations='Authors,Topic,Subtopic,Tags,Publishers,Sources,Cover'`

To index all periodics into catalogs
`php artisan laravel-elasticsearch:index:indexing catalogs App\\Models\\Periodic --relations='Publishers,Sources,Cover'`

To index all quotes into catalogs
`php artisan laravel-elasticsearch:index:indexing catalogs App\\Models\\Quote --relations='Author'`

To remove catalogs index
`php artisan laravel-elasticsearch:utils:index-delete catalogs`

## Production

To build the frontend for production, run `yarn run build:app` from the project root directory.
