<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class FileUpload
{
    public static function store(Request $req)
    {
    	$path = [];
    	foreach ($req->file() as $file) {
    		$path[] = Storage::url($file->store('public'));
    	}
    	return $path;
    }
}
