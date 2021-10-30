<?php

use App\Http\Controllers\V1\TagController as TagControllerV1;
use App\Http\Controllers\V2\TagController as TagControllerV2;
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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/v1/tags', [TagControllerV1::class, 'store'])->name('v1.tags.store');
Route::post('/v2/tags', [TagControllerV2::class, 'store'])->name('v2.tags.store');
