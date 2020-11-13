Running Prerequisite:

Web Server: Apache
OS: Windows/Mac OC/ Linux
RDBMS: MySQL

Database Configuration: "user_crud\" directory contains development.sql file. Create a database to your host and name it "development". And import the attached database(development.sql).
Then configure the "user_crud\user-management\config\DB.php" file. (This project only run with Pdo driver)

'driver' => 'Pdo',
'dsn' => 'mysql',
'dbname' => 'development',
'host' => 'your_host', //might be localhost
'username' => 'your_user_name',
'password' => 'your_password', 


Hosting: point the "user_crud\public" folder to a domian or localhost if you want to run locally. The apache will load index.php file which in consequence MyFramwork(a PHP based framework with PHP 5.6+). Here you go, visit your pointed domain.
