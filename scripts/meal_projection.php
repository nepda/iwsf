<?php

declare(strict_types=1);

require_once 'bootstrap.php';
require_once 'bootstrap.event-bus.php';
require_once 'bootstrap.command-bus.php';

$mealProjectionManager = new \Prooph\EventStore\Pdo\Projection\MariaDbProjectionManager(
    $eventStore,
    $pdo,
    'meal'
);

$mealReadModel = new \IWantSomeFood\Projection\MealReadModel($pdo);

$mealProjection = $mealProjectionManager->createReadModelProjection('meal', $mealReadModel);


$mealProjection->fromStream('meal')
    ->when([
        \IWantSomeFood\Model\Event\MealAdded::class => function ($state, \IWantSomeFood\Model\Event\MealAdded $event) {
            $this->readModel()->stack('insert', [
                'id' => $event->id(),
                'title' => $event->title(),
            ]);
        },
        \IWantSomeFood\Model\Event\MealTitleChanged::class => function (
            $state,
            \IWantSomeFood\Model\Event\MealTitleChanged $event
        ) {
            $this->readModel()->stack('changeTitle', [
                'id' => $event->id(),
                'title' => $event->title(),
            ]);
        }
    ])
    ->run();
