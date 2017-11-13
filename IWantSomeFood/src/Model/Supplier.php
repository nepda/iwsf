<?php

declare(strict_types=1);

namespace IWantSomeFood\Model;

final class Supplier extends \Prooph\EventSourcing\AggregateRoot
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    protected function aggregateId(): string
    {
        return $this->id;
    }

    /**
     * Apply given event
     */
    protected function apply(\Prooph\EventSourcing\AggregateChanged $event): void
    {
        switch ($event->messageName()) {
            case '':
                break;
        }
    }

    public static function supplierAdded(string $id, string $name): self
    {
        $self = new self();

        $self->recordThat(
            \IWantSomeFood\Model\Event\SupplierAdded::occur(
                $id,
                [
                    'name' => $name,
                ]
            )
        );

        return $self;
    }
}
