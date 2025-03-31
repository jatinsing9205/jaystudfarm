<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\category\categoryModel;
use App\Models\companion\companions;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index()
    {
        $companionModel = new companions();
        $companionCount = $companionModel->countCompanion();
        $horsesCount = $companionModel->countHorses();
        $dogsCount = $companionModel->countDogs();

        $categoryModel = new categoryModel();
        $categoryCount = $categoryModel->countCategory();

        return view('index', ['companionCount' => $companionCount, 'categoryCount' => $categoryCount, "horsesCount" => $horsesCount, "dogsCount" => $dogsCount]);
    }
}
