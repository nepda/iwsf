<?php

declare(strict_types=1);

// Bootstrapping
require_once 'vendor/autoload.php';

$eventEmitter = new \Prooph\Common\Event\ProophActionEventEmitter();

// docker run --name eating-test -p 3388:3306 -e MYSQL_ROOT_PASSWORD=root-secure -e MYSQL_DATABASE=eating_test -d mariadb
$pdo = new \PDO('mysql:dbname=eating_test;host=127.0.0.1;port=3388', 'root', 'root-secure');

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

$commandBus = new \Prooph\ServiceBus\CommandBus();
$commandRouter = new \Prooph\ServiceBus\Plugin\Router\CommandRouter();

$commandRouter->route(\IWantSomeFood\Model\Command\AddNewMeal::class)
    ->to(new \IWantSomeFood\Model\Command\AddNewMealHandler($mealRepository));
$commandRouter->route(\IWantSomeFood\Model\Command\ChangeMealTitle::class)
    ->to(new \IWantSomeFood\Model\Command\ChangeMealTitleHandler($mealRepository));

$commandRouter->attachToMessageBus($commandBus);


// The real stuff
#$id = \Ramsey\Uuid\Uuid::uuid4()->toString();
#$cmd = new \IWantSomeFood\Model\Command\AddNewMeal([
#    'id' => $id,
#    'title' => 'Mushroom Pizza'
#]);
#$commandBus->dispatch($cmd);

$id = '9c204006-2af9-4a05-af7a-bcaf9cafe038';
$cmd2 = new \IWantSomeFood\Model\Command\ChangeMealTitle([
    'id' => $id,
    'title' => 'Super mushroom pizza!'
]);
$commandBus->dispatch($cmd2);