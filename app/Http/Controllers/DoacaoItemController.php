<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\DoacaoController;

use App\DoacaoItemModel;

class DoacaoItemController extends Controller
{
    public function adicionarItem(Request $request)
    {
    	$doacao_id = DoacaoController::doacaoId();
    	$tamanhos = json_decode($request->tamanhos);
    	foreach ($tamanhos as $tamanho) {
            if ($tamanho->quantidade > 0)
            {
                $doacaoItemModel = DoacaoItemModel::where('id_doacao', $doacao_id)
                                ->where('id_item', $request['item_id'])
                                ->where('tamanho', $tamanho->nome)
                                ->first();

                if (! isset($doacaoItemModel->id))
                {
                    $doacaoItemModel             = new DoacaoItemModel();    
                }
                
                $doacaoItemModel->id_item    = $request['item_id'];
                $doacaoItemModel->id_doacao  = $doacao_id;
                $doacaoItemModel->tamanho    = $tamanho->nome;
                $doacaoItemModel->quantidade = $tamanho->quantidade;
                $doacaoItemModel->save();
            }            
    	}

        DoacaoItemModel::where('id_doacao', $doacao_id)->where('quantidade', 0)->delete();

    	return json_encode(['info' => 1, 'msg' => 'Item adicionado com sucesso!']);
    }

    public function alteraQuantidade(Request $request)
    {
        $data = DoacaoItemModel::where('id_doacao', $request->id)->where('id_item', $request->id_item)->where('tamanho', $request->tamanho)->first();
        $data->quantidade = $request->quantidade;
        if ($data->save())
        {
            return json_encode(['info' => 1, 'msg' => 'Item adicionado a sacolinha!']);
        }
        return json_encode(['info' => 0, 'msg' => 'Erro ao adicionar item a sacolinha!']);
    }

    public function removerItem(Request $request)
    {
        $data = DoacaoItemModel::where('id_doacao', $request->id_doacao)->where('id_item', $request->id_item)->where('tamanho', $request->tamanho)->first();
        if ($data->delete())
        {
            return json_encode(['info' => 1, 'msg' => 'Item excluído com sucesso!']);   
        }
        return json_encode(['info' => 0, 'msg' => 'Erro ao excluir item!']);   
    }
}
