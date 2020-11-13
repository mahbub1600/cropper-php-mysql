<?php
return array(
    'db' => array(
        'adapters' => array(
            'UserDbAdapter' => array(
                'driver' => 'Pdo',
                'dsn' => 'mysql',
                'dbname' => 'development',
                'host' => 'localhost',
                'username' => 'mahbub',
                'password' => '12345678',
                'driver_options' => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                )
            ),
        )
    ),
);
