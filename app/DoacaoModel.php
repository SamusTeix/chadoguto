<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoacaoModel extends Model
{
    protected $table = 'doacao';
	public $timestamps = false;

    public function __construct()
    {
    	parent::__construct();
    }
}
