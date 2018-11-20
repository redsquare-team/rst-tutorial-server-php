## deps
composer create-project symfony/skeleton .
composer require symfony/orm-pack
composer require symfony/maker-bundle --dev
composer require symfony/serializer
composer require symfony/property-access
composer require symfony/web-server-bundle --dev
composer require nelmio/cors-bundle

## import chat from your database (change rstdemo\chat with your db name)
php bin/console doctrine:mapping:import 'rstdemo\chat' annotation --path=src/Entity
php bin/console make:entity --regenerate App

## run dev server (only for dev environment)
php bin/console server:run *:60000

## run production server
php -S 127.0.0.1:60000 public/index.php

## run server with reactphp
php bin/react