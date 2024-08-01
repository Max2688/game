<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::get('/', [RegisterController::class, 'showRegistrationForm']);

Route::group(['middleware' => ['auth']], function () {
    Route::post('/link/generate', [LinkController::class, 'generateLink']);
    Route::post('/link/deactivate', [LinkController::class, 'deactivateLink']);
    Route::post('/link/imfeelinglucky', [LinkController::class, 'imFeelingLucky']);
    Route::get('/link/{unique_link}', [LinkController::class, 'index'])->name('link.show');
});
