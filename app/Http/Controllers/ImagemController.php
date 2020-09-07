<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\ImagemModel;

use App\Http\Services\FileUpload;

class ImagemController extends Controller
{
   	public function store(Request $req)
	{
		return $this->jsonSuccess(FileUpload::store($req));
	}

	public static function get($table, $id)
    {
    	return DB::table('imagem')->where('tabela', $table)->where('tabela_id', $id)->get();
    }
}
