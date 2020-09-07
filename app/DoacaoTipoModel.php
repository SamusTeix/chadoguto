<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoacaoTipoModel extends Model
{
    protected $table = 'doacao_tipo';
	public $timestamps = false;

    public function __construct()
    {
    	parent::__construct();
    }
}
