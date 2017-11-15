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
     * @param \Prooph\EventSourcing\AggregateChanged|\IWantSomeFood\Model\Event\SupplierAdded|\IWantSomeFood\Model\Event\SupplierNameChanged $event
     */
    protected function apply(\Prooph\EventSourcing\AggregateChanged $event): void
    {
        switch ($event->messageName()) {
            case \IWantSomeFood\Model\Event\SupplierAdded::class:
                $this->id = $event->id();
                $this->name = $event->name();
                break;
            case \IWantSomeFood\Model\Event\SupplierNameChanged::class:
                $this->name = $event->name();
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

    public function changeName(string $name): void
    {
        if ($name === $this->name) {
            return;
        }

        $this->recordThat(
            \IWantSomeFood\Model\Event\SupplierNameChanged::occur(
                $this->aggregateId(),
                [
                    'name' => $name,
                ]
            )
        );
    }
}
