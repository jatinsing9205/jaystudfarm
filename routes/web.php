<?php

use App\Http\Controllers\admin\reviewsController;
use App\Http\Controllers\category\categoryController;
use App\Http\Controllers\companion\companionController;
use App\Http\Controllers\exercise\exerciseController;
use App\Http\Controllers\exercise\exerciseListController;
use App\Http\Controllers\grooming\groomingController;
use App\Http\Controllers\home\homeController;
use App\Http\Controllers\login\loginController;
use App\Http\Controllers\medical\medicalController;
use App\Http\Controllers\medical\medicalListController;
use App\Http\Controllers\nutrition\nutritionController;
use App\Http\Controllers\nutrition\nutritionListController;
use App\Http\Controllers\product\productController;
use App\Http\Controllers\supplements\supplementController;
use App\Http\Controllers\supplements\supplementListController;
use App\Http\Controllers\user\userController;
use App\Http\Controllers\user\accessController;
use Illuminate\Support\Facades\Route;


Route::get('test-tailwind', function () {
    return view('test-tailwind');
});

Route::get('/login', [loginController::class, "login"])->name("login");
Route::get('/logout', [loginController::class, "logout"])->name("logout");
Route::post('/VerifyLogin', [loginController::class, "VerifyLogin"])->name("VerifyLogin");



Route::middleware(['login'])->group(function () {

    Route::get('/addCompanionNutritionView/{companionID}', function ($companionID) {
        return view('nutrition.addCompanionNutrition', compact('companionID'));
    })->name('addCompanionNutrition');

    Route::get('/', [homeController::class, "index"])->name("home");
    Route::get('testMail', [homeController::class, "testMail"])->name("testMail");

    Route::get('reviews', [reviewsController::class, "reviews"])->name("reviews");
    Route::get('loadPendingReviews', [reviewsController::class, "loadPendingReviews"])->name("loadPendingReviews");
    Route::get('loadApprovedReviews', [reviewsController::class, "loadApprovedReviews"])->name("loadApprovedReviews");
    Route::get('deleteReview/{gID}', [reviewsController::class, "deleteReview"])->name("deleteReview");
    Route::get('approveReview/{gID}', [reviewsController::class, "approveReview"])->name("approveReview");

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
    Route::get('companionLog/{companion_id}', [companionController::class, "companionLog"])->name("companionLog");

    //Add Companion Nutrition
    Route::get('addCompanionNutritionView/{companionID}', [nutritionController::class, "addCompanionNutrition"])->name('addCompanionNutrition');
    Route::post("addCompanionNutritionProcess", [nutritionController::class, "addCompanionNutritionProcess"])->name("addCompanionNutritionProcess");
    Route::get("getCompanionNutrition/{companion_id}", [nutritionController::class, "getCompanionNutrition"])->name("getCompanionNutrition");

    //Add Companion Supplements
    Route::get('addCompanionSupplementView/{companionID}', [supplementController::class, "addCompanionSupplement"])->name('addCompanionSupplement');
    Route::get("getCompanionSupplement/{companion_id}", [supplementController::class, "getCompanionSupplement"])->name("getCompanionSupplement");
    Route::post("addCompanionSupplementProcess", [supplementController::class, "addCompanionSupplementProcess"])->name("addCompanionSupplementProcess");

    //Add Companion Medicals
    Route::get('addCompanionMedicalView/{companionID}', [medicalController::class, "addCompanionMedical"])->name('addCompanionMedical');
    Route::get("getCompanionMedical/{companion_id}", [medicalController::class, "getCompanionMedical"])->name("getCompanionMedical");
    Route::post("addCompanionMedicalProcess", [medicalController::class, "addCompanionMedicalProcess"])->name("addCompanionMedicalProcess");

    //Add Companion Exercises
    Route::get('addCompanionExerciseView/{companionID}', [exerciseController::class, "addCompanionExercise"])->name('addCompanionExercise');
    Route::get("getCompanionExercise/{companion_id}", [exerciseController::class, "getCompanionExercise"])->name("getCompanionExercise");
    Route::post("addCompanionExerciseProcess", [exerciseController::class, "addCompanionExerciseProcess"])->name("addCompanionExerciseProcess");

    //Add Companion Grooming
    Route::get('addCompanionGroomingView/{companionID}', [groomingController::class, "addCompanionGrooming"])->name('addCompanionGrooming');
    Route::get("getCompanionGrooming/{companion_id}", [groomingController::class, "getCompanionGrooming"])->name("getCompanionGrooming");
    Route::post("addCompanionGroomingProcess", [groomingController::class, "addCompanionGroomingProcess"])->name("addCompanionGroomingProcess");


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
    Route::get('/getAllUsers', [userController::class, "getAllUsers"])->name("getAllUsers");
    Route::get('add-user', [userController::class, "addUser"])->name("add-user");
    Route::post('addUserProcess', [userController::class, "addUserProcess"])->name("user.add");
    Route::get('editUser/{user_id}', [userController::class, "editUser"])->name("editUser");
    Route::post('updateUserProcess', [userController::class, "updateUserProcess"])->name("user.update");
    Route::get('/deleteUser/{cID}', [userController::class, "deleteUser"])->name('user.delete');
});
