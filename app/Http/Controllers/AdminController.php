<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ItemModel;
use App\TipoModel;
use App\LinkModel;
use App\ImagemModel;
use App\DoacaoModel;
use App\TamanhoModel;
use App\AdminModel;
use App\DoacaoTipoModel;
use App\DoacaoItemModel;
use App\UsuarioModel;

class AdminController extends Controller
{
    public function index()
    {
    	if ($this->hasAdminPermission())
    	{
    		$itens    = ItemModel::get();
    		$tipos    = TipoModel::get();
    		$tamanhos = TamanhoModel::get();

    		$links    = LinkModel::where('tabela', 'item')->get();
    		$imagens  = ImagemModel::where('tabela', 'item')->get();

    		foreach ($itens as &$item) {
    			// links
    			$item->link = $links->filter(function($link) use ($item) {
    				if ($link->tabela_id == $item->id) {
    					return $link->link;
    				}
    			});

    			// imagens
    			$item->imagem = $imagens->filter(function($imagem) use ($item) {
    				if ($imagem->tabela_id == $item->id) {
    					return $imagem->link;
    				}
    			});

    			// tamanhos
    			$item->tamanho = $tamanhos->filter(function($tamanho) use ($item) {
    				if ($tamanho->item_id == $item->id) {
    					return $tamanho;
    				}
    			});
    		}

            $doacoes  = DoacaoModel::get();
            $itens_doacao = DoacaoItemModel::get();
            $usuarios = UsuarioModel::get();

            foreach ($doacoes as &$doacao) 
            {
                $doacao->usuario = $usuarios->filter(function($usuario) use ($doacao) {
                    if ($usuario->id == $doacao->id_usuario){
                        return $usuario;
                    }                    
                })->first();

                $doacao->itens = $itens_doacao->filter(function($item_doacao) use ($doacao, $itens) {
                    if ($item_doacao->id_doacao == $doacao->id) {
                        $item_doacao->item = $itens->filter(function($item) use ($item_doacao) {
                            if ($item->id == $item_doacao->id_item) {
                                return $item;
                            }
                        })->first();
                        return $item_doacao;
                    }
                });
            }

    		$data            = [];
    		$data['itens']   = $itens;
    		$data['tipos']   = $tipos;
    		$data['admin']   = $this->getAdmin();
            $data['doacoes'] = $doacoes;
            $data['doacao_tipo'] = DoacaoTipoModel::get();

            // dd($data);

    		return view('dashboard')->with('data', $data);
    	}
    	else
    	{
    		return view('login');
    	}
    }

	public function login(Request $request)
	{
		$admin = AdminModel::where('login', md5($request->login))->where('senha', md5($request->senha))->first();

    	if ($admin)
    	{
    		$this->setAdminSession($admin);
    		return redirect('admin');
    	}
    	else
    	{
    		return redirect('admin')->with('msg', 'Login ou senha incorretos');
    	}
	}

	public function logout()
	{
		$this->adminLogout();
		return redirect('admin');
	}

	// $teste->login = md5('chadogutoadmin');
	// $teste->senha = md5('sc261291');
}
