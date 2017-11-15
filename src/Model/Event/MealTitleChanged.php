<?php

declare(strict_types=1);

namespace IWantSomeFood\Model\Event;

final class MealTitleChanged extends \Prooph\EventSourcing\AggregateChanged
{
    public function id(): string
    {
        return $this->aggregateId();
    }

    public function title(): string
    {
        return $this->payload()['title'];
    }
}
