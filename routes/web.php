<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Order;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    $user=User::all()->count();
    $order=Order::all()->count();
    $completed_order=Order::where('status',5)->count();


    return view('dashboard',[
        'user'=>$user,
        'order'=>$order,
        'completed_order'=>$completed_order,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //User Management
    Route::get('/usersList',[UserController::class,'usersList'])->name('user.list');
    Route::post('/UserDelete',[UserController::class,'UserDelete'])->name('user.delete');
    //order management
    Route::get('/Order',[OrderController::class,'OrderForm'])->name('order.form');
    Route::post('/OrderPost',[OrderController::class,'OrderPost'])->name('order.post');
    Route::get('/OrderShow',[OrderController::class,'OrderList'])->name('order.list');
    Route::get('/OrderCompletedShow',[OrderController::class,'OrderConfirmedList'])->name('order.confirm.list');
    Route::get('/StatusChange/{id}/{status}',[OrderController::class,'StatusChange'])->name('order.status');
    Route::post('/OrderDelete',[OrderController::class,'OrderDelete'])->name('order.delete');
    Route::get('/OrderView/{id}',[OrderController::class,'OrderView'])->name('order.view');
    //email
    Route::get('/EmailAdd',[OrderController::class,'EmailAdd'])->name('email.add');
    Route::post('/EmailPost',[OrderController::class,'EmailPost'])->name('email.post');
    Route::post('/EmailDelete',[UserController::class,'EmailDelete'])->name('email.delete');



//email.post



});

require __DIR__.'/auth.php';
