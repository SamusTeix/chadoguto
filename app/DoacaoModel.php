<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\DoacaoTipoModel;
use App\DoacaoItemModel;
use App\ItemModel;

class DoacaoModel extends Model
{
    protected $table = 'doacao';
	public $timestamps = false;

    public function __construct()
    {
    	parent::__construct();
    }

    public function getCanal()
    {
    	if ($this->canal == null && $this->finalizado == 0)
    	{
    		return "Sem canal definido";
    	}
        else if ($this->canal == null && $this->finalizado > 0)
        {
            return "Compra pela loja";
        }
    	else
    	{
    		return DoacaoTipoModel::find($this->canal)->nome;
    	}
    }

    public function getFinalizado()
    {
    	$finalizado = "";
    	switch ($this->finalizado) {
    		case 0:
    			$finalizado = "Sacolinha aberta";
    			break;
    		case 1:
    			$finalizado = "Sacolinha fechada";
    			break;
    		case 2:
    			$finalizado = "Aguardando entrega";
    			break;
    		case 3:
    			$finalizado = "Entregue";
    			break;
    		case 4:
    			$finalizado = "Cancelado";
    			break;
    	}
    	return $finalizado;
    }

    public function getValorTotal()
    {
        $itens = DoacaoItemModel::where('id_doacao', $this->id)->get();

        $valor = 0;
        foreach($itens as $item)
        {
            $item->item = ItemModel::find($item->id_item);
            $valor += $item->item->preco * $item->quantidade;
        }

        return $this->fmt2Show($valor);
    }

    private function fmt2Show($value)
    {
        $value = explode('.', $value);
        $value[0] = isset($value[0]) ? $value[0] : 0;
        $value[1] = isset($value[1]) ? $value[1] : 0;
        return 'R$ ' . $value[0] . ',' . str_pad($value[1], 2, "0");   
    }
}
