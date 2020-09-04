<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ImagemController;

use App\ItemModel;
use App\LinkModel;
use App\TipoModel;
use App\ImagemModel;

use Illuminate\View\View;

class ItemController extends Controller
{
	public function list($tipo = null)
	{
		if (empty($tipo))
		{
			$itens = ItemModel::orderBy('nome')->get();
		}
		else
		{
			$itens = ItemModel::where('tipo_id', $tipo)->orderBy('nome')->get();
		}

		$item_id_list = [];
		foreach($itens as $item)
		{
			$item_id_list[] = $item->id;
		}

		$imagens = ImagemModel::where('tabela', 'item')->whereIn('tabela_id', $item_id_list)->get();

		foreach($itens as &$item)
		{
			$item->imagem = $imagens->filter(function($imagem) use ($item) {
				return $imagem->tabela_id == $item->id;
			});
		}



		$data                     = [];
		$data['itens']            = $itens;
		$data['tipos']            = TipoModel::orderBy('nome')->get();
		$data['tipo_selecionado'] = $tipo;
		return view('item-list')->with($data);
	}

	public function index()
	{
		$item = new ItemModel();
		$item->find(6);
	}
}
