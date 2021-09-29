<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\front\LandingPage;
use App\Http\Controllers\admin\productManagement\categories\CategoryController;
use App\Http\Controllers\admin\productManagement\orders\OrderController;
use App\Http\Controllers\admin\productManagement\products\ProductController;
use App\Http\Controllers\admin\TwoFactorAuthenticatedSessionController;
use App\Http\Controllers\admin\Profile\UserProfileController;
use App\Http\Controllers\MyFatoorahController;
use App\Http\Livewire\Admin\ProductsManagement\Activities\Activities;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Livewire\Admin\ProductsManagement\Categories\Categories;
use App\Http\Livewire\Admin\ProductsManagement\Customers\Customers;
use App\Http\Livewire\Admin\ProductsManagement\Delivery\DeliverySerivceProvider;
use App\Http\Livewire\Admin\ProductsManagement\Orders\Orders;
use App\Http\Livewire\Admin\ProductsManagement\Settings\Settings;
use App\Http\Livewire\Admin\ProductsManagement\Products\Products;
use App\Http\Livewire\Admin\ProductsManagement\RecycleBin\MainController;
use App\Http\Livewire\Admin\ProductsManagement\Refunds\Refunds;
use App\Http\Livewire\Admin\ProductsManagement\Shipping\ShippingCosts;
use App\Http\Livewire\Admin\ProductsManagement\Taxes\Taxes;
use App\Http\Livewire\Admin\ProductsManagement\Vendors\Vendors;
use App\Http\Livewire\Front\Register;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return redirect('/'. app()->getLocale());
})->middleware('guest');




Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function(){ //...
    //front landing page

    Route::get('/',[LandingPage::class,'index'])->name('front.index');
    Route::get('/register',Register::class)->name('front.register')->middleware('guest');


    //login
    Route::get('/admin', function () {
        return view('admin.auth.login');
    })->middleware('guest');
    Route::get('/admin/login',[AuthController::class,'index'])->name('index');
    Route::post('/admin/login',[AuthController::class,'login'])->name('login')->middleware("throttle:6,2");


   //login super_admin
   Route::get('/super_admin', function () {
    return view('admin.auth.login_super_admin');
})->middleware('guest');
   Route::get('/super_admin/login',[AuthController::class,'index_super_admin'])->name('index_super_admin');
   Route::post('/super_admin/login',[AuthController::class,'login_super_admin'])->name('login_super_admin')->middleware("throttle:6,2");


   //payment
//    Route::get('/payment', [MyFatoorahController::class, 'index']);
   Route::get('/payment/callback', [MyFatoorahController::class, 'callback'])->name('payment_callback');
   Route::get('/payment/error', [MyFatoorahController::class, 'error'])->name('payment_error');


    //forget password
    Route::get('/admin/ForgetPassword',[AuthController::class,'viewForget'])->name('viewForget');
    Route::post('/admin/ForgetPassword',[AuthController::class,'messageAfterSendingEmailToResetPassword'])->name('sendEmail');
    Route::get('/admin/reset-password/{_token}',[AuthController::class,'viewResetPassword'])->name('viewResetPassword');
    Route::post('/admin/reset-password',[AuthController::class,'changePassword'])->name('changePassword');

    //two factor Auth
    Route::post('/admin/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])->middleware(array_filter(['guest', 'throttle:6,2']))->name('two-factor.login');

    Route::group(['prefix'=>'admin','middleware' => 'Auth'],function(){
        Route::post('/logout',[AuthController::class,'logout'])->name('logout');
        Route::get('/dashboard_for_app',[AdminController::class,'index_for_app'])->name('admin.index_for_app')->middleware('can:isAdmin');
        Route::get('/dashboard',[AdminController::class,'index'])->name('admin.index');
        Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');
        Route::get('/categories', Categories::class)->name('admin.categories')->middleware('can:isAdmin');
        Route::get('/shipping', ShippingCosts::class)->name('admin.shipping')->middleware('can:isAdmin');
        Route::get('/taxes', Taxes::class)->name('admin.taxes')->middleware('can:isAdmin');
        Route::get('/activities', Activities::class)->name('admin.activities');
        Route::get('/refunds', Refunds::class)->name('admin.refunds');
        Route::get('/customers', Customers::class)->name('admin.customers')->middleware('can:isAdmin');
        Route::get('/deliverySerivceProvider', DeliverySerivceProvider::class)->name('admin.deliveryServiceProvider')->middleware('can:isAdmin');
        Route::get('/vendors', Vendors::class)->name('admin.vendors')->middleware('can:isAdmin');
        Route::get('/category/{category}-{slug}', [CategoryController::class,'show'])->name('category.show')->middleware('can:isAdmin');
        Route::get('/products', Products::class)->name('admin.products');
        Route::get('/product-add', [ProductController::class,'addNewProduct'])->middleware('can:create,App\Models\Product');
        Route::get('/products-update/{product}-{slug}', [ProductController::class,'updateProduct'])->middleware('can:update,product');
        Route::get('/product-details/{product}-{slug}', [ProductController::class,'show']);

        Route::get('/orders', Orders::class)->name('admin.orders');
        Route::get('/payment_token',Settings::class)->name('admin.settings')->middleware('can:isAdmin');
        Route::get('/order/show/{order}', [OrderController::class,'show'])->name('order.show')->middleware('can:show-order,order');

        Route::get('/recycle_bin', MainController::class)->name('admin.recycleBin');

    });
});
