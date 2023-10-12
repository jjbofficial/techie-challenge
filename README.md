# Slightly Techie Challenge

* [Local setup using composer](#Set-up-process-using-composer)
* [Local setup using laravel sail (Docker)](#set-up-process-using-sail)
* [Tesing the api](#testing-the-api)



## Set-up process using composer

### Clone the repo
```
gh repo clone anaanse/anaanse-api
```
or

```
git clone git@github.com:anaanse/anaanse-api
```
<br>

### Install dependencies
```
composer install
```
<br>

### Create .env file
```
cp .env.example .env
```
<br>

### Generate application key
```
php artisan key:generate
```
<br>

### Edit .env 
Provide the necessary information to connect to your database
<br>

### Migrate the database
```
php artisan migrate --seed
```
<br>

### Launch application
```
php artisan serve
```


## Set-up process using sail
Note: This requires that you have docker installed 
<br>

### Clone the repo
```
gh repo clone anaanse/anaanse-api
```
or

```
git clone git@github.com:anaanse/anaanse-api
```
<br>

### Install dependencies
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```
<br>

### Start services
```
./vendor/bin/sail up -d
```
<br>

### Generate application key
```
./vendor/bin/sail artisan key:generate
```
<br>

### Migrate the database
```
./vendor/bin/sail artisan migrate --seed
```
<br>

## Testing the API
To view the full api documentation, visit `http://localhost:82/docs` or `http://locahost:8000/docs` depending on whether you used sail or composer for your local set-up. 

|Endpoint |Method|Description |Requires Auth |
|---------|-------|-----|--------------|
| /api/v1/register| POST| Create an account| No|
| /api/v1/login| POST|Login| No|
| /api/v1/posts| GET| View all posts| Yes|
| /api/v1/post/{post}| GET| View a single post| Yes|
| /api/v1/post/{post}| PUT| Edit a post| Yes|
| /api/v1/post/{post}| DELETE|Delete a post| Yes|
