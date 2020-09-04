<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;

use App\TipoModel;

class TipoController extends Controller
{
 	public function index($id = null)
 	{
 		$data['title'] = empty($id) ? "Novo Tipo" : "Editando Tipo";
 		$data['tipo']  = empty($id) ? new TipoModel() : TipoModel::find($id);
 		return view('tipo-edit')->with($data);
 	}

 	public function delete($id)
 	{
 		TipoModel::find($id)->delete();

 		return json_encode(['info' => 1, 'msg' => 'Tipo excluído com sucesso!']);
 	}

 	public function save(Request $request)
 	{
 		$tipo = TipoModel::where('id', $request->id)->first();

		if (empty($tipo))
		{
			$tipo = new TipoModel();
		}

		$tipo->nome = $request->nome;

		$tipo->save();

		if ($tipo->id)
		{
			return redirect('/admin/tipo/index/' . $tipo->id)->with(['success' => 'Tipo salvo com sucesso!']);
		}
		else
		{
			return redirect('/admin/tipo/index')->with(['error' => 'Erro ao salvar tipo!']);
		}
 	}
}
