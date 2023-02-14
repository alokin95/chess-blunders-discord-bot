Application that allows the users to solve chess blunders that are sent daily to the discord server.

GDrive link: https://docs.google.com/document/d/1otz8NOzzvIKxP9QHapZYoJUh1_Za82FxKt_fytjqAK4/edit?usp=sharing

Lichess Blunders download link: https://mega.nz/file/eFNCCZrL#at0x0mzU6vmKZVmumW48WdusQxubS4xhohUvB0V-q3A

Install steps:
1. Run `composer install`
2. Create .env from .env.example and populate it with proper data
3. Create database
4. Run `php bin/console orm:schema-tool:create`
5. Download Blunders file and copy the file to `data_source` folder
6. Run `php importBlunders.php` in order to save blunders to the database
7. Create a system service using the `chess.blunders.service` file in the root of the app
8. Create a cron job that runs `php randomBlunder.php` in order to get new random blunders every day
