<?php

use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DistrictController;
use App\Http\Controllers\Backend\MunicipalityController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProvinceController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Backend\UnitController;
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

Auth::routes([
    'register'=>true,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::prefix('backend/')->name('backend.')->group(function(){
    Route::get('/backend/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

   Route::get('unit/trash',[UnitController::class,'trash'])->name('unit.trash');
   Route::post('unit/{id}/restore',[UnitController::class,'restore'])->name('unit.restore');
   Route::delete('unit/{id}/force-delete',[UnitController::class,'forceDelete'])->name('unit.forceDelete');
   Route::resource('unit',UnitController::class);

    Route::post('province/getDistrictByProvinceId',[ProvinceController::class,'getDistrictByProvinceId'])->name('province.getDistrict');//for ajex to get district by province id
    Route::get('province/trash',[ProvinceController::class,'trash'])->name('province.trash');
    Route::post('province/{id}/restore',[ProvinceController::class,'restore'])->name('province.restore');
    Route::delete('province/{id}/force-delete',[ProvinceController::class,'forceDelete'])->name('province.forceDelete');
    Route::resource('province', ProvinceController::class);

    Route::get('district/trash',[DistrictController::class,'trash'])->name('district.trash');
    Route::post('district/{id}/restore',[DistrictController::class,'restore'])->name('district.restore');
    Route::delete('district/{id}/force-delete',[DistrictController::class,'forceDelete'])->name('district.forceDelete');
    Route::resource('district', DistrictController::class);

    Route::get('municipality/trash',[MunicipalityController::class,'trash'])->name('municipality.trash');
    Route::post('municipality/{id}/restore',[MunicipalityController::class,'restore'])->name('municipality.restore');
    Route::delete('municipality/{id}/force-delete',[MunicipalityController::class,'forceDelete'])->name('municipality.forceDelete');
    Route::resource('municipality', MunicipalityController::class);

    Route::get('category/trash',[CategoryController::class,'trash'])->name('category.trash');
    Route::post('category/{id}/restore',[CategoryController::class,'restore'])->name('category.restore');
    Route::delete('category/{id}/force-delete',[CategoryController::class,'forceDelete'])->name('category.forceDelete');
    Route::resource('category', CategoryController::class);

    Route::get('product/trash',[ProductController::class,'trash'])->name('product.trash');
    Route::post('product/{id}/restore',[ProductController::class,'restore'])->name('product.restore');
    Route::delete('product/{id}/force-delete',[ProductController::class,'forceDelete'])->name('product.forceDelete');
    Route::resource('product', ProductController::class);

});
