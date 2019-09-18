#!/usr/bin/env php
<?php
function dbIsUp() {
    try {
        $dsn = 'mysql:dbname='.getenv('DB_DATABASE').';host='.getenv('DB_HOST');
        new PDO($dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    } catch(Exception $e) {
        echo "Waiting for database...\r\n";
        return false;
    }
    return true;
}
while(!dbIsUp()) {
    sleep(1);
}