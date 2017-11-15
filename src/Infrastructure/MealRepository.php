<?php

declare(strict_types=1);

namespace IWantSomeFood\Infrastructure;

class MealRepository extends \Prooph\EventSourcing\Aggregate\AggregateRepository implements
    \IWantSomeFood\Model\MealRepository
{
    public function __construct(
        \Prooph\EventStore\EventStore $eventStore
    ) {
        parent::__construct(
            $eventStore,
            \Prooph\EventSourcing\Aggregate\AggregateType::fromAggregateRootClass(\IWantSomeFood\Model\Meal::class),
            new \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator(),
            null,
            new \Prooph\EventStore\StreamName('meal')
        );
    }

    public function save(\IWantSomeFood\Model\Meal $meal): void
    {
        $this->saveAggregateRoot($meal);
    }

    public function get(string $id): ? \IWantSomeFood\Model\Meal
    {
        return $this->getAggregateRoot($id);
    }
}
