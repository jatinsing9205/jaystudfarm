<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index(){
        return view("index");
    }
}
