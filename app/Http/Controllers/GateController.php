<?php

namespace App\Http\Controllers;

class GateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Compared to the Balde system, we need the following methods to check the user's authentication status. In blade, the authenticated user can be viewed directly in the view
    // check if a user is logged in and return the username
    function checkLoggedInUser()
    {
        if (auth()->check()) {
            $user = auth()->user();
            return response()->json(['loggedIn' => true, 'username' => $user->name]);
        } else {
            return response()->json(['loggedIn' => false]);
        }
    }
    // check if a user is logged in and return the userrole - 
    function getUserRole()
    {
        if (auth()->check()) {
            $user = auth()->user();
            return response()->json(['loggedIn' => true, 'type' => $user->type]);
        } else {
            return response()->json(['loggedIn' => false]);
        }
    }
}