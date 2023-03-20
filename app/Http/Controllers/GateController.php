<?php

namespace App\Http\Controllers;

class GateController extends Controller
{
 function checkLoggedInUser(){
    if (auth()->check()) {
        $user = auth()->user();
        return response()->json(['loggedIn' => true, 'username' => $user->name ]);
    } else {
        return response()->json(['loggedIn' => false]);
    }
 }
}
