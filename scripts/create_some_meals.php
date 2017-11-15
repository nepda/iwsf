<?php

declare(strict_types=1);

require_once 'bootstrap.php';
require_once 'bootstrap.event-bus.php';
require_once 'bootstrap.command-bus.php';


$id1 = \Ramsey\Uuid\Uuid::uuid4()->toString();
$commands[] = new \IWantSomeFood\Model\Command\AddNewMeal([
    'id' => $id1,
    'title' => 'Super mushroom pizza!',
]);
$commands[] = new \IWantSomeFood\Model\Command\ChangeMealTitle([
    'id' => $id1,
    'title' => 'Mushroom Pizza',
]);

$id2 = \Ramsey\Uuid\Uuid::uuid4()->toString();
$commands[] = new \IWantSomeFood\Model\Command\AddNewMeal([
    'id' => $id2,
    'title' => 'Apple Crumble'
]);

foreach ($commands as $cmd) {
    $commandBus->dispatch($cmd);
}
