<?php

declare(strict_types=1);

namespace IWantSomeFood\Model\Command;

class ChangeSupplierNameHandler
{
    /**
     * @var \IWantSomeFood\Model\SupplierRepository
     */
    private $repository;

    public function __construct(\IWantSomeFood\Model\SupplierRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ChangeSupplierName $command)
    {
        $supplier = $this->repository->get($command->id());
        if (!$supplier instanceof \IWantSomeFood\Model\Supplier) {
            throw \IWantSomeFood\Model\Exception\SupplierNotFound::withSupplierId($command->id());
        }
        $supplier->changeName($command->name());
        $this->repository->save($supplier);
    }
}
