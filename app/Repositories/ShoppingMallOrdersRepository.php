<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model
use App\Models\ShoppingMallOrders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use App\Consts\ShoppingMallOrders as ShoppingMallOrdersConst;

/**
 * Class ShoppingMallOrdersRepository.
 */
class ShoppingMallOrdersRepository extends BaseRepository
{
    private $ordersModel;
    
    public function __construct(ShoppingMallOrders $ordersModel)
    {
        $this->ordersModel = $ordersModel;
    }
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return ShoppingMallOrders::class;
    }

    public function getItemsByOrderId($orderId)
    {
        $items = $this->ordersModel::select('item_name', 'item_model', 'item_price', 'item_unit')
               ->where('order_id', $this->order_id)
               ->get();
        
        $count = 1;
        $items->item_total_unit = 0;
        $items->item_total_price = 0;
        foreach ($items as $item) {
            $items->item_count = $count++;
            $items->item_total_unit += $item->item_unit;
            $items->item_total_price += ($item->item_price * $item->item_unit);
        }
        
        return $items;
    }

    public function findAllOrder(array $params = [])
    {
        $query = $this->setSearchParameters($params);
        $orders = $query->groupBy('order_id')->orderBy('ordered_at', 'DESC')->paginate(100);
        return $orders;
    }

    public function findOneOrderByOrderId($params)
    {
        $orders = $this->ordersModel::where('order_id', $params['order_id'])
                ->where('item_model', 'NOT LIKE', 'mitsumori%')
                ->orderBy('ordered_at', 'DESC')
                ->first();
        return $orders;
    }

    public function findOrderByOrderId(array $params)
    {
        $orders = $this->ordersModel::where('order_id', $params['order_id'])
                ->where('item_model', 'NOT LIKE', 'mitsumori%')
                ->orderBy('ordered_at', 'DESC')
                ->get();
        return $orders;
    }

    public function findOrderWithInDays(array $params = [], int $day = 30)
    {
        $query = $this->ordersModel::where('is_stock_confirm', $this->ordersModel::IS_STOCK_CONFIRM_FALSE)->where('item_model', 'NOT LIKE', 'mitsumori%');
        foreach ($this->ordersModel::EXCLUDE_ITEM_MODEL as $item) {
            $query->where('item_model', '!=',  $item);
        }
        if (!is_null($params['shop_mall_id'])) {
            $init = true;
            foreach ($params['shop_mall_id'] as $id) {
                if ($init) {
                    $query->where('shop_mall_id', $id);
                    $init = false;
                } else {
                    $query->orWhere('shop_mall_id', $id);
                }
            }
        }
        $order = $query->whereRaw("created_at >= (NOW() - INTERVAL " . $day . " DAY)")
               ->orderBy('ordered_at', 'DESC')->get();
        return $order;
    }

    public function countAllOrder(array $params = [])
    {
        $query = $this->setSearchParameters($params);
        $count = $query->distinct('order_id')->count('order_id');
        return $count;
    }

    private function setSearchParameters(array $params = [])
    {
        $query = $this->ordersModel::query();
        if (!empty($params)) {
            if (isset($params['shop_mall_id'])) {
                $query->whereIn(ShoppingMallOrdersConst::COL_SHOP_MALL_ID, $params['shop_mall_id']);
            }

            if (isset($params['ordered_at'])) {
                if (!is_null($params['ordered_at'][0]) && !is_null($params['ordered_at'][1])) {
                    $query->whereBetween('ordered_at', [$params['ordered_at'][0], $params['ordered_at'][1]]);
                }

                if (is_null($params['ordered_at'][0]) && !is_null($params['ordered_at'][1])) {
                    $query->orWhere('ordered_at', '<=', $params['ordered_at'][1]);
                }

                if (!is_null($params['ordered_at'][0]) && is_null($params['ordered_at'][1])) {
                    $query->orWhere('ordered_at', '>=', $params['ordered_at'][0]);
                }
            }

            if (isset($params['order_id'])) {
                $query->where('order_id', 'LIKE', '%' . $params['order_id'] . '%');
            }

            if (isset($params['email'])) {
                $query->where('email', 'LIKE', '%' . $params['email'] . '%');
            }

            if (isset($params['item_model'])) {
                $query->where('item_model', 'LIKE', '%' . $params['item_model'] . '%');
            }
            
            if (isset($params['note'])) {
                $query->where('note', 'LIKE', '%' . $params['note'] . '%');
            }

            if (isset($params['name'])) {
                $query->orWhereRaw(DB::raw('BINARY `name` LIKE ? COLLATE `utf8mb4_unicode_ci`'), ['%' . $params['name'] . '%']);
                $query->orWhereRaw(DB::raw('BINARY `name_kana` LIKE ? COLLATE `utf8mb4_unicode_ci`'), ['%' . $params['name'] . '%']);
                $query->orWhereRaw(DB::raw('BINARY `sender_name` LIKE ? COLLATE `utf8mb4_unicode_ci`'), ['%' . $params['name'] . '%']);
                $query->orWhereRaw(DB::raw('BINARY `sender_name_kana` LIKE ? COLLATE `utf8mb4_unicode_ci`'), ['%' . $params['name'] . '%']);
            }

            if (isset($params['tel'])) {
                $query->orWhereRaw(DB::raw('BINARY `tel` LIKE ? COLLATE `utf8mb4_unicode_ci`'), ['%' . $params['tel'] . '%']);
                $query->orWhereRaw(DB::raw('BINARY `sender_tel` LIKE ? COLLATE `utf8mb4_unicode_ci`'), ['%' . $params['tel'] . '%']);
            }

            if (isset($params['address'])) {
                $query->orWhereRaw(DB::raw('BINARY `sender_address` LIKE ? COLLATE `utf8mb4_unicode_ci`'), ['%' . $params['address'] . '%']);
                $query->orWhereRaw(DB::raw('BINARY `sender_address_kana` LIKE ? COLLATE `utf8mb4_unicode_ci`'), ['%' . $params['address'] . '%']);
            }
        }
        return $query;
    }
}
