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
}
