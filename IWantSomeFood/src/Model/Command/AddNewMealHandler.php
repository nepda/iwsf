<?php

declare(strict_types=1);

namespace IWantSomeFood\Model\Command;

class AddNewMealHandler
{
    /**
     * @var \IWantSomeFood\Model\MealRepository
     */
    private $repository;

    /**
     * AddNewMealHandler constructor.
     *
     * @param \IWantSomeFood\Model\MealRepository $repository
     */
    public function __construct(\IWantSomeFood\Model\MealRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(\IWantSomeFood\Model\Command\AddNewMeal $command)
    {
        $meal = \IWantSomeFood\Model\Meal::mealAdded($command->id(), $command->title());
        $this->repository->save($meal);
    }
}
