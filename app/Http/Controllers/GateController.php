<?php

namespace App\Http\Controllers;

class GateController extends Controller
{
 function checkLoggedInUser(){
    if (auth()->check()) {
        return response()->json(['loggedIn' => true]);
    } else {
        return response()->json(['loggedIn' => false]);
    }
 }
}
