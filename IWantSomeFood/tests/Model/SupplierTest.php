<?php

declare(strict_types=1);

namespace IWantSomeFoodTest\Model;

class SupplierTest extends \IWantSomeFoodTest\TestCase
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    protected function setUp()
    {
        $this->id = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $this->name = 'Chili hot';
    }

    private function reconstituteSupplierFromHistory(
        \Prooph\EventSourcing\AggregateChanged ...$events
    ): \IWantSomeFood\Model\Supplier {
        return $this->reconstituteAggregateFromHistory(\IWantSomeFood\Model\Supplier::class, $events);
    }

    private function supplierAdded(): \IWantSomeFood\Model\Event\SupplierAdded
    {
        return \IWantSomeFood\Model\Event\SupplierAdded::occur(
            $this->id,
            [
                'name' => $this->name,
            ]
        );
    }

    public function testSupplierWasAdded()
    {
        $supplier = \IWantSomeFood\Model\Supplier::supplierAdded(
            $this->id,
            $this->name
        );

        /** @var \Prooph\EventSourcing\AggregateChanged[] $events */
        $events = $this->popRecordEvents($supplier);

        $this->assertCount(1, $events);

        /** @var \IWantSomeFood\Model\Event\SupplierAdded $event */
        $event = $events[0];

        $this->assertSame(\IWantSomeFood\Model\Event\SupplierAdded::class, $event->messageName());
        $this->assertSame($this->id, $event->id());
        $this->assertSame($this->name, $event->name());
    }

    public function testSupplierNameChanged()
    {
        $supplier = $this->reconstituteSupplierFromHistory(
            $this->supplierAdded()
        );

        $supplier->changeName('Chili hot!');


        /** @var \Prooph\EventSourcing\AggregateChanged[] $events */
        $events = $this->popRecordEvents($supplier);

        $this->assertCount(1, $events);

        /** @var \IWantSomeFood\Model\Event\SupplierNameChanged $event */
        $event = $events[0];

        $this->assertSame(\IWantSomeFood\Model\Event\SupplierNameChanged::class, $event->messageName());
        $this->assertSame($this->id, $event->id());
        $this->assertSame('Chili hot!', $event->name());
    }
}
