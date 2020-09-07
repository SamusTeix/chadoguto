<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DoacaoTipoModel;

use App\Http\Services\FileUpload;

class DoacaoTipoController extends Controller
{
    public function index($id = null)
    {
    	$data = [];
    	$data['title'] = 'Novo tipo de doação';
    	$data['doacaoTipo'] = new DoacaoTipoModel();
    	if ($id)
    	{
    		$data['doacaoTipo'] = DoacaoTipoModel::find($id);
    		$data['titulo'] = 'Editando tipo de doação - ' . $data['doacaoTipo']->nome;
    	}

    	return view('doacao-tipo-edit')->with($data);
    }

    public function save(Request $request)
    {
    	$data = new DoacaoTipoModel(); 
    	if (! empty($request->id))
    	{
    		$data = DoacaoTipoModel::find($request->id);
    	}
        if ($request->file())
        {
            $data->imagem = FileUpload::store($request)[0];
        }
    	$data->nome = $request->nome;
    	$data->descricao = $request->descricao;
        $data->dados = $request->dados;
    	$data->save();

    	return $this->index($data->id);
    }

    public function delete($id)
    {
    	if (DoacaoTipoModel::find($id)->delete())
    	{
    		return $this->jsonSuccess('Canal de doação excluído com sucesso!');
    	}
    	return $this->jsonError('Erro ao excluir canal de doação!');
    }
}
