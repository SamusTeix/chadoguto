<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoModel extends Model
{
    protected $table = 'tipo';
	public $timestamps = false;

    public function __construct()
    {
    	parent::__construct();
    }
}
