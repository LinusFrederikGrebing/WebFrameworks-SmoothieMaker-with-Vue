<?php

namespace App\Http\Controllers;

class GateController extends Controller
{
 // check if a user is logged in and return the username
 function checkLoggedInUser(){
    if (auth()->check()) {
        $user = auth()->user();
        return response()->json(['loggedIn' => true, 'username' => $user->name ]);
    } else {
        return response()->json(['loggedIn' => false]);
    }
 }
 // check if a user is logged in and return the userrole
 function getUserRole(){
    if (auth()->check()) {
        $user = auth()->user();
        return response()->json(['loggedIn' => true, 'type' => $user->type ]);
    } else {
        return response()->json(['loggedIn' => false]);
    }
 }
}
