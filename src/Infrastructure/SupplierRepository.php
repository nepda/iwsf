<?php

declare(strict_types=1);

namespace IWantSomeFood\Infrastructure;

class SupplierRepository extends \Prooph\EventSourcing\Aggregate\AggregateRepository implements
    \IWantSomeFood\Model\SupplierRepository
{
    public function __construct(
        \Prooph\EventStore\EventStore $eventStore
    ) {
        parent::__construct(
            $eventStore,
            \Prooph\EventSourcing\Aggregate\AggregateType::fromAggregateRootClass(\IWantSomeFood\Model\Supplier::class),
            new \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator(),
            null,
            new \Prooph\EventStore\StreamName('supplier')
        );
    }

    public function save(\IWantSomeFood\Model\Supplier $meal): void
    {
        $this->saveAggregateRoot($meal);
    }

    public function get(string $id): ? \IWantSomeFood\Model\Supplier
    {
        return $this->getAggregateRoot($id);
    }
}
