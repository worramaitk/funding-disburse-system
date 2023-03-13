#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction --ignore-platform-reqs
    composer require laravel/socialite
    composer require diimolabs/laravel-oauth2-client
    composer dump-autoload
fi

if [ ! -f ".env" ]; then
    echo "Creating env file for env $APP_ENV"
    cp .env.example .env
else
    echo "env file exists."
fi

role=${CONTAINER_ROLE:-app}

if [ "$role" = "app" ]; then
    php artisan migrate:fresh #https://youtu.be/ImtZ5yENzgE?t=3295
    php artisan key:generate
    php artisan cache:clear
    #php artisan config:clear
    #down temp to speed up debugging php artisan config:cache #&&  php artisan config:clear &&  composer dump-autoload -o
    #down temp to speed up debugging php artisan route:clear
    php artisan serve --port=$PORT --host=0.0.0.0 --env=.env
    exec docker-php-entrypoint "$@"
elif [ "$role" = "queue" ]; then
    echo "Running the queue ... "
    php /var/www/artisan queue:work --verbose --tries=3 --timeout=180
elif [ "$role" = "websocket" ]; then
    echo "Running the websocket server ... "
    php artisan websockets:serve
fi
