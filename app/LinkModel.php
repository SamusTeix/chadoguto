<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkModel extends Model
{
    protected $table = 'link';
	public $timestamps = false;

    public function __construct()
    {
    	parent::__construct();
    }

    public static function get($table, $id = null)
	{
		$clean = [];
		if ($id)
		{
			$links = LinkModel::where('tabela', $table)->where('tabela_id', $id)->get();
    		foreach($links as $link)
    		{
    			$clean[] = ['link' => $link->link, 'edit' => false];
    		}
		}
		return $clean;
	}
}
