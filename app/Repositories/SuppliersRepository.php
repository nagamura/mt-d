<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model
use App\Models\M_Products;
use App\Models\Suppliers;
use App\Models\SuppliersProducts;

/**
 * Class SuppliersRepository.
 */
class SuppliersRepository extends BaseRepository
{
    private $productsModel;
    private $suppliersModel;
    private $suppliersProductModel;

    public function __construct(
        M_Products $productsModel,
        Suppliers $suppliersModel,
        SuppliersProducts $suppliersProductModel
    )
    {
        $this->productsModel = $productsModel;
        $this->suppliersModel = $suppliersModel;
        $this->suppliersProductModel = $suppliersProductModel;
    }
    
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Suppliers::class;
    }

    public function getSuppliers()
    {
        $suppliers = $this->suppliersModel::orderBy('code', 'ASC')->get();
        return $suppliers;
    }

    private function getIds(): array
    {
        $ids = $this->suppliersModel::orderBy('code', 'ASC')->pluck('id')->toArray();
        return $ids;
    }

    public function getSuppliersProductsIds($code): array
    {
        $ids = $this->getIds();
        $productId = $this->productsModel::where('code', $code)->value('id');
        $data = $this->suppliersProductModel::whereIn('suppliers_id', $ids)
              ->where('m_products_id', $productId)
              ->orderBy('suppliers_id', 'ASC')
              ->pluck('suppliers_id')->toArray();
        return $data;
    }

    public function findOneSupplierIdById($id)
    {
        $supplier = $this->suppliersModel::where('id', $id)->first(['id']);
        return $supplier;
    }
}
