<?php

namespace App\Services;

use App\Repositories\StockRepository;

/**
 * Class StockService.
 */
class StockService
{
    private $stockRepos;
    
    public function __construct(StockRepository $stockRepos)
    {
        $this->stockRepos = $stockRepos;
    }
        
    public function getOrders($params = [])
    {
        $orders = $this->stockRepos->getOrders();
        $data = [];
        foreach ($orders as $order) {
            $data[$order->id][] = $order;
        }
        return $data;
    }

    public function getOrdersSortBySuppliers($params = [])
    {
        $orders = $this->stockRepos->getOrdersSortBySuppliers();
        return $orders;
    }
}
