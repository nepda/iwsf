<?php

declare(strict_types=1);

require_once 'bootstrap.php';
require_once 'bootstrap.event-bus.php';
require_once 'bootstrap.command-bus.php';

$commands = [];

$id1 = '6d0949f3-7d96-4727-8238-e92eafcba9d2'; // \Ramsey\Uuid\Uuid::uuid4()->toString();
$meal1 = $mealRepository->get($id1);
if (!$meal1) {
    $commands[] = new \IWantSomeFood\Model\Command\AddNewMeal([
        'id' => $id1,
        'title' => 'Super mushroom pizza!',
    ]);
}
$commands[] = new \IWantSomeFood\Model\Command\ChangeMealTitle([
    'id' => $id1,
    'title' => 'Mushroom Pizza',
]);

$id2 = '2a09a2d9-7ce2-454f-af60-0b645f828240'; // \Ramsey\Uuid\Uuid::uuid4()->toString();
$meal2 = $mealRepository->get($id2);
if (!$meal2) {
    $commands[] = new \IWantSomeFood\Model\Command\AddNewMeal([
        'id' => $id2,
        'title' => 'Apple Crumble'
    ]);
}

foreach ($commands as $cmd) {
    $commandBus->dispatch($cmd);
}
