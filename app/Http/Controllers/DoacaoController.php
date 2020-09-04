<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DoacaoModel;
use App\UsuarioModel;
use App\TamanhoModel;
use App\DoacaoItemModel;
use App\ItemModel;
use App\ImagemModel;

class DoacaoController extends Controller
{
	private $session;

	public function __construct()
	{
		session_start();

		$this->session = $_SESSION;
	}

    public static function doacaoId()
    {
    	$self = new DoacaoController();
    	return $self->getId();
    }

    private function getId()
    {
    	if (! isset($this->session['token']))
    	{
            $erros[] = 'token';

    		$this->session['token'] = md5(date('YmdHms'));

    		$doacaoModel = new DoacaoModel();
    		$doacaoModel->token = $this->session['token'];

    		$doacaoModel->save();
    	}

    	if (! isset($this->session['id']))
    	{
    		$this->setSession();
    	}

    	return $this->session['id'];
    }

    private function setSession()
    {
    	$doacao = DoacaoModel::where('token', $this->session['token'])->first();
    	$this->session['id'] = $doacao->id;

        foreach ($this->session as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    public function index()
    {
        $data = [];
        $data['doacao'] = DoacaoModel::find($this->getId());
        $data['doacao_itens'] = DoacaoItemModel::where('id_doacao', $this->getId())->get();

        if (! empty($data['doacao']->id_usuario))
        {
            $data['usuario'] = UsuarioModel::where('id', $data['doacao']->id_usuario)->first();    
        }        

        foreach ($data['doacao_itens'] as &$item) {
            $item->item     = ItemModel::where('id', $item->id_item)->first();
            $item->imagem   = ImagemModel::where('tabela', 'item')->where('tabela_id', $item->id_item)->first();
            $item->tamanhos = TamanhoModel::where('item_id', $item->id_item)->first();
        }

        if(! empty($data['doacao']->id_usuario))
        {
            $data['doacao']->usuario = UsuarioModel::find($data['doacao']->id_usuario);
        }

        return view('sacolinha')->with($data);
    }

    public function salvar(Request $request)
    {
        $doacao = DoacaoModel::find($this->session['id']);

        if (isset($request->id_usuario) && ! empty($request->id_usuario))
        {
            $id_usuario         = $request->id_usuario;
        }
        else
        {
            $nome      = uc_first(strtolower(trim($request->nome)));
            $sobrenome = uc_first(strtolower(trim($request->sobrenome)));
            $email     = empty($request->email) ? null : strtolower(trim($request->email));

            $usuario            = new UsuarioModel();
            $usuario->nome      = $nome;
            $usuario->email     = $email;
            $usuario->sobrenome = $sobrenome;
            $usuario->save();

            $id_usuario         = UsuarioModel::where('nome', $nome)
                                                ->where('sobrenome', $sobrenome)
                                                ->where('email', $email)
                                                ->first()->id;
        }

        if(! $id_usuario)
        {
            return json_encode(['info' => 0, 'msg' => 'Erro ao criar usuario']);
        }

        $doacao->id_usuario = $id_usuario;
        $doacao->finalizado = 1;

        $id_doacao = $doacao->save();

        if ($id_doacao)
        {
            return json_encode(['info' => 1]);
        }
        return json_encode(['info' => 0, 'msg' => 'Erro ao salvar sacolinha']);
    }
}
