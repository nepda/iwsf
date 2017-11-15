<?php

declare(strict_types=1);

namespace IWantSomeFood\Model;

interface SupplierRepository
{
    public function save(Supplier $supplier): void;

    public function get(string $id): ?Supplier;
}
