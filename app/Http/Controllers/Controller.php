<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\UsuarioModel;
use App\DoacaoModel;
use App\AdminModel;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    	$this->setPermission();
    }

    // CONTROLE DE SEÇÃO: USUARIO
    public function setSession(UsuarioModel $user)
    {
    	$this->setUser($user);
    	$this->setToken();
        $this->setPermission();
    }

    // SETANDO USUARIO
    private function setUser(UsuarioModel $user)
    {
        session(['user' => $user]);        
    }

    // SETANDO TOKEN
    private function setToken()
    {
        $doacao = DoacaoModel::where('id_usuario', $this->getUser()->id)->where('finalizado', 0)->first();
        if ($doacao)
        {
            session(['token' => $doacao->token]);
        }
        else
        {
            session(['token' => md5(date('YmdHms'))]);

            $doacao             = new DoacaoModel();
            $doacao->id_usuario = $this->getUser()->id;
            $doacao->token      = session('token');
            $doacao->finalizado = 0;

            $doacao->save();
        }
        session(['doacao' => $doacao]);
    }

    // CONTROLE DE SEÇÃO: ADMINISTRADOR
    public function setAdminSession(AdminModel $admin)
    {
        $this->setAdminUser($admin);
        $this->setPermission();
    }

    // SETANDO ADMINISTRADOR
    private function setAdminUser(AdminModel $admin)
    {
        session(['admin' => $admin]);
    }

    // LOGOUT ADMINISTRADOR
    public function adminLogout()
    {
        session()->forget('admin');
        $this->setPermission();
    }

    // SETANDO PERMISSOES DA SESSAO
    private function setPermission($type = null)
    {
        $user  = $this->isUserLogged();
        $admin = $this->isAdminLogged();

        session(['permission' => ['user' => $user, 'admin' => $admin]]);
    }

    private function isUserLogged()
    {
        return session('user')  == null ? false : true;
    }

    private function isAdminLogged()
    {
        return session('admin') == null ? false : true;
    }

    public function getUser()
    {
        return session('user') ?: false;
    }

    public function getToken()
    {
        return session('token');
    }

    public function getDoacao()
    {
        return session('doacao');
    }

    public function updateDoacao()
    {
        session(['doacao' => DoacaoModel::where('id_usuario', $this->getUser()->id)->where('token', $this->getToken())->first()]);
    }

    public function getAdmin()
    {
        return session('admin') ?: false;
    }

    public function hasUserPermission()
    {
        return session('permission')['user'];
    }

    public function hasAdminPermission()
    {
        return session('permission')['admin'];
    }

    // FUNCOES DE RETORNO JSON
    public function jsonSuccess($msg = null)
    {
    	return json_encode(['info' => 1, 'msg' => $msg]);
    }

    public function jsonError($msg)
    {
    	return json_encode(['info' => 0, 'msg' => $msg]);
    }

    public function getIdList($list, $field = 'id')
    {
        $id_list = [];
        foreach ($list as $item) {
            $id_list[] = $item->{$field};
        }
        return $id_list;
    }
}
