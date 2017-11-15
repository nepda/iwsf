<?php

declare(strict_types=1);

namespace IWantSomeFood\Model\Command;

class AddNewSupplierHandler
{
    /**
     * @var \IWantSomeFood\Model\SupplierRepository
     */
    private $repository;

    public function __construct(\IWantSomeFood\Model\SupplierRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(AddNewSupplier $command): void
    {
        $supplier = \IWantSomeFood\Model\Supplier::supplierAdded($command->id(), $command->name());
        $this->repository->save($supplier);
    }
}