# My Library API

## Project Setup

1. Git clone this repository
2. Create .env on project root and copy content from .env.example in it.
3. Create a database and Update following keys in the .env with you database configuration
		
		DB_CONNECTION=mysql
		DB_HOST=127.0.0.1
		DB_PORT=3306
		DB_DATABASE=test
		DB_USERNAME=root
		DB_PASSWORD=test

4. Install packages

        $ composer install
        
5. Run Laravel migrations and seeder

        $ php artisan migrate --seed

6. Generate APP Key

        $ php artisan key:generate

7. Install Passport for Access keys

        $ php artisan passport:install

8. Start Server

        $ php artisan serve
        
## Run Tests

		$ php artisan test

