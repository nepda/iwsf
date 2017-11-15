<?php

declare(strict_types=1);

namespace IWantSomeFood\Model\Command;

class ChangeMealTitleHandler
{
    private $repository;

    public function __construct(\IWantSomeFood\Model\MealRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ChangeMealTitle $command)
    {
        $meal = $this->repository->get($command->id());
        if (!$meal instanceof \IWantSomeFood\Model\Meal) {
            throw \IWantSomeFood\Model\Exception\MealNotFound::withMealId($command->id());
        }
        $meal->changeTitle($command->title());
        $this->repository->save($meal);
    }
}
