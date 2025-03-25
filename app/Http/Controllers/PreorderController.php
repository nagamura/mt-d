<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreorderController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => '操作が成功しました。'
        ], 200);
    }
    
    public function items(Request $request)
    {
        $params = [
            'file_id' => $request->fileId,
            'place' => $request->place,
            'delivery_start_at' => $request->startDate,
            'delivery_end_at' => $request->endDate,
        ];
        return response()->json([
            'params' => $params,
            'status' => 'success',
            'message' => '操作が成功しました。'
        ], 200);
    }
}
