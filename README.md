## Setup CMDs
```
cp .env.example .env
```
```
composer install
```
Now setup the DB creds
```
php artisan key:generate
```
## DB Refresh CMD
```
php artisan migrate --seed;
```

## Docs Generation CMD

```
php artisan l5-swagger:generate;
```

## Serve the Application
```
php artisan serve
```

Now visit the url http://127.0.0.1:8000/api/docs