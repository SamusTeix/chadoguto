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
    		$this->setSession($usuario);
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
    	if (! empty($request->login))
    	{
			$usuario = UsuarioModel::where('email', $request->login)->first();    		
    	}

    	if (! isset($usuario->id) || empty($usuario->id))
    	{
    		$usuario->nome      = ucfirst(strtolower(trim($request->nome)));
    		$usuario->sobrenome = ucfirst(strtolower(trim($request->sobrenome)));
    		$usuario->email     = strtolower(trim($request->email));

    		$usuario->save();
    	}

    	if ($usuario && $usuario->id)
    	{
    		$this->setSession($usuario);
    		return $this->jsonSuccess();
    	}
    	else
    	{
    		return $this->jsonError('Erro ao inserir usuário!');	
    	}

    }
}
