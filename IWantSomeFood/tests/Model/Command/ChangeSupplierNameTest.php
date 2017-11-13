<?php

declare(strict_types=1);

namespace IWantSomeFoodTest\Model\Command;

final class ChangeSupplierNameTest extends \IWantSomeFoodTest\TestCase
{
    public function testItCreatesFromPayload()
    {
        $id = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $name = 'Chili hot!';

        $command = new \IWantSomeFood\Model\Command\ChangeSupplierName([
            'id' => $id,
            'name' => $name,
        ]);

        $this->assertSame($id, $command->id());
        $this->assertSame($name, $command->name());
    }
}
