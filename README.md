Application that allows the users to solve chess blunders that are sent daily to the discord server.

GDrive link: https://docs.google.com/document/d/1otz8NOzzvIKxP9QHapZYoJUh1_Za82FxKt_fytjqAK4/edit?usp=sharing

Install steps:
1. Run `composer install`
2. Create .env from .env.example and populate it with proper data
3. Create database
4. Run `php bin/console orm:schema-tool:create`
5. Run `php importBlunders.php` in order to save blunders to the database
6. Create a system service using the `chess.blunders.service` file in the root of the app
7. Create a cron job that runs `php randomBlunder.php` in order to get new random blunders every day
