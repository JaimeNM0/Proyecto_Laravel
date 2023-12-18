1.
composer create-project laravel/laravel ejerciciosLaravel → crea el proyecto de Laravel.


3.
php artisan make:migration create_alumnos_table → sirve para crear una migration llamada create_alumno_table.

php artisan migrate → sirve para ejecutar todas las migrations.


4.
php artisan make:model Alumno → sirve para crear un model llamado Alumno.

php artisan make:seed AlumnosSeeder → sirve para crear un seeder llamado AlumnosSeeder.

php artisan make:factory AlumnoFactory → sirve para crear un factory llamado AlumnoFactory.

php artisan db:seed --class AlumnosSeeder → sirve para los seeders de la clase AlumnosSeeder.


5.
php artisan make:controller AlumnosController --api → sirve para crear el controller con sus rutas(get, get{id}, post, put/patch y delete) llamado AlumnosController.


7.
php artisan make:middleware VerifyId → sirve para crear un middleware llamado VerifyId.
