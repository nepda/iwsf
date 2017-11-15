<?php

declare(strict_types=1);

require_once 'bootstrap.php';

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


