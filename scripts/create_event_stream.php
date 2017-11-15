<?php

declare(strict_types=1);

require_once 'bootstrap.php';
require_once 'bootstrap.event-bus.php';

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

$streamName = new \Prooph\EventStore\StreamName('meal');
if (!$eventStore->hasStream($streamName)) {
    $eventStore->create(
        new \Prooph\EventStore\Stream(
            $streamName,
            new ArrayIterator()
        )
    );
}
$streamName = new \Prooph\EventStore\StreamName('supplier');
if (!$eventStore->hasStream($streamName)) {
    $eventStore->create(
        new \Prooph\EventStore\Stream(
            $streamName,
            new ArrayIterator()
        )
    );
}
