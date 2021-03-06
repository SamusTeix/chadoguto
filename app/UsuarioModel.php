<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioModel extends Model
{
	protected $table = 'usuario';
	public $timestamps = false;

    public function __construct()
    {
    	parent::__construct();
    }

    public function nomeCompleto()
    {
    	return $this->nome . ' ' . $this->sobrenome;
    }
}
