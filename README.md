## Local installation
- Run "composer install" in your project directory to create vendor directory.
- Edit your .env file according your local mysql config.
- Run "php artisan migrate" for creating tables.
- Run "php artisan db:seed" for creating dummy data.(Developers-Configs..)
- Run "php artisan app:get-tasks" for fetching todo list from mocky api.
- Run "php artisan serve" for starting server.

Use the following endpoint to get the tasks.
```php
Route::get('/', [TaskController::class, 'getTasks']);
```

### Db schema
![Veritabanı Şeması](https://github.com/kadirseckin/todo-api-example/blob/main/resources/db_schema.png)

