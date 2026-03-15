<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderFieldController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Order;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    $currentUser = Auth::user();
    $isAdmin = in_array((int) $currentUser->role, [0, 1], true);

    $user = $isAdmin ? User::count() : 1;
    $order = $isAdmin
        ? Order::count()
        : Order::where('added_by', $currentUser->id)->count();
    $completed_order = $isAdmin
        ? Order::where('status', 5)->count()
        : Order::where('added_by', $currentUser->id)->where('status', 5)->count();


    return view('dashboard',[
        'isAdmin' => $isAdmin,
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
    Route::get('/OrderFields', [OrderFieldController::class, 'index'])->name('order.fields');
    Route::post('/OrderFields', [OrderFieldController::class, 'store'])->name('order.fields.store');
    Route::patch('/OrderFields/{orderField}/toggle-active', [OrderFieldController::class, 'toggleActive'])->name('order.fields.toggle-active');
    Route::delete('/OrderFields/{orderField}', [OrderFieldController::class, 'destroy'])->name('order.fields.delete');
    //email
    Route::get('/EmailAdd',[OrderController::class,'EmailAdd'])->name('email.add');
    Route::post('/EmailPost',[OrderController::class,'EmailPost'])->name('email.post');
    Route::post('/EmailDelete',[UserController::class,'EmailDelete'])->name('email.delete');



//email.post



});

require __DIR__.'/auth.php';
