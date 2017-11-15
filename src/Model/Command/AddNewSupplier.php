<?php

declare(strict_types=1);

namespace IWantSomeFood\Model\Command;

class AddNewSupplier extends \Prooph\Common\Messaging\Command
{
    use \Prooph\Common\Messaging\PayloadTrait;

    public function id(): string
    {
        return $this->payload()['id'];
    }

    public function name(): string
    {
        return $this->payload()['name'];
    }
}
