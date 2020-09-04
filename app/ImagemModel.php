<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImagemModel extends Model
{
    protected $table = 'imagem';
	public $timestamps = false;

    public function __construct()
    {
    	parent::__construct();
    }

    public static function get($table, $id = null)
	{
		$clean = [];
		if ($id) 
		{
			$imagens = ImagemModel::where('tabela', $table)->where('tabela_id', $id)->get();    		

    		foreach($imagens as $imagem)
    		{
    			$clean[] = ['link' => $imagem->link];
    		}
		}
		return $clean;    		
	}
}
