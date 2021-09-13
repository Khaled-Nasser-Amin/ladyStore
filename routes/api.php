<?php

use App\Http\Controllers\Api\delivery_service_provider\AuthController as  DeliveryAuthController;
use App\Http\Controllers\Api\delivery_service_provider\ProfileController as DeliveryProfileController;


use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Category_ProductsController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\WishListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['Auth:customer_api','scope:customer'])->post('/user', function (Request $request) {
    return response()->json($request->user(),200);
});




Route::middleware(['Auth:delivery_service_provider_api','scope:delivery'])->post('/delivery_service_provider', function (Request $request) {
    return response()->json($request->user(),200);
});










//Routes for user
Route::group(['prefix' => 'user'],function (){

    Route::post('/resend-code',[AuthController::class,'resend'])->middleware('throttle:5,1');


    //register
    Route::post('/active-account',[AuthController::class,'activeAccount'])->middleware('throttle:5,1');
    Route::post('/register',[AuthController::class,'store']);

    //login
    Route::post('/login',[AuthController::class,'login'])->middleware('throttle:5,1');
    Route::post('/logout',[AuthController::class,'logout']);


    Route::post('/token',function(){
            return 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI1IiwianRpIjoiNjY0Y2YyZDIxMTQ5NjU4YjU0OTIxYjJmYTZjNmYzMTc4ZmI3YzI1OTY1M2FhYmIzMTc5ODZjYjMyMDM1Yjc2YjM3YWU4YjkzMGM3MTYzYjQiLCJpYXQiOjE2MzE0NTg0NjUuODE5MTE1LCJuYmYiOjE2MzE0NTg0NjUuODE5MTIzLCJleHAiOjE2NjI5OTQ0NjUuODExMDA3LCJzdWIiOiIxIiwic2NvcGVzIjpbImN1c3RvbWVyIl19.uPD1I6aYjVAtSWI2tHXs8t5qlmHORRdY9jjeXFzWLoDocOVUaVJCfTCfkQGuRKYxsja00YMIrdDuyXTVrkhc1b0G_Oz3ToBXt84vSOpExASU4NJimg7bqTSc7t-Z4m4LxLyqz4xyAQS8LsHjHOn7mMmTuuyShKBAyrDUEXTBtRyGJ89OPpu3sB18t_OqcW-MmXSyFp1EPi5n_vHVuhSnciBMeuMiAT_ygCvL1E04mZlTFHzoxcLbTx48bGcChL5zX2SOmHoCI1zNCXQegZSpyTtR4NfMtUGY6rJzwFNnYM3XOTrzA5qvIiLnAqVYM9arv6edkgku1YqsfnV45vNqzwvy_kPBNIKPuCb0hXZViLrGmNcPlqpg3D1s7OUZ5DYR2IcPMXWS-_f08jmjd8kegXyJut_gkXpB6-Q9OTeIhtk8cookZHXhqYHXBPDjXUSz_LOAvyvQW3k5DvIgOXXqZnkxV3PfRg-RQXYL1VQZ0eanvqxwJI-RXAt2c9QdsJOS36AVN4oOmcJTlQRZ05SbwuWCh-V8bcD7uEqN2_wp82bRFCjWE40__JtcCmRL-Q5v7uM6j_VStU0l-mULSUoId7a3shwkd3srUSHsXvOWUAgY5W4Gs71akvLy38YCAFGkF1EssXuIJi85RuGZUcwEK52pJYNQqlPxtpcxYQck6Hk';
    });

    //change passowrd
    Route::post('/forget-password',[AuthController::class,'forgetPassword'])->middleware('throttle:5,1');
    Route::post('/check-otp',[AuthController::class,'checkOtp'])->middleware('throttle:5,1');
    Route::post('/change-password',[AuthController::class,'changePassword'])->middleware('throttle:5,1');



    Route::group(['middleware' => ['Auth:customer_api','scope:customer']],function (){
        //products
        Route::post('/product',[Category_ProductsController::class,'product']);


        //categories
        Route::post('/categories',[Category_ProductsController::class,'parent_categories']);
        Route::post('/category',[Category_ProductsController::class,'category_products']);


        //reviews
        Route::post('/review',[ReviewController::class,'review']);
        Route::post('/all_reviews',[ReviewController::class,'return_reviews']);


        //favorites
        Route::post('/favorite',[WishListController::class,'updateWishList']);


        //orders
        Route::post('/order',[OrderController::class,'store']);
        Route::post('/cancel_order',[OrderController::class,'cancel_order']);
        Route::post('/check_stock',[OrderController::class,'check_stock']);


        //profile
        Route::post('/change_image',[ProfileController::class,'changeImage']);
        Route::post('/change_name',[ProfileController::class,'changeName']);
        Route::post('/change_email',[ProfileController::class,'changeEmail']);
        Route::post('/check_email_otp',[ProfileController::class,'checkEmailOtp'])->middleware('throttle:5,1');
        Route::post('/change_phone',[ProfileController::class,'changePhone']);
        Route::post('/check_phone_otp',[ProfileController::class,'checkPhoneOtp'])->middleware('throttle:5,1');
        Route::post('/change_password',[ProfileController::class,'changePassword']);
        Route::post('/resend_otp',[ProfileController::class,'resend'])->middleware('throttle:5,1');

    });

});











//Routes for Delivery service provider
Route::group(['prefix' => 'delivery_service_provider'],function (){
    Route::post('/resend-code',[DeliveryAuthController::class,'resend'])->middleware('throttle:5,1');

    //register
    Route::post('/active-account',[DeliveryAuthController::class,'activeAccount'])->middleware('throttle:5,1');
    Route::post('/register',[DeliveryAuthController::class,'store']);

    //login
    Route::post('/login',[DeliveryAuthController::class,'login'])->middleware('throttle:5,1');
    Route::post('/logout',[DeliveryAuthController::class,'logout']);


    //change passowrd
    Route::post('/forget-password',[DeliveryAuthController::class,'forgetPassword'])->middleware('throttle:5,1');
    Route::post('/check-otp',[DeliveryAuthController::class,'checkOtp'])->middleware('throttle:5,1');
    Route::post('/change-password',[DeliveryAuthController::class,'changePassword'])->middleware('throttle:5,1');



    Route::group(['middleware' => ['Auth:delivery_service_provider_api','scope:delivery']],function (){

        //orders
        Route::post('/order',[OrderController::class,'store']);


        //profile
        Route::post('/change_image',[DeliveryProfileController::class,'changeImage']);
        Route::post('/change_personal_id',[DeliveryProfileController::class,'changePersonalId']);
        Route::post('/change_driving_license',[DeliveryProfileController::class,'changeDrivingLicense']);
        Route::post('/change_name',[DeliveryProfileController::class,'changeName']);
        Route::post('/change_email',[DeliveryProfileController::class,'changeEmail']);
        Route::post('/check_email_otp',[DeliveryProfileController::class,'checkEmailOtp'])->middleware('throttle:5,1');
        Route::post('/change_phone',[DeliveryProfileController::class,'changePhone']);
        Route::post('/check_phone_otp',[DeliveryProfileController::class,'checkPhoneOtp'])->middleware('throttle:5,1');
        Route::post('/change_password',[DeliveryProfileController::class,'changePassword']);
        Route::post('/resend_otp',[DeliveryProfileController::class,'resend'])->middleware('throttle:5,1');

    });

});
