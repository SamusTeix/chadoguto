<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TamanhoModel extends Model
{
    protected $table = 'tamanho';
	public $timestamps = false;

    public function __construct()
    {
    	parent::__construct();
    }

    public static function itensZerados()
    {
    	$tamanhoModel = new TamanhoModel();
    	$itens = $tamanhoModel->where('pequeno', 0)->where('medio', 0)->where('grande', 0)->where('unico', 0)->get();
    	return $tamanhoModel->getIdList($itens, 'item_id');
    }

    public function getIdList($list, $field = 'id')
    {        
        $id_list = [];
        foreach ($list as $item) {
            $id_list[] = $item->{$field};
        }
        return $id_list;
    }
}
