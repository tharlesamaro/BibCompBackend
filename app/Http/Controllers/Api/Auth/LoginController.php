<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

class LoginController extends Controller
{
	private $cliente;

	public function __construct()
	{
		$this->cliente = Client::find(2);
	}

    public function login(Request $request)
    {
    	
		$this->validate($request, [
    		'email' => 'required',
    		'password' => 'required'
    	]);

    	$parametros = [
	        'grant_type' => 'password',
	        'client_id' => $this->cliente->id,
	        'client_secret' => $this->cliente->secret,
	        'username' => request('email'),
	        'password' => request('password'),
	        'scope' => '*',
	    ];

	    $request->request->add($parametros);

	    $proxy = Request::create('oauth/token', 'POST');

	    return Route::dispatch($proxy);
    }

    public function refresh(Request $request)
    {

    }

    public function logout(Request $request)
    {

    }
}
