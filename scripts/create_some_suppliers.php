<?php

declare(strict_types=1);

require_once 'bootstrap.php';
require_once 'bootstrap.event-bus.php';
require_once 'bootstrap.command-bus.php';

$commands = [];

$id1 = 'be3de60b-51b1-477e-b8b0-39d4cb8a69ab'; // \Ramsey\Uuid\Uuid::uuid4()->toString();
$supplier1 = $supplierRepository->get($id1);
if (!$supplier1) {
    $commands[] = new \IWantSomeFood\Model\Command\AddNewSupplier([
        'id' => $id1,
        'name' => 'Feedr',
    ]);
}
$commands[] = new \IWantSomeFood\Model\Command\ChangeSupplierName([
    'id' => $id1,
    'name' => 'My feedR',
]);

$id2 = '80d37805-077a-4459-9ec9-27839a2be21a'; // \Ramsey\Uuid\Uuid::uuid4()->toString();
$supplier2 = $supplierRepository->get($id2);
if (!$supplier2) {
    $commands[] = new \IWantSomeFood\Model\Command\AddNewSupplier([
        'id' => $id2,
        'name' => 'Chili Pizza'
    ]);
}

foreach ($commands as $cmd) {
    $commandBus->dispatch($cmd);
}
