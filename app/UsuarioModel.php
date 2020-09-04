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
}
