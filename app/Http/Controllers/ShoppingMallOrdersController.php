<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreShoppingMallOrdersRequest;
use App\Models\ShoppingMallOrders;
use App\Models\Users;
use App\Models\Orders;
use App\Models\OrdersSuppliers;
use App\Models\M_Products;
use App\Models\Suppliers;
use App\Consts\ShoppingMallOrders as ShoppingMallOrdersConst;

class ShoppingMallOrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ordersService = app()->make('ShopOrdersService');
        $user = $request->session()->get('user');

        $params = [
            'shop_mall_id' => $request->shop_mall_id,
        ];
        $orders = $ordersService->getOrderWithInDays($params, ShoppingMallOrdersConst::DAY_30);
        return view('stock.dai3.index', ['orders' => $orders, 'params' => $params]);
    }

    public function search(Request $request)
    {
        $ordersService = app()->make('ShopOrdersService');
        $params = [
            'shop_mall_id' => $request->shop_mall_id,
            'ordered_at' => $request->ordered_at,
            'order_id' => $request->order_id,
            'name' => $request->name,
            'tel' => $request->tel,
            'email' => $request->email,
            'address' => $request->address,
            'item_model' => $request->item_model,
            'note' => $request->note,
        ];

        $orders = $ordersService->getOrderList($params);
        $count = $ordersService->countOrderList($params);
        //$request->session()->put('params', $params);
        return view('stock.dai3.search', ['orders' => $orders, 'count' => $count, 'params' => $params]);
    }

    public function supplier(Request $request)
    {
        $newsService = app()->make('NewsService');
        $orderService = app()->make('ShopOrdersService');
        $supplierService = app()->make('SuppliersService');
        $userService = app()->make('UsersService');
        $news = $newsService->getOneNews();
        $params = [
            'mall_name' => $request->mall_name,
            'mall_id' => $request->mall_id,
            'shop_name' => $request->shop_name,
            'order_id' => $request->order_id,
            'name' => $request->name,
            'address' => $request->address,
            'item_model' => $request->item_model,
            'base_item_model' => $request->base_item_model,
        ];
        $orders = $orderService->findOrderByOrderIdForSuppliers($params);
        $suppliers = $supplierService->getSuppliers();
        $suppliersProducts = $supplierService->getSuppliersProducts($suppliers, $params);
        $staffs = $userService->getUsersBySectionId(Auth::user()->department_sections_id);
        return view('stock.dai3.supplier', ['news' => $news, 'params' => $params, 'suppliers' => $suppliers, 'staffs' => $staffs, 'orders' => $orders, 'suppliers_products' => $suppliersProducts]);
    }

    public function confirm(Request $request)
    {
        $newsService = app()->make('NewsService');
        $orderService = app()->make('ShopOrdersService');
        $supplierService = app()->make('SuppliersService');
        $userService = app()->make('UsersService');
        $params = $request->all();
        $user = Users::where('email', $params['email'])->first();
        $news = $newsService->getOneNews();
        $suppliers = $supplierService->getSuppliers();
        return view('stock.dai3.confirm', ['user' => $user, 'news' => $news, 'params' => $params, 'suppliers' => $suppliers]);
    }

    public function send(Request $request)
    {
        $orderService = app()->make('ShopOrdersService');
        $supplierService = app()->make('SuppliersService');
        $productService = app()->make('MProductsService');
        $params = $request->all();
        $orders = $orderService->findOrdersByOrderId($params);
        $singleOrder = $orderService->findOneOrderByOrderId($params);
        $user = Auth::user();
        $longestArray = [];
        foreach ($params['suppliers'] as $array) {
            if (count($array) > count($longestArray)) {
                $longestArray = $array;
            }
        }

        $longestArray = array_values($longestArray);
        for ($i = 0; $i < count($longestArray); $i++) {
            $singleOrder->users_id = Auth::id();
            $singleOrder->is_order_status = Orders::STATUS_STOCK_IN_CONFIRM;
            $result = Orders::create($singleOrder->toArray());

            // 案件番号作成
            if (!isset($caseId)) {
                $caseId = $result->id . '-' . $user['code'];;
            }
            $result->case_id = $caseId;
            $result->save();

            // 要調整
            foreach ($orders as $k => $order) {
                if (isset($params['base_item_model'][$k])) {
                    $order->orders_id = $result->id;
                    $supplier = $supplierService->findOneSupplierIdById($longestArray[$i]);
                    $product = $productService->findOneProductIdByCode($params['base_item_model']);
                    $order->suppliers_id = $supplier->id;
                    $order->m_products_id = $product->id;
                    $order->is_order_status = OrdersSuppliers::STATUS_STOCK_IN_CONFIRM;
                    $orderSupplypResult = OrdersSuppliers::create($order->toArray());
                    unset($order->orders_id);
                    unset($order->suppliers_id);
                    unset($order->m_products_id);
                    unset($order->is_order_status);
                    $order->where('order_id', $order->order_id)->update([
                        'is_stock_confirm' => ShoppingMallOrders::IS_STOCK_CONFIRM_TRUE
                    ]);
                }
            }
        }
        return view('stock.dai3.send', []);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShoppingMallOrdersRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ShoppingMallOrders $shoppingMallOrders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShoppingMallOrders $shoppingMallOrders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShoppingMallOrdersRequest $request, ShoppingMallOrders $shoppingMallOrders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShoppingMallOrders $shoppingMallOrders)
    {
        //
    }
}
