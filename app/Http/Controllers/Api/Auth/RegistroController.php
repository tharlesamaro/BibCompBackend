<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

class RegistroController extends Controller
{
	private $cliente;

	public function __construct()
	{
		$this->cliente = Client::find(2);
	}

    public function registrar(Request $request)
    {
    	try {
    		$this->validate($request, [
	    		'name' => 'required',
	    		'email' => 'required|email|unique:users,email',
	    		'password' => 'required|min:6|confirmed'
	    	]);

	    	$dados = $request->all();
	    	$dados['password'] = Hash::make($dados['password']);

	    	$usuario = User::create($dados);

	    	$parametros = [
		        'grant_type' => 'password',
		        'client_id' => $this->cliente->id,
		        'client_secret' => $this->cliente->secret,
		        'username' => request('email'), //$usuario->email,
		        'password' => request('password'),
		        'scope' => '*',
		    ];

		    $request->request->add($parametros);

		    $proxy = Request::create('oauth/token', 'POST');

		    return Route::dispatch($proxy);
    	}
    	catch(\Throwable $erro) {
    		return response()->json(['error' => $erro->getMessage()]);
    	}
    }
}
