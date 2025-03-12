<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('v1/admin/register', [AuthController::class, 'register']);
Route::post('v1/admin/login', [AuthController::class, 'login']);
Route::post('v1/admin/logout', [AuthController::class, 'logout']);
// Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::get('v1/admin/dashboard', [DashboardController::class, 'index']);

// Route::middleware(['auth:sanctum', 'role:super_admin'])->get('/admin/dashboard', [DashboardController::class, 'index']);

// Route::middleware(('auth:sanctum'))->group(function ()
// {
//     Route::get('v1/admin/dashboard', function ()
//     {
//         return response()->json([
//             'message' => 'You are authorized to access this resource!',
//         ])->middleware('can:view_dashboard');
//     });
// });

Route::get('/test', function (Request $request) {
    return ["email"=> "m.latrach@gmail.com", "password"=> "password"];
});
