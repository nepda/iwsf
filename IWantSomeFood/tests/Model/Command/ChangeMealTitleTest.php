<?php

declare(strict_types=1);

namespace IWantSomeFoodTest\Model\Command;

final class ChangeMealTitleTest extends \IWantSomeFoodTest\TestCase
{
    public function testItCreatesFromPayload()
    {
        $id = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $title = 'My new pizza';

        $command = new \IWantSomeFood\Model\Command\ChangeMealTitle([
            'id' => $id,
            'title' => $title,
        ]);

        $this->assertSame($id, $command->id());
        $this->assertSame($title, $command->title());
    }
}
