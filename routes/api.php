<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScategoryController;

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

// Route::post('/register', function(Request $request){
//     SuperAdmin::Create([
//         'name'=>$request->name,
//         'email' =>$request->email,
//         'password' => bcrypt($request->password),
//     ]);
//     return response('ok', 200);
// });

// Route::post('/admin/register', function(Request $request){
//     Admin::Create([
//         'name'=>$request->name,
//         'email' =>$request->email,
//         'password' => bcrypt($request->password),
//     ]);
//     return response('ok', 200);
// });


// Route::post('/user', function(Request $request){

//     $user = User::where('email', $request->email)->first();
//     //$token = $user->createToken('myappToken')->plainTextToken;
//     return response([
//         'user' =>  $user
//     ], 200);
// });

// Route::post('/admin/login', function(Request $request){

//     $user = Admin::where('email', $request->email)->first();
//     $token = $user->createToken('myappToken')->plainTextToken;
//     return response([
//         'token' => $token
//     ], 200);
// });

Route::middleware('auth:sanctum')->get('/userInfo', function (Request $request) {
    //return $request->user();
    $user = Auth()->user();
    if ($user) {
        return response([
            'user' => $user
        ], 200);
    } else {
        return response([
            'error' => 'user not found'
        ], 404);
    }
});


Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/addStoreCategory', 'App\Http\Controllers\ScategoryController@store');  //
    Route::get('/storesCategories', 'App\Http\Controllers\ScategoryController@index');
    Route::post('/deletestoreCategory', 'App\Http\Controllers\ScategoryController@destroy');
    Route::post('/updateStoreCategory', 'App\Http\Controllers\ScategoryController@update');
    Route::get('/stores', 'App\Http\Controllers\StoreController@index');
    Route::post('/createStore', 'App\Http\Controllers\StoreController@store');
    Route::post('/deleteStore', 'App\Http\Controllers\StoreController@destroy');
    Route::get('/updateStore', 'App\Http\Controllers\StoreController@show');
    Route::post('/updateStore', 'App\Http\Controllers\StoreController@update');
    Route::get('/itemsCategories', 'App\Http\Controllers\IcategoryController@index');
    Route::post('/saveItemsCategories', 'App\Http\Controllers\IcategoryController@store');
    
});

Route::get('/client/stores', 'App\Http\Controllers\StoreController@index_client');
Route::get('/client/storeCategories', 'App\Http\Controllers\StoreController@store_categories_client');
Route::get('/client/itemOptions', 'App\Http\Controllers\StoreController@item_options_client');
Route::get('/client/itemExtras','App\Http\Controllers\StoreController@item_extras_client');
Route::get('/client/variantExtras', 'App\Http\Controllers\StoreController@variant_extras_client');
Route::post('/client/order', 'App\Http\Controllers\OrderController@store');

Route::get('/getLastOrderId', 'App\Http\Controllers\OrderController@getLastOrderId');
Route::get('/getNewOrders', 'App\Http\Controllers\OrderController@getNewOrders');
