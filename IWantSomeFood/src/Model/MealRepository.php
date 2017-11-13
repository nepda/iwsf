<?php

declare(strict_types=1);

namespace IWantSomeFood\Model;

interface MealRepository
{
    public function save(Meal $meal): void;

    public function get(string $id): ?Meal;
}
