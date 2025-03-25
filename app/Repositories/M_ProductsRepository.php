<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model
use App\Models\M_Products;

/**
 * Class M_ProductsRepository.
 */
class M_ProductsRepository extends BaseRepository
{
    private $productsModel;
    
    public function __construct(M_Products $productsModel)
    {
        $this->productsModel = $productsModel;
    }

    public function model()
    {
        //return YourModel::class;
    }

    public function findOneProductIdByCode($code)
    {
        $product = $this->productsModel::where('code', $code)->first(['id']);
        return $product;
    }
}
