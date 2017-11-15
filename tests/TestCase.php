<?php

declare(strict_types=1);

namespace IWantSomeFoodTest;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator
     */
    private $aggregateTranslator;

    protected function popRecordEvents(\Prooph\EventSourcing\AggregateRoot $aggregateRoot): array
    {
        return $this->getAggregateTranslator()->extractPendingStreamEvents(
            $aggregateRoot
        );
    }

    protected function reconstituteAggregateFromHistory(string $aggregateRootClass, array $events)
    {
        return $this->getAggregateTranslator()->reconstituteAggregateFromHistory(
            \Prooph\EventSourcing\Aggregate\AggregateType::fromAggregateRootClass($aggregateRootClass),
            new \ArrayIterator($events)
        );
    }

    private function getAggregateTranslator(): \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator
    {
        if (null === $this->aggregateTranslator) {
            $this->aggregateTranslator = new \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator();
        }
        return $this->aggregateTranslator;
    }
}