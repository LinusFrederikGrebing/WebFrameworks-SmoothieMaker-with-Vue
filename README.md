# WFR - Team 9

Grundsätzlich benötigen Sie eine Standard-LAMP-Einrichtung mit einigen zusätzlichen Abhängigkeiten und Konfigurationen.
Die .env.example-Datei muss in .env umbenannt werden. Es muss eine lokale Datenbank angelegt werden und der Datenbankname, sowie die MYSQL-Zugangsdaten müssen in der .env eingetragen werden.

## Project setup
```
composer install
```

### Starting Laravel development server 
```
php artisan serve
```

### Creates Database-Migrations $ Database-Seeds
```
php artisan migrate
php artisan db:seed
```

### Publish Sweetalert-Extension
```
php artisan sweetalert:publish

php artisan vendor:publish --provider=" Gloudemans\Shoppingcart\ShoppingcartServiceProvider" --tag="config"
```