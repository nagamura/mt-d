<?php

namespace App\Services;
use App\Models\M_Products;
use App\Repositories\M_ProductsRepository;

/**
 * Class M_ProductsService.
 */
class M_ProductsService
{
    private $productRepos;

    public function __construct(M_ProductsRepository $productRepos)
    {
        $this->productRepos = $productRepos;
    }

    public function findOneProductIdByCode($code)
    {
        $product = $this->productRepos->findOneProductIdByCode($code);
        return $product;
    }
}
