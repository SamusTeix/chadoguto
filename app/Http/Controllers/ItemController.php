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
use App\TamanhoModel;

use Illuminate\View\View;

class ItemController extends Controller
{
	public function list($tipo = null)
	{
		$zerados = TamanhoModel::itensZerados();

		$where  = "1 = 1";
		$where .= empty($tipo) ? '' : ' AND tipo_id = ' . $tipo;
		$where .= count($zerados) ? ' AND id NOT IN (' . implode(',', $zerados) . ')' : '';

		$itens = ItemModel::whereRaw($where)->orderBy('nome')->get();

		$item_id_list = $this->getIdList($itens);

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
}
