<?php

declare(strict_types=1);

$commandBus = new \Prooph\ServiceBus\CommandBus();
$commandRouter = new \Prooph\ServiceBus\Plugin\Router\CommandRouter();

// Meals
$commandRouter->route(\IWantSomeFood\Model\Command\AddNewMeal::class)
    ->to(new \IWantSomeFood\Model\Command\AddNewMealHandler($mealRepository));
$commandRouter->route(\IWantSomeFood\Model\Command\ChangeMealTitle::class)
    ->to(new \IWantSomeFood\Model\Command\ChangeMealTitleHandler($mealRepository));

// Supplier
$commandRouter->route(\IWantSomeFood\Model\Command\AddNewSupplier::class)
    ->to(new \IWantSomeFood\Model\Command\AddNewSupplierHandler($supplierRepository));
$commandRouter->route(\IWantSomeFood\Model\Command\ChangeSupplierName::class)
    ->to(new \IWantSomeFood\Model\Command\ChangeSupplierNameHandler($supplierRepository));

$commandRouter->attachToMessageBus($commandBus);
