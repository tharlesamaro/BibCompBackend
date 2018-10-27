<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(Request $request)
    {
    	$this->validarion($request, [
    		'username' => 'required',
    		'password' => 'required'
    	]);
    }

    public function refresh(Request $request)
    {

    }

    public function logout(Request $request)
    {

    }
}
