# Laravel Boilerplate Starter Kit

This is a laravel web application starter kit.
<a href="https://laravel.com/docs/7.x/authentication">Laravel UI</a> with <a href="https://getbootstrap.com/docs/5.2/getting-started/introduction/">Bootstrap 5</a> was used as the main authentication system.

To install and run this application you can follow the instructions below:

<ul>
    <li>
        git clone https://github.com/liviu10/laravel-boilerplate.git
    </li>
    <li>
        cd laravel-boilerplate/backend/
    </li>
    <li>
        composer install
    </li>
    <li>
        npm install && npm run dev
    </li>
    <li>
        duplicate .env.example and rename the file to .env and configure your database connection variables
    </li>
    <li>
        php artisan key:generate
    </li>
    <li>
        php artisan migrate
    </li>
    <li>
        php artisan db:seed
    </li>
</ul>