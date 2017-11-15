<?php

declare(strict_types=1);


$eventEmitter = new \Prooph\Common\Event\ProophActionEventEmitter();

$mariaDbEventStore = new \Prooph\EventStore\Pdo\MariaDbEventStore(
    new \Prooph\Common\Messaging\FQCNMessageFactory(),
    $pdo,
    new \Prooph\EventStore\Pdo\PersistenceStrategy\MariaDbAggregateStreamStrategy()
);

$eventStore = new \Prooph\EventStore\ActionEventEmitterEventStore(
    $mariaDbEventStore,
    $eventEmitter
);

$mealRepository = new \IWantSomeFood\Infrastructure\MealRepository($eventStore);

$eventBus = new \Prooph\ServiceBus\EventBus($eventEmitter);
