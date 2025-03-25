<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model
use App\Models\Suppliers;
use App\Models\SuppliersProducts;

/**
 * Class SuppliersProductsRepository.
 */
class SuppliersProductsRepository extends BaseRepository
{
    private $suppliersProductModel;
    priavte $suppliersModel
    
    public function __construct(SuppliersProducts $suppliersProductModel, Suppliers $suppliersModel)
    {
        $this->suppliersProductModel = $suppliersProductModel;
        $this->suppliersModel = $suppliersModel;
    }
    
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return SuppliersProducts::class;
    }
}
