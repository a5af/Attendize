#!/usr/bin/env bash

composer dumpautoload
composer install

php artisan migrate
npm install
grunt

php artisan attendize:install
