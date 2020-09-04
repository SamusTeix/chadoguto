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

class AdminController extends Controller
{
	private $session;

	public function __construct()
	{
		session_start();
		$this->session = $_SESSION;
	}

    public function index()
    {
    	if ($this->isLogged())
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

    		$data = [];
    		$data['itens']         = $itens;
    		$data['tipos']         = $tipos;
    		$data['user']          = $this->session;
    		$data['doacoes']       = DoacaoModel::get();
    		return view('dashboard')->with('data', $data);
    	}
    	else
    	{
    		return view('login');
    	}
    }

    public static function logged()
    {
    	$self = new AdminController();
    	return $self->isLogged();
    }

	private function isLogged()
	{
		return isset($this->session['admin']) 
			&& $this->session['admin'] == true
			&& isset($this->session['logged']) 
			&& $this->session['logged'] == true
			? true : false;
	}

	private function setSession()
	{
		foreach ($this->session as $key => $value) {
            $_SESSION[$key] = $value;
        }
	}

	public function login(Request $request)
	{
		$admin = DB::table('admin')
					->where('login', md5($request->login))
					->where('senha', md5($request->senha))
					->first();

		if ($admin)
		{
			$this->session['login']  = $request->login;
			$this->session['admin']  = true;
			$this->session['logged'] = true;
			$this->setSession();

			return redirect('admin');
		}
		else
		{
			return redirect('admin')
					->with('msg', 'Login ou senha incorretos');
		}
	}

	public function logout()
	{
		$this->session['login']  = false;
		$this->session['admin']  = false;
		$this->session['logged'] = false;
		$this->setSession();

		return redirect('admin');
	}

	// $teste->login = md5('chadogutoadmin');
	// $teste->senha = md5('sc261291');
}
