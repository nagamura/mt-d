<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrdersSuppliers;

class StockController extends Controller
{
    public function admin(Request $request)
    {
        $supplierService = app()->make('SuppliersService');
        $stockService = app()->make('StockService');
        $suppliers = $supplierService->getSuppliers();
        $ordersList = $stockService->getOrders($params = []);
        return view('stock.admin', ['suppliers' => $suppliers, 'ordersList' => $ordersList]);
    }

    public function form(Request $request)
    {
        return view('stock.form', []);
    }

    public function posts(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => '操作が成功しました。'
        ], 200);
    }

    public function items(Request $request)
    {
        if ($request->isMethod('post')) {
            return response()->json([
                'method' => $request->method(),
                'status' => 'success',
                'message' => '操作が成功しました。'
            ], 200);
        }

        if ($request->isMethod('patch')) {
            return response()->json([
                'method' => $request->method(),
                'status' => 'success',
                'message' => '操作が成功しました。'
            ], 200);
        }
        
    }

    public function notify(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => '操作が成功しました。'
        ], 200);
    }
}
