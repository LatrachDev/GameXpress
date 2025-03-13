<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user() || !$request->user()->can('view_dashboard')) 
        {
            return response()->json([
                'message' => 'You do not have permission to view the dashboard',
            ]);
        }
       
      
            return response()->json([
                'total_users' => User::count(),
                'total_products' => Product::count(),
                'total_orders' => Order::count()
            ]);
        

    }
}

