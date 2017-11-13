<?php

declare(strict_types=1);

namespace IWantSomeFood\Model\Command;

class AddNewMeal extends \Prooph\Common\Messaging\Command
{
    use \Prooph\Common\Messaging\PayloadTrait;

    public function id(): string
    {
        return $this->payload()['id'];
    }

    public function title(): string
    {
        return $this->payload()['title'];
    }
}
