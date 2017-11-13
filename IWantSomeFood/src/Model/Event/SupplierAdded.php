<?php

declare(strict_types=1);

namespace IWantSomeFood\Model\Event;

final class SupplierAdded extends \Prooph\EventSourcing\AggregateChanged
{
    public function id(): string
    {
        return $this->aggregateId();
    }

    public function name(): string
    {
        return $this->payload()['name'];
    }
}
