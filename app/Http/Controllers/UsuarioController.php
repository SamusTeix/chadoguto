<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UsuarioModel;

class UsuarioController extends Controller
{
    public function verificar(Request $request)
    {
    	$usuario = UsuarioModel::where('email', $request->login)->first();

    	if ($usuario)
    	{
    		parent::__construct($usuario);
    		return $this->jsonSuccess();
    	}
    	else
    	{
    		return $this->jsonError('E-mail não encontrado');	
    	}
    }

    public function cadastrar(Request $request)
    {
    	$usuario = new UsuarioModel();
    	if (! empty($request->email))
    	{
			$usuario = UsuarioModel::where('email', $request->login)->first();    		
    	}

    	if (! isset($usuario->id) || empty($usuario->id))
    	{
    		$usuario->nome      = $request->nome;
    		$usuario->sobrenome = $request->sobrenome;
    		$usuario->email     = $request->email;

    		$usuario->save();
    	}

    	if ($usuario && $usuario->id)
    	{
    		parent::__construct($usuario);
    		return $this->jsonSuccess();
    	}
    	else
    	{
    		return $this->jsonError('Erro ao inserir usuário!');	
    	}

    }
}
