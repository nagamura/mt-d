<?php

namespace App\Services;

use App\Repositories\ShoppingMallOrdersRepository;
use App\Helpers\Helper;
use App\Consts\ShoppingMallOrders;

/**
 * Class ShoppingMallOrders.
 */
class ShoppingMallOrdersService
{
    private $ordersRepos;

    public function __construct(ShoppingMallOrdersRepository $ordersRepos)
    {
        $this->ordersRepos = $ordersRepos;
    }

    public function getOrderList(array $params = [])
    {
        //$orders = ShoppingMallOrdersRepository::findAllOrder($params);
        $orders = $this->ordersRepos->findAllOrder($params);
        return $orders;
    }

    public function countOrderList(array $params = [])
    {
        $count = $this->ordersRepos->countAllOrder($params);
        return $count;
    }

    public function findOrdersByOrderId($params)
    {
        $orders = $this->ordersRepos->findOrderByOrderId($params);
        return $orders;
    }

    public function findOneOrderByOrderId($params)
    {
        $order = $this->ordersRepos->findOneOrderByOrderId($params);
        return $order;
    }

    public function findOrderByOrderId($params)
    {
        $orders = $this->ordersRepos->findOrderByOrderId($params);
        $data = [];
        foreach ($orders as $order) {
            $order->option1 = Helper::normalizeOption1Text($order->option1);
            $order->item_model = Helper::normalizeItemModel($order->item_model);
            $order->memo = Helper::getOptionText($order->item_model, $order->option1);
            $order->base_item_model = $order->item_model;
            $data[$order->order_id][] = $order;
        }
        return $data;
    }

    public function findOrderByOrderIdForSuppliers($params)
    {
        $orders = $this->ordersRepos->findOrderByOrderId($params);
        foreach ($orders as $order) {
            $order->option1 = Helper::normalizeOption1Text($order->option1);
            $order->item_model = Helper::normalizeItemModel($order->item_model);
            $order->memo = Helper::getOptionText($order->item_model, $order->option1);
            $order->base_item_model = $order->item_model;
        }
        return $orders;
    }

    public function getOrderWithInDays(array $params = [], int $day = 30)
    {
        $orders = $this->ordersRepos->findOrderWithInDays($params, $day = 30);
        $data = [];
        foreach ($orders as $order) {
            if (!is_null($order->option1)) {
                $order->option1 = Helper::normalizeOption1Text($order->option1);
            }
            //$order->item_model = Helper::normalizeItemModel($order->item_model);
            $order->memo = Helper::getOptionText($order->item_model, $order->option1);
            $order->base_item_model = $order->item_model;
            $data[$order->order_id][] = $order;
        }
        return $data;
    }
}
