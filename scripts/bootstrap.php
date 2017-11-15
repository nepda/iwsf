<?php

declare(strict_types=1);

namespace IWantSomeFood;

require_once 'vendor/autoload.php';

// docker run --name eating-test -p 3388:3306 -e MYSQL_ROOT_PASSWORD=root-secure -e MYSQL_DATABASE=eating_test -d mariadb
// docker start eating-test
$pdo = new \PDO('mysql:dbname=eating_test;host=127.0.0.1;port=3388', 'root', 'root-secure');

