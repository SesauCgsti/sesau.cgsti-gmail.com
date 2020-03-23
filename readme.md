composer create-project --prefer-dist laravel/laravel covid "5.8.*"

php artisan make:auth

composer require maatwebsite/excel

composer require guzzlehttp/guzzle


É possível através do próprio artisan criar um link simbólico de storage/app/public para dentro public/storage rode este comando:

php artisan storage:link
