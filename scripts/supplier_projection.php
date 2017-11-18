<?php

declare(strict_types=1);

require_once 'bootstrap.php';
require_once 'bootstrap.event-bus.php';
require_once 'bootstrap.command-bus.php';

$supplierProjectionManager = new \Prooph\EventStore\Pdo\Projection\MariaDbProjectionManager(
    $eventStore,
    $pdo,
    'supplier'
);

$supplierReadModel = new \IWantSomeFood\Projection\SupplierReadModel($pdo);

$supplierProjection = $supplierProjectionManager->createReadModelProjection('supplier', $supplierReadModel);


$supplierProjection->fromStream('supplier')
    ->when([
        \IWantSomeFood\Model\Event\SupplierAdded::class => function ($state, \IWantSomeFood\Model\Event\SupplierAdded $event) {
            $this->readModel()->stack('insert', [
                'id' => $event->id(),
                'name' => $event->name(),
            ]);
        },
        \IWantSomeFood\Model\Event\SupplierNameChanged::class => function (
            $state,
            \IWantSomeFood\Model\Event\SupplierNameChanged $event
        ) {
            $this->readModel()->stack('changeName', [
                'id' => $event->id(),
                'name' => $event->name(),
            ]);
        }
    ])
    ->run();
