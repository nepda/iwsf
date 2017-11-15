<?php

declare(strict_types=1);

$commandBus = new \Prooph\ServiceBus\CommandBus();
$commandRouter = new \Prooph\ServiceBus\Plugin\Router\CommandRouter();

$commandRouter->route(\IWantSomeFood\Model\Command\AddNewMeal::class)
    ->to(new \IWantSomeFood\Model\Command\AddNewMealHandler($mealRepository));
$commandRouter->route(\IWantSomeFood\Model\Command\ChangeMealTitle::class)
    ->to(new \IWantSomeFood\Model\Command\ChangeMealTitleHandler($mealRepository));

$commandRouter->attachToMessageBus($commandBus);

