<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\LinkModel;

class LinkController extends Controller
{
    public static function get($table, $id)
    {
    	return DB::table('link')->where('tabela', $table)->where('tabela_id', $id)->get();
    }
}
