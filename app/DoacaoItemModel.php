<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoacaoItemModel extends Model
{
    protected $table = 'doacao_item';
	public $timestamps = false;

    public function __construct()
    {
    	parent::__construct();
    }
}
