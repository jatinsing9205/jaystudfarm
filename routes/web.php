<?php

use App\Http\Controllers\category\categoryController;
use App\Http\Controllers\companion\companionController;
use App\Http\Controllers\exercise\exerciseListController;
use App\Http\Controllers\home\homeController;
use App\Http\Controllers\login\loginController;
use App\Http\Controllers\medical\medicalListController;
use App\Http\Controllers\nutrition\nutritionListController;
use App\Http\Controllers\product\productController;
use App\Http\Controllers\supplements\supplementListController;
use App\Http\Controllers\user\userController;
use App\Http\Controllers\user\accessController;
use Illuminate\Support\Facades\Route;



Route::get('/login', [loginController::class, "login"])->name("login");
Route::get('/logout', [loginController::class, "logout"])->name("logout");
Route::post('/VerifyLogin', [loginController::class, "VerifyLogin"])->name("VerifyLogin");



Route::middleware(['login'])->group(function () {

    Route::get('/', [homeController::class, "index"])->name("home");

    //Companion 
    Route::get("companions", [companionController::class, "companions"])->name('companions');
    Route::get("viewCompanion/{cID}", [companionController::class, "viewCompanion"])->name("viewCompanion");
    Route::get("addCompanion", [companionController::class, "addCompanion"])->name('addCompanion');
    Route::post("addCompanionProcess", [companionController::class, "addCompanionProcess"])->name("addCompanionProcess");
    Route::get("updateCompanion/{cID}", [companionController::class, "updateCompanion"])->name("updateCompanion");
    Route::post("updateCompanionProcess/{companion_id}", [companionController::class, "updateCompanionProcess"])->name("updateCompanionProcess");
    Route::get("deleteGalleryImage/{gId}", [companionController::class, "deleteGalleryImage"]);
    Route::get("deleteGalleryVideo/{gId}", [companionController::class, "deleteGalleryVideo"]);
    Route::get("deleteDamSire/{dsId}", [companionController::class, "deleteDamSire"]);

    
    //category
    Route::get('/getAllCategory', [categoryController::class, "getAllCategory"])->name("getAllCategory");
    Route::get('/category', [categoryController::class, "category"])->name("category");
    Route::post('/addCategory', [categoryController::class, "addCategoryProcess"])->name("addCategoryProcess");
    Route::get('editCategory/{id}', [CategoryController::class, 'editCategory'])->name('editCategory');
    Route::post('/updateCategory/{cID}', [categoryController::class, "updateCategory"]);
    Route::get('/deleteCategory/{cID}', [categoryController::class, "deleteCategory"]);

    //products
    Route::get('/products', [productController::class, "products"])->name('products');
    Route::get('/addProduct', [productController::class, "addProduct"])->name('addProduct');
    Route::post('/addProductProcess', [productController::class, "addProductProcess"])->name('addProductProcess');
    Route::get('/updateProduct/{pID}', [productController::class, "updateProduct"])->name('updateProduct');
    Route::get('/deleteGalleryImage/{gID}', [productController::class, "deleteGalleryImage"]);

    //Supplement List
    Route::get('/supplement', [supplementListController::class, "supplement"])->name("supplement");
    Route::get('/getAllSupplements', [supplementListController::class, "getAllSupplements"])->name("getAllSupplements");
    Route::post('/addSupplementListProcess', [supplementListController::class, "addSupplementListProcess"])->name("addSupplementListProcess");
    Route::get('editSupplement/{id}', [supplementListController::class, 'editSupplement'])->name('editSupplement');
    Route::post('/updateSupplementListProcess/{cID}', [supplementListController::class, "updateSupplementListProcess"]);
    Route::get('/deleteSupplement/{cID}', [supplementListController::class, "deleteSupplement"]);

    //Nutrition List
    Route::get('/nutrition', [nutritionListController::class, "nutrition"])->name("nutrition");
    Route::get('/getAllNutritions', [nutritionListController::class, "getAllNutritions"])->name("getAllNutritions");
    Route::post('/addNutritionListProcess', [nutritionListController::class, "addNutritionListProcess"])->name("addNutritionListProcess");
    Route::get('editNutrition/{id}', [nutritionListController::class, 'editNutrition'])->name('editNutrition');
    Route::post('/updateNutritionListProcess/{cID}', [nutritionListController::class, "updateNutritionListProcess"]);
    Route::get('/deleteNutrition/{cID}', [nutritionListController::class, "deleteNutrition"]);

    //Medical List
    Route::get('/medical', [medicalListController::class, "medical"])->name("medical");
    Route::get('/getAllMedicals', [medicalListController::class, "getAllMedicals"])->name("getAllMedicals");
    Route::post('/addMedicalListProcess', [medicalListController::class, "addMedicalListProcess"])->name("addMedicalListProcess");
    Route::get('editMedical/{id}', [medicalListController::class, 'editMedical'])->name('editMedical');
    Route::post('/updateMedicalListProcess/{cID}', [medicalListController::class, "updateMedicalListProcess"]);
    Route::get('/deleteMedical/{cID}', [medicalListController::class, "deleteMedical"]);

    //Exercise List
    Route::get('/exercise', [exerciseListController::class, "exercise"])->name("exercise");
    Route::get('/getAllExercises', [exerciseListController::class, "getAllExercises"])->name("getAllExercises");
    Route::post('/addExerciseListProcess', [exerciseListController::class, "addExerciseListProcess"])->name("addExerciseListProcess");
    Route::get('editExercise/{id}', [exerciseListController::class, 'editExercise'])->name('editExercise');
    Route::post('/updateExerciseListProcess/{cID}', [exerciseListController::class, "updateExerciseListProcess"]);
    Route::get('/deleteExercise/{cID}', [exerciseListController::class, "deleteExercise"]);

    //Access 
    Route::get('/access', [accessController::class, "access"])->name("access");
    Route::get('/getAllAccess', [accessController::class, "getAllAccess"])->name("getAllAccess");
    Route::post('/addAccessProcess', [accessController::class, "addAccessProcess"])->name("addAccessProcess");
    Route::get('editAccess/{id}', [accessController::class, 'editAccess'])->name('editAccess');
    Route::post('/updateAccessProcess/{cID}', [accessController::class, "updateAccessProcess"]);
    Route::get('/deleteAccess/{cID}', [accessController::class, "deleteAccess"]);

    //Users
    Route::get('/users', [userController::class, "users"])->name("users");

});