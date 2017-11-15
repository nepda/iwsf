<?php

declare(strict_types=1);

namespace IWantSomeFood;

require_once 'vendor/autoload.php';

// docker run --name eating-test -p 3388:3306 -e MYSQL_ROOT_PASSWORD=root-secure -e MYSQL_DATABASE=eating_test -d mariadb
// docker start eating-test
$pdo = new \PDO('mysql:dbname=eating_test;host=127.0.0.1;port=3388', 'root', 'root-secure');

$r1 = $pdo->query('show tables like "%event_streams%"')->fetchAll();
if (!$r1) {
    $sql1 = file_get_contents('vendor/prooph/pdo-event-store/scripts/mariadb/01_event_streams_table.sql');
    $pdo->exec($sql1);
}

$r2 = $pdo->query('show tables like "%projections%"')->fetchAll();
if (!$r2) {
    $sql2 = file_get_contents('vendor/prooph/pdo-event-store/scripts/mariadb/02_projections_table.sql');
    $pdo->exec($sql2);
}


