<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function index() {
        // Plus tard, on récupérera ici les demandes à valider
        return view('manager.dashboard');
    }
}