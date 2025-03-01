<?php

use App\Http\Controllers\category\categoryController;
use App\Http\Controllers\home\homeController;
use App\Http\Controllers\login\loginController;
use App\Http\Controllers\product\productController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [loginController::class, "login"])->name("login");
Route::get('/logout', [loginController::class, "logout"])->name("logout");
Route::post('/VerifyLogin', [loginController::class, "VerifyLogin"])->name("VerifyLogin");

Route::middleware(['login'])->group(function () {

    Route::get('/', [homeController::class, "index"])->name("home");


    //category
    Route::get('/getAllCategory', [categoryController::class, "getAllCategory"])->name("getAllCategory");
    Route::get('/category', [categoryController::class, "category"])->name("category");
    Route::post('/addCategory', [categoryController::class, "addCategoryProcess"])->name("addCategoryProcess");
    Route::get('editCategory/{id}', [CategoryController::class, 'editCategory'])->name('editCategory');
    Route::post('/updateCategory/{cID}', [categoryController::class, "updateCategory"]);
    Route::get('/deleteCategory/{cID}', [categoryController::class, "deleteCategory"]);

    //products
    Route::get('/products',[productController::class,"products"])->name('products');
    Route::get('/addProduct',[productController::class,"addProduct"])->name('addProduct');
    Route::post('/addProductProcess',[productController::class,"addProductProcess"])->name('addProductProcess');

    Route::get('/updateProduct/{pID}',[productController::class,"updateProduct"])->name('updateProduct');
    Route::get('/deleteGalleryImage/{gID}', [productController::class, "deleteGalleryImage"]);



});