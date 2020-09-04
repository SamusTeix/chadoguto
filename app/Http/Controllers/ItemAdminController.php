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

use Illuminate\Support\Facades\DB;

use Illuminate\View\View;

class ItemAdminController extends Controller
{
	public function index($id = null)
	{	
		$title = empty($id) ? "Novo Item" : "Editando Item";
		return view('item-edit')->with(['title' => $title]);
	}

	public function edit($id = null)
	{
		$data             = [];
		$data['item']     = empty($id) ? new ItemModel() : ItemModel::where('id', $id)->first();
		$data['links']    = LinkModel::get('item', $id);
		$data['tipos']    = TipoModel::get();
		$data['imagens']  = ImagemModel::get('item', $id);
		$data['tamanhos'] = TamanhoModel::where('item_id', $id)->first() ?: [];
		return json_encode($data);
	}

	public function save(Request $request)
	{
		$item = ItemModel::where('id', $request->id)->first();

		if (empty($item))
		{
			$item = new ItemModel();
		}

		$item->nome       = $request->nome;
		$item->descricao  = $request->descricao;
		$item->tipo_id    = $request->tipo_id;
		$item->lista      = $request->lista;
		$item->preco      = $request->preco;

		$item->save();

		if ($item->id)
		{
			$tamanho = TamanhoModel::where('item_id', $item->id)->first();

			if (empty($tamanho))
			{
				$tamanho = new TamanhoModel();
			}

			$tamanho->item_id = $item->id;
			$tamanho->pequeno = $request->pequeno;
			$tamanho->medio   = $request->medio;
			$tamanho->grande  = $request->grande;
			$tamanho->unico   = $request->unico;

			$tamanho->save();

			LinkModel::where('tabela', 'item')->where('tabela_id', $item->id)->delete();
			ImagemModel::where('tabela', 'item')->where('tabela_id', $item->id)->delete();

			$links   = json_decode($request->links);
			$imagens = json_decode($request->imagens);

			foreach ($links as $link) {
				$link_nome = explode('.', $link->link);
				$link_nome = $link_nome[1] . '.' . $link_nome[2];

				$link_data = new LinkModel();
				$link_data->tabela = 'item';
				$link_data->tabela_id = $item->id;
				$link_data->nome = $link_nome;
				$link_data->link = $link->link;

				$link_data->save();
			}

			foreach ($imagens as $imagem) {
				$imagem_nome = explode('/', $imagem->link)[2];

				$imagem_data = new ImagemModel();
				$imagem_data->tabela = 'item';
				$imagem_data->tabela_id = $item->id;
				$imagem_data->nome = $imagem_nome;
				$imagem_data->link = $imagem->link;

				$imagem_data->save();
			}

			return json_encode(['info' => 1, 'msg' => 'Item salvo com sucesso!']);
		}
		else
		{
			return json_encode(['info' => 0, 'msg' => 'Erro ao salvar item!']);
		}
	}

	public function delete($id)
	{
		LinkModel::where('tabela', 'item')->where('tabela_id', $id)->delete();
		ImagemModel::where('tabela', 'item')->where('tabela_id', $id)->delete();
		ItemModel::where('id', $id)->delete();

		return json_encode(['info' => 1, 'msg' => 'Item excluído com sucesso!']);
	}
}
