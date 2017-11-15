<?php

declare(strict_types=1);

namespace IWantSomeFood\Model\Exception;

final class MealNotFound extends \InvalidArgumentException
{
    public static function withMealId(string $id)
    {
        return new self(sprintf('Meal with id "%s" cannot be found.', $id));
    }
}
