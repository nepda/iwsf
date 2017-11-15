<?php

declare(strict_types=1);

namespace IWantSomeFood\Model\Exception;

final class SupplierNotFound extends \InvalidArgumentException
{
    public static function withSupplierId(string $id)
    {
        return new self(sprintf('Supplier with id "%s" cannot be found.', $id));
    }
}
