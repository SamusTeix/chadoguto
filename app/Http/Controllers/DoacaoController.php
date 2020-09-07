<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\DoacaoItemController;

use App\DoacaoModel;
use App\UsuarioModel;
use App\TamanhoModel;
use App\DoacaoItemModel;
use App\DoacaoTipoModel;
use App\ItemModel;
use App\LinkModel;
use App\ImagemModel;

class DoacaoController extends Controller
{
	public function index()
    {
        $data = [];
        $data['doacao'] = $this->getDoacao();
        $data['usuario'] = $this->getUser();
        $data['doacao_itens'] = DoacaoItemModel::where('id_doacao', $this->getDoacao()->id)->get();
        $data['doacaoCanal'] = DoacaoTipoModel::get();

        foreach ($data['doacao_itens'] as &$item) {
            $item->item     = ItemModel::where('id', $item->id_item)->first();
            $item->imagem   = ImagemModel::where('tabela', 'item')->where('tabela_id', $item->id_item)->first();
            $item->tamanhos = TamanhoModel::where('item_id', $item->id_item)->first();
        }

        $data['finalizadas'] = DoacaoModel::where('id_usuario', $this->getUser()->id)->whereIn('finalizado', [1,2,3])->orderBy('finalizado')->get();

        foreach($data['finalizadas'] as &$doacao)
        {
            $doacao->itens = DoacaoItemModel::where('id_doacao', $doacao->id)->get();
            $doacao->canal = DoacaoTipoModel::find($doacao->canal);
            foreach ($doacao->itens as &$item) {
                $item->item     = ItemModel::where('id', $item->id_item)->first();
                $item->imagem   = ImagemModel::where('tabela', 'item')->where('tabela_id', $item->id_item)->first();
                $item->links    = LinkModel::where('tabela', 'item')->where('tabela_id', $item->id_item)->get();
                $item->tamanhos = TamanhoModel::where('item_id', $item->id_item)->first();
            }          
        }

        return view('sacolinha')->with($data);
    }

    public function updateStatus($doacao, $status)
    {
        $doacao = DoacaoModel::find($doacao);
        $doacao->finalizado = $status;
        if ($doacao->save())
        {
            if ($status == 4)
            {
                DoacaoItemController::updateQuantidade($doacao);
            }

            return $this->jsonSuccess('Status atualizado com sucesso!');
        }
        return $this->jsonError('Erro ao atualizar status!');
    }

    public function finalizar(Request $request)
    {
        $doacao = $this->getDoacao();
        $doacao->tipo = $request->tipo_doacao;
        $doacao->canal = isset($request->canal_doacao) ? $request->canal_doacao : null;
        $doacao->finalizado = 1;
        $doacao->save();

        DoacaoItemController::updateQuantidade($doacao);

        $this->setSession($this->getUser());

        return $this->jsonSuccess('Sacolinha fechada! MUITO OBRIGADO!');
    }
}
