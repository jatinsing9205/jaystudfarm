<?php

use App\Http\Controllers\admin\reviewsController;
use App\Http\Controllers\category\categoryController;
use App\Http\Controllers\companion\bodyweightController;
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
use App\Http\Controllers\permissionsController;
use App\Http\Controllers\pregnancy\pregnancyController;
use App\Http\Controllers\product\productController;
use App\Http\Controllers\supplements\supplementController;
use App\Http\Controllers\supplements\supplementListController;
use App\Http\Controllers\user\userController;
use App\Http\Controllers\user\accessController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


Route::get('/login', [loginController::class, "login"])->name("login");
Route::get('/logout', [loginController::class, "logout"])->name("logout");
Route::post('/VerifyLogin', [loginController::class, "VerifyLogin"])->name("login.verify");



Route::middleware(['loginCheck'])->group(function () {

    Route::get('/', [homeController::class, "index"])->name("home");
    Route::get('testMail', [homeController::class, "testMail"])->name("testMail");

    Route::get('reviews', [reviewsController::class, "reviews"])->name("reviews");
    Route::get('loadPendingReviews', [reviewsController::class, "loadPendingReviews"])->name("loadPendingReviews");
    Route::get('loadApprovedReviews', [reviewsController::class, "loadApprovedReviews"])->name("loadApprovedReviews");
    Route::get('deleteReview/{gID}', [reviewsController::class, "deleteReview"])->name("deleteReview");
    Route::get('approveReview/{gID}', [reviewsController::class, "approveReview"])->name("approveReview");

    //Companion
    Route::group(['prefix' => 'companions'], function () {
        Route::get("/", [companionController::class, "companions"])->name('companions.view');
        Route::get("/view/{cID}", [companionController::class, "viewCompanion"])->name("companions.details");
        Route::get("/add", [companionController::class, "addCompanion"])->name('companions.add');
        Route::post("add", [companionController::class, "addCompanionProcess"])->name("companions.store");
        Route::get("/edit/{cID}", [companionController::class, "updateCompanion"])->name("companions.edit");
        Route::post("update/{companion_id}", [companionController::class, "updateCompanionProcess"])->name("companions.update");
        Route::get("deleteGalleryImage/{gId}", [companionController::class, "deleteGalleryImage"])->name("companions.deleteGalleryImage");
        Route::get("deleteGalleryVideo/{gId}", [companionController::class, "deleteGalleryVideo"])->name("companions.deleteGalleryVideo");
        Route::get("deleteDamSire/{dsId}", [companionController::class, "deleteDamSire"])->name("companions.deleteDamSire");
        Route::get('companionLog/{companion_id}', [companionController::class, "companionLog"])->name("companions.log");
    });
    Route::get('/getExpectedDates/{companion_id}', [companionController::class, "getExpectedDates"])->name("getExpectedDates");


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

    //Add Companion Bodyweight
    Route::get('addCompanionBodyweightView/{companionID}', [bodyweightController::class, "addCompanionBodyweight"])->name('addCompanionBodyweight');
    Route::get("getCompanionBodyweight/{companion_id}", [bodyweightController::class, "getCompanionBodyweight"])->name("getCompanionBodyweight");
    Route::post("addCompanionBodyweightProcess", [bodyweightController::class, "addCompanionBodyweightProcess"])->name("addCompanionBodyweightProcess");

    //Add Companion Pregnancy
    Route::get('addCompanionPregnancyView/{companionID}', [pregnancyController::class, "addCompanionPregnancy"])->name('addCompanionPregnancy');
    Route::get("getCompanionPregnancy/{companion_id}", [pregnancyController::class, "getCompanionPregnancy"])->name("getCompanionPregnancy");
    Route::post("addCompanionPregnancyProcess", [pregnancyController::class, "addCompanionPregnancyProcess"])->name("addCompanionPregnancyProcess");

    //category
    Route::group(['prefix' => 'category'], function () {
        Route::get('/json', [categoryController::class, "getAllCategory"])->name("category.getJSON");
        Route::get('/', [categoryController::class, "category"])->name("category.view");
        Route::post('/add', [categoryController::class, "addCategoryProcess"])->name("category.add");
        Route::get('edit/{id}', [CategoryController::class, 'editCategory'])->name('category.edit');
        Route::post('/update/{cID}', [categoryController::class, "updateCategory"])->name("category.update");
        Route::get('/delete/{cID}', [categoryController::class, "deleteCategory"])->name("category.delete");
    });


    //Supplement List
    Route::group(['prefix' => 'supplements'], function () {
        Route::get('/json', [supplementListController::class, "getAllSupplements"])->name("supplements.getJSON");
        Route::get('/', [supplementListController::class, "supplement"])->name("supplements.view");
        Route::post('/store', [supplementListController::class, "addSupplementListProcess"])->name("supplements.store");
        Route::get('/edit/{id}', [supplementListController::class, 'editSupplement'])->name('supplements.edit');
        Route::post('/update/{cID}', [supplementListController::class, "updateSupplementListProcess"])->name("supplements.update");
        Route::get('/delete/{cID}', [supplementListController::class, "deleteSupplement"])->name("supplements.delete");
    });


    //Nutrition List
    Route::group(['prefix' => 'nutritions'], function () {
        Route::get('/json', [nutritionListController::class, "getAllNutritions"])->name("nutritions.getJSON");
        Route::get('/', [nutritionListController::class, "nutrition"])->name("nutritions.view");
        Route::post('/store', [nutritionListController::class, "addNutritionListProcess"])->name("nutritions.store");
        Route::get('/edit/{id}', [nutritionListController::class, 'editNutrition'])->name('nutritions.edit');
        Route::post('/update/{cID}', [nutritionListController::class, "updateNutritionListProcess"])->name("nutritions.update");
        Route::get('/delete/{cID}', [nutritionListController::class, "deleteNutrition"])->name("nutritions.delete");
    });


    //Medical List
    Route::group(['prefix' => 'medicals'], function () {
        Route::get('/json', [medicalListController::class, "getAllMedicals"])->name("medicals.getJSON");
        Route::get('/', [medicalListController::class, "medical"])->name("medicals.view");
        Route::post('/store', [medicalListController::class, "addMedicalListProcess"])->name("medicals.store");
        Route::get('/edit/{id}', [medicalListController::class, 'editMedical'])->name('medicals.edit');
        Route::post('/update/{cID}', [medicalListController::class, "updateMedicalListProcess"])->name("medicals.update");
        Route::get('/deleteMedical/{cID}', [medicalListController::class, "deleteMedical"])->name("medicals.delete");
    });

    //Exercise List
    Route::group(['prefix' => 'exercises'], function () {
        Route::get('/json', [exerciseListController::class, "getAllExercises"])->name("exercises.getJSON");
        Route::get('/', [exerciseListController::class, "exercise"])->name("exercises.view");
        Route::post('/store', [exerciseListController::class, "addExerciseListProcess"])->name("exercises.store");
        Route::get('/edit/{id}', [exerciseListController::class, 'editExercise'])->name('exercises.edit');
        Route::post('/update/{cID}', [exerciseListController::class, "updateExerciseListProcess"])->name("exercises.update");
        Route::get('/delete/{cID}', [exerciseListController::class, "deleteExercise"])->name("exercises.delete");
    });


    Route::middleware(['verifyAccess:Admin'])->group(function () {
        //Access 
        Route::group(['prefix' => 'access'], function () {
            Route::get('/', [accessController::class, "access"])->name("access.view");
            Route::get('/json', [accessController::class, "getAllAccess"])->name("access.getJSON");
            Route::get('/add', [accessController::class, "addAccess"])->name("access.add");
            Route::post('/store', [accessController::class, "addAccessProcess"])->name("access.store");
            Route::get('/edit/{id}', [accessController::class, 'editAccess'])->name('access.edit');
            Route::post('/update/{cID}', [accessController::class, "updateAccessProcess"])->name("access.update");
            Route::get('/delete/{cID}', [accessController::class, "deleteAccess"])->name("access.delete");
        });


        //Users
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [userController::class, "users"])->name("users.view");
            Route::get('/json', [userController::class, "getAllUsers"])->name("users.getJSON");
            Route::get('/add', [userController::class, "addUser"])->name("users.add");
            Route::post('/store', [userController::class, "addUserProcess"])->name("users.store");
            Route::get('/edit/{user_id}', [userController::class, "editUser"])->name("users.edit");
            Route::post('/update', [userController::class, "updateUserProcess"])->name("users.update");
            Route::get('/delete/{cID}', [userController::class, "deleteUser"])->name('users.delete');
        });


        Route::group(['prefix' => 'permissions'], function () {
            Route::get('/', [permissionsController::class, "view"])->name("permissions.view");
            Route::get('/add', [permissionsController::class, "add"])->name("permissions.add");
            Route::post('/store', [permissionsController::class, "store"])->name("permissions.store");
            Route::get('edit/{id}', [permissionsController::class, "edit"])->name("permissions.edit");
            Route::get('delete/{id}', [permissionsController::class, "delete"])->name("permissions.delete");
        });
    });
});
