# Project overview

The application is designed to handle restaurant data, utilizing the Overpass API from OpenStreetMap to extract information about fast-food restaurants, specifically focusing on the McDonald's chain.

## Requirements

This is a Laravel project that can be set up using Laravel Sail or directly on your local environment. Below are the instructions for both methods.

## Installation

### Using Laravel Sail

Before you begin, ensure you have the following installed:

- Docker

1. **Clone the repository:**

   ```bash
   git clone https://github.com/tamachine/founderz-restaurant-list
   cd founderz-restaurant-list
   ```

2. **Copy env file:**

    ```bash
    cp .env.example .env
    ```

3. **Install composer dependencies:**

    Refer to https://laravel.com/docs/11.x/sail#installing-composer-dependencies-for-existing-projects

    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php83-composer:latest \
        composer install --ignore-platform-reqs
    ```
4. **Start sail:**
 
    ```bash
    ./vendor/bin/sail up
    ```

5. **Create app key:**

    ```bash
    ./vendor/bin/sail artisan generate:key
    ```

6. **Migrate database:**

Be sure your DB_HOST var in .env file is set to mysql

BD_HOST=mysql

    ```bash
    ./vendor/bin/sail artisan migrate
    ```

7. **Start the queue worker:**

This project uses a database queue connection to execute the job that updates the restaurants, so the worker must be started.

    ```bash
    ./vendor/bin/sail artisan queue:work
    ```

8. **Start the scheduler:**

This project schedules the previously mentioned job to be run every day so the worker must be started.
    
    ```bash
    ./vendor/bin/sail artisan schedule:work
    ```

9. **Run the update list job:**

This project has a custom artisan command in order to dispatch the mentioned job and update the restaurant list by the command line:

    ```bash
    ./vendor/bin/sail artisan app:update-restaurant-list-job
    ```

10. **Run tests (optional)**

If you'd like to run the tests, run the migrations in the test environment and run the tests

    ```bash
    ./vendor/bin/sail artisan migrate --env=testing
    ./vendor/bin/sail artisan test
    ```

### Without Laravel Sail

## Requirements

You can use Laravel Herd in order to configure your local environment: https://laravel.com/docs/11.x/installation#local-installation-using-herd

You can also install:

- PHP 8.3
- Mysql 8
- Composer

1. **Create databases:**

Create the main database to be used and the testing one

    ```bash
    CREATE SCHEMA `laravel` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    CREATE USER 'user'@'localhost' IDENTIFIED by 'password';
    GRANT ALL ON laravel.* TO 'user'@'localhost';
    FLUSH PRIVILEGES;

    CREATE SCHEMA `laravel_test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    CREATE USER 'user'@'localhost' IDENTIFIED by 'password';
    GRANT ALL ON laravel.* TO 'user'@'localhost';
    FLUSH PRIVILEGES;
    ```

2. **Clone the repository:**

   ```bash
   git clone https://github.com/tamachine/founderz-restaurant-list
   cd founderz-restaurant-list
   ```

3. **Copy and set env files:**
Copy the env file and set the vars to the database and users you have created in the step #1

    ```bash
    cp .env.example .env
    ```

Do the same with the env.testing file that is already created. Set the vars to the corresponding ones

4. **Install composer dependencies:**

    ```bash
    composer install
    ```

5. **Create app key:**

    ```bash
    php artisan generate:key
    ```

6. **Migrate database:**

Be sure your DB_HOST var in .env file is set to the corresponding host

BD_HOST=localhost or your current mysql host.

    ```bash
    php artisan migrate
    ```

7. **Start the queue worker:**

This project uses a database queue connection to execute the job that updates the restaurants, so the worker must be started.

    ```bash
    php artisan queue:work
    ```

8. **Start the scheduler:**

This project schedules the previously mentioned job to be run every day so the worker must be started.
    
    ```bash
    php artisan schedule:work
    ```

9. **Run the update list job:**

This project has a custom artisan command in order to dispatch the mentioned job and update the restaurant list by the command line:

    ```bash
    php artisan app:update-restaurant-list-job
    ```

10. **Run tests (optional)**

If you'd like to run the tests, run the migrations in the test environment and run the tests

    ```bash
    php artisan migrate --env=testing
    php artisan test
    ```

