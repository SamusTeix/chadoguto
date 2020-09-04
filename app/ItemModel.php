<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class ItemModel extends Model
{
    protected $table = 'item';
	public $timestamps = false;

    public function __construct()
    {
    	parent::__construct();
    }

    public static function tamanho_extenso()
    {
        return [
            0 => ' -- Selecione --',
            1 => 'P - Pequeno',
            2 => 'M - Médio',
            3 => 'G - Grande',
            4 => 'U - Único',
        ];   
    }

    public static function tamanho_letra()
    {
        return [
            0 => ' -- Selecione --',
            1 => 'P',
            2 => 'M',
            3 => 'G',
            4 => 'U',
        ];
    }

    public function getPreco()
    {
        return $this->fmt2Show($this->preco);
    }

    public function getPrecoTotal($quantidade)
    {
        return $this->fmt2Show($this->preco * $quantidade);
    }

    private function fmt2Show($value)
    {
        $value = explode('.', $value);
        $value[0] = isset($value[0]) ? $value[0] : 0;
        $value[1] = isset($value[1]) ? $value[1] : 0;
        return 'R$ ' . $value[0] . ',' . str_pad($value[1], 2, "0");   
    }
}
