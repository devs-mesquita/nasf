<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;

class UserController extends Controller

{
	
	public function index()
	{
		$users = User::all();
	
		return view('user.index', compact('users'));
	}

	public function create()
	{
		return view('user.create');
	}

	public function store(Request $request)
	{
		DB::beginTransaction();
		try {
			$user = new User;
			$user->name = $request->name;
			$user->email = $request->email;
			$user->nivel = $request->nivel;
			$senha_padrao = 'pmm123456';
			$user->password = bcrypt($senha_padrao);
			$user->save();
	
			DB::commit();
			return redirect()->route('user.index')->with('sucesso', 'Usuário criado com sucesso.');

		} catch (Throwable $th) {
			DB::rollback();
			dd($th);
			return redirect()->route('user.index')->with('erro', 'Houve um erro ao tentar criar um usuário.');
		}
	}

	
	public function AlteraSenha()
	{
		$usuario = Auth::user();
	
		return view('auth.altera_senha',compact('usuario'));    

		
	}

	public function SalvarSenha(Request $request)
	{
		//não deixa usar o cpf como senha
		if ( retiraMascaraCPF(Auth()->user()->cpf)  == $request->password)
		{
			return back()->withErrors('Essa senha não pode ser utilizada. Tente outra!');
		}


		// Validar
		$this->validate($request, [
			'password_atual'        => 'required',
			'password'              => 'required|min:6|confirmed',
			'password_confirmation' => 'required|min:6'
		]);

		// Obter o usuário
		$usuario = User::find(Auth::user()->id);

		if (Hash::check($request->password_atual, $usuario->password))
		{

			$usuario->update(['password' => bcrypt($request->password)]);            

			return redirect('/home')->with('sucesso','Senha alterada com sucesso.');
		}else{

			return back()->withErrors('Senha atual não confere');
		}

	}


}