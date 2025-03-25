<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Orders;
use App\Models\OrdersSuppliers;
//use Your Model

/**
 * Class StockRepository.
 */
class StockRepository extends BaseRepository
{
    private $ordersModel;
    private $ordersSuppliersModel;

    public function __construct(Orders $ordersModel, OrdersSuppliers $ordersSuppliersModel)
    {
        $this->ordersModel = $ordersModel;
        $this->ordersSuppliersModel = $ordersSuppliersModel;
    }
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }

    public function getOrders($params = [])
    {
        $orders = $this->ordersModel
                ->select(
                    'orders.id',
                    'orders.order_id',
                    'orders.case_id',
                    'orders.created_at',
                    'orders.users_id',
                    'orders.sender_prefecture',
                    'orders.sender_city',
                    'orders.sender_sub_address',
                    'orders.sender_address',
                    'orders.is_hurry',
                    'users.display_name AS user_name',
                    'users.code AS user_code',
                    'suppliers.id AS supplier_id',
                    'suppliers.display_name AS supplier_name',
                    'm_products.code AS product_code',
                    'orders_suppliers.id AS orders_suppliers_id',
                    'orders_suppliers.ukey',
                    'orders_suppliers.item_unit',
                    'orders_suppliers.option1',
                    'orders_suppliers.last_commented_by',
                    'orders_suppliers.updated_at AS orders_suppliers_updated_at',
                )
                ->join('orders_suppliers', 'orders_suppliers.orders_id', '=', 'orders.id')
                ->join('suppliers', 'suppliers.id', '=', 'orders_suppliers.suppliers_id')
                ->join('m_products', 'm_products.id', '=', 'orders_suppliers.m_products_id')
                ->join('users', 'users.id', '=', 'orders.users_id')
                ->with('comments')
                ->orderBy('orders.updated_at', 'DESC')
                ->get();
        
        $orders = $orders->map(function ($order) {
            $order->comments = $order->comments->map(function ($comment) {
                return [
                    'sender_id' => $comment->sender_id,
                    'sender_type' => $comment->sender_type,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at,
                ];
            });
            return $order;
        });
        return $orders;
    }

    public function getOrdersSortBySuppliers($params = [])
    {
        $orders = $this->ordersModel
                ->join('orders_suppliers', 'orders.id', '=', 'orders_suppliers.orders_id')
                ->join('suppliers', 'suppliers.id', '=', 'orders_suppliers.suppliers_id')
                ->join('m_products', 'm_products.id', '=', 'orders_suppliers.m_products_id')
                ->select(
                    //'orders.id', 'orders_suppliers.orders_id', 'orders_suppliers.suppliers_id',
                    'orders.*',
                    'orders_suppliers.*',
                    'suppliers.*',
                    'm_products.*'
                )
                ->orderBy('orders.updated_at', 'DESC')
                ->orderBy('orders_suppliers.suppliers_id', 'ASC')
                ->get();
        return $orders;
    }
}
