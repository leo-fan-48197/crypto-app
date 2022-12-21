<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoinController;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [CoinController::class, 'index']);
Route::get('/coins/{coin}', [CoinController::class, 'show']);
Route::get('/coins/{coin}/buy', [CoinController::class, 'buy']);
Route::post('/coins/{coin}/buy', [CoinController::class, 'store']);