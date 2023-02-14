# Bookstore Implementation

## Local Development Logs
1. Install Laravel

```bash
composer2 create-project laravel/laravel bookstore
```
2. Install laravel/ui
```bash
 composer require laravel/ui 
 ```
3. Generate login / registration scaffolding with vue JavaScript framework
```bash
php artisan ui vue --auth
```
4. Create database
```sql
create database bookstore character set utf8;
```
5. Set database credentials in .env file:
```env
DB_DATABASE=bookstore
DB_USERNAME=root
DB_PASSWORD=root
```
6. Run migration
```bash
$   php artisan migrate --seed
```

7. Install npm packages and run dev command
```bash
$   npm install && npm run dev
```

8. Install elastic search
    1. Before downloading elasticsearch your OS should have Java SDK installed. Download deb package from the elasticsearch website
    ```bash
    $   wget https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-8.6.1-amd64.deb
    ```
    2. Install
    ```bash
    $   sudo dpkg -i elasticsearch-8.6.1-amd64.deb
    ```
    3. Enable elasticsearch service
    ```bash
    $   sudo systemctl enable elasticsearch.service
    ```
    4. Setup elasticsearch network configuration
    ```bash
    $   sudo nano /etc/elasticsearch/elasticsearch.yml
    ```
    And set IP as localhost and port as 9200
    ```yaml
    ...
    network.host: 127.0.0.1
    http.port: 9200
    ...
    ```
    5. By default, the current elasticsearch installation package uses authentication using xpack plugin. To reset the password go to `/usr/share/elasticsearch/` from the terminal directory and run:
    ```bash
    $   cd /usr/share/elasticsearch/ 
    $   ./bin/elasticsearch-reset-password -u elastic
    ```
    6. It will generate the reset password and display in the terminal, save it somewhere safe
    7. And if you don't want the authentication you can disable it by editing the elasticsearch.yml file as discussed in point no. 4.
    ```yaml
    ...
    xpack.security.enabled: false
    ...
    ```
    8. Now edit the .env file and update your ELASTICSEARCH_USERNAME and ELASTICSEARCH_PASSWORD if authentication enabled
    9. Now run:
    ```bash
    $   sudo systemctl restart elasticsearch
    ```

## Web routes

| Method | URI | Name | Action | Middleware |
|:------:|:---:|:----:|:------:|:----------:|
| GET | / | guest.default | GuestController@index | guest |
| GET | authors | authors.default | AuthorsController@index | auth |
| POST | authors | authors.store | AuthorController@store | auth |
| GET | authors/datatables | authors.datatables | AuthorController@datatables | auth |
| GET | authors/{id} | authors.show | AuthorController@show | auth |
| PUT | authors/{id} | authors.update | AuthorController@update | auth |
| DELETE | authors/{id} | authors.delete | AuthorController@destroy | auth |
| GET | book-detail/{book} | guest.book-detail | GuestController@bookDetail | auth |
| GET | books | books.default | BookController@index | auth |
| POST | books | books.store | BookController@store | auth |
| GET | books/create | books.create | BookController@create | auth |
| GET | books/datatables | books.datatables | BookController@datatables | auth |
| GET | books/edit/{book} | books.edit | BookController@edit | auth |
| POST | books/{book} | books.update | BookController@update | auth |
| DELETE | books/{book} | books.delete | BookController@destroy | auth |
| GET | genres | genres.default | GenreController@index | auth |
| POST | genres | genres.store | GenreController@store | auth |
| GET | genres/datatables | genres.datatables | GenreController@datatables | auth |
| GET | genres/{id} | genres.show | GenreController@show | auth |
| PUT | genres/{id} | genres.update | GenreController@update | auth |
| DELETE | genres/{id} | genres.delete | GenreController@destroy | auth |
| GET | home | home | HomeController@index | auth |
| GET | login | login | Auth\LoginController@showLoginForm | guest |
| POST | login | Auth\LoginController@login | guest |
| POST | logout | logout | Auth\LoginController@logout | auth |
| GET | password/confirm | password.confirm | Auth\ConfirmPasswordController@showConfirmForm | guest |
| POST | password/confirm |  | Auth\ConfirmPasswordController@confirm | guest |
| POST | password/email | password.email | Auth\ForgotPasswordController@sendResetLinkEmail | guest |
| GET | password/reset | password.request | Auth\ForgotPasswordController@showLinkRequestForm | guest |
| POST | password/reset | password.update | Auth\ResetPasswordController@reset | guest |
| GET | password/reset/{token} | password.reset | Auth\ResetPasswordController@showResetForm | guest |
| GET | publishers | publishers.default | PublisherController@index | auth |
| POST | publishers | publishers.store | PublisherController@store | auth |
| GET | publishers/datatables | publishers.datatables | PublisherController@datatables | auth | 
| GET | publishers/{id} | publishers.show | PublisherController@show | auth |
| PUT | publishers/{id} | publishers.update | PublisherController@update | auth |
| DELETE | publishers/{id} | publishers.delete | PublisherController@destroy | auth |
| GET | search | guest.search | GuestController@search | guest | 
| GET | search-ajax | guest.search-ajax | GuestController@searchAjax | guest | 
| GET | search-title | guest.search-title | GuestController@searchTitle | guest |

## Setup
1. Clone the repo

```bash
$   git clone https://github.com/surajitbasak109/bookstore
```
2. cd into the repository directory
```bash
$   cd bookstore
```
3. Create a new database
```bash
mysql -u<username> -p<password>
```
```sql
create database bookstore character set utf8;
```
4. Copy the sample .env.example file to .env file and update the database credentials
```env
...
DB_DATABASE=bookstore
DB_USERNAME=root
DB_PASSWORD=pass
...
```
5. Update following variables to your `.env` file and change the values for the below
```env
...
SCOUT_DRIVER=elastic
ELASTICSEARCH_USERNAME=elastic
ELASTICSEARCH_PASSWORD=
...
```
6. Run following commands in your terminal:

```bash
# install composer dependencies
composer install
# Install npm dependencies
npm install
# migrate and seed into your database
php artisan migrate --seed
# Generate the application key
php artisan key:generate
# Index your data to elasticsearch engine
php artisan scout:import "App\Models\Book"
# Start the server
php artisan serve
```
7. Open a new terminal tab in the same location and run
```bash
npm run dev
```

8. Open `localhost:8000` in your browser to load the application


### Sample Admin Login Credential
- __Email__: admin@bookstore.test
- __Passwword__: password
