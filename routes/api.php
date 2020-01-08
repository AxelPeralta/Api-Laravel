<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Rutas resiven 3 parametros 1.- Nombre del recurso en plural
// 2.- Nombre del controlador
// 3.- Array con los metodos a usar

// rutas para todo lo relacionado con compradores
Route::resource('buyers','BuyerController',['only' => ['index','show']]);
Route::resource('buyers.sellers','BuyerSellerController',['only' => ['index']]);
Route::resource('buyers.transactions','BuyerTransactionController',['only' => ['index']]);
Route::resource('buyers.categories','BuyerProductController',['only' => ['index']]);
Route::resource('buyers.products','BuyerProductController',['only' => ['index']]);
// rutas para todo lo relacionado con categorias
Route::resource('categories','CategoryController',['except' => ['create','edit']]);
Route::resource('categories.products','CategoryProductController',['only' => ['index']]);
Route::resource('categories.sellers','CategorySellerController',['only' => ['index']]);
Route::resource('categories.transactions','CategoryTransactionController',['only' => ['index']]);
Route::resource('categories.buyers','CategoryBuyerController',['only' => ['index']]);

// rutas para todo lo relacionado con productos
Route::resource('products','ProductController',['only' => ['index','show']]);
Route::resource('products.transactions','ProductTransactionController',['only' => ['index']]);
Route::resource('products.buyers','ProductBuyerController',['only' => ['index']]);
Route::resource('products.buyers.transactions','ProductBuyerTransactionController',['only' => ['store']]);
Route::resource('products.categories','ProductCategoryController',['only' => ['index','update','destroy']]);

// rutas para todo lo relacionado con vendedores
Route::resource('sellers','SellerController',['only' => ['index','show']]);
Route::resource('sellers.transactions','SellerTransactionController',['only' => ['index']]);
Route::resource('sellers.categories','SellerCategoryController',['only' => ['index']]);
Route::resource('sellers.buyers','SellerBuyerController',['only' => ['index']]);
Route::resource('sellers.products','SellerProductController',['except' => ['create','show','edit']]);
// rutas para todo lo relacionado con transacciones
Route::resource('transactions','TransactionController',['only' => ['index','show']]);
Route::resource('transactions.categories','TransactionCategoryController',['only' => ['index']]);
Route::resource('transactions.sellers','TransactionSellerController',['only' => ['index']]);
// rutas para todo lo relacionado con usuarios
Route::resource('users','UserController',['except' => ['create','edit']]);

//ruta para enviar el correo electronico
Route::get('/users/verify/{token}','UserController@verify')->name('verify');
