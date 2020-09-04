<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
	public $timestamps = false;

    public function __construct()
    {
    	parent::__construct();
    }
}
