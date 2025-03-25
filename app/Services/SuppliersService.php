<?php

namespace App\Services;

use App\Repositories\SuppliersRepository;

/**
 * Class SuppliersService.
 */
class SuppliersService
{
    private $suppliersRepos;

    public function __construct(SuppliersRepository $suppliersRepos)
    {
        $this->suppliersRepos = $suppliersRepos;
    }
    
    public function getSuppliers()
    {
        return $this->suppliersRepos->getSuppliers();
    }

    public function getSuppliersProducts($suppliers, $params)
    {
        foreach ($params['base_item_model'] as $code) {
            $ids = $this->suppliersRepos->getSuppliersProductsIds($code);
            $count = 0;
            foreach ($suppliers as $supplier) {                    
                
                $supplier->is_supplier = false;
                if (in_array($supplier->id, $ids, true)) {
                    $supplier->is_supplier = true;
                    $count++;
                }
                $results[$code]['suppliers'][] = $supplier;
            }
            $results[$code]['count'] = $count;
        }
        return $results;
    }

    public function findOneSupplierIdById($id)
    {
        $supplier = $this->suppliersRepos->findOneSupplierIdById($id);
        return $supplier;
    }
}
