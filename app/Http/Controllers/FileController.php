<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function show($path)
    {
        // $path = storage_path('app/files/' . $filename);
        $fullPath = 'public/' . $path;

        // if (!file_exists($path)) {
        //     abort(404, 'File not found');
        // }

        if(!Storage::exists($fullPath)){
            abort(404);
        }
        // return response()->file($path);

        return Storage::response($fullPath);
    }
}
