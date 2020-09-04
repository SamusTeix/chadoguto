<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\UsuarioModel;
use App\DoacaoModel;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    	
    }

    public function setSession(UsuarioModel $user)
    {
    	$this->setUser($user);
    	$this->setToken();
    }

    private function setUser(UsuarioModel $user)
    {
    	session(['user' => $user]);
    }

    private function setToken()
    {
    	$doacao = DoacaoModel::where('id_usuario', $this->user->id)->where('finalizado', '<', 2)->first();
    	if ($doacao)
    	{
    		session(['token' => $doacao->token]);
    	}
    	else
    	{
    		session(['token' => md5(date('YmdHms'))]);

    		$doacaoModel = new DoacaoModel();
    		$doacaoModel->token = session('token');

    		$doacaoModel->save();    		
    	}
    }

    public function jsonSuccess($msg = null)
    {
    	return json_encode(['info' => 1, 'msg' => $msg]);
    }

    public function jsonError($msg)
    {
    	return json_encode(['info' => 0, 'msg' => $msg]);
    }
}
