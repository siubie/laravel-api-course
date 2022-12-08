<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    //
    public function uploadFile(Request $request)
    {
        # code...
        $path = $request->file('avatar')->store('avatars');
        $data = [
            'message' => 'File Uploaded',
            'path' => $path
        ];
        return response()->json($data, 200);
    }
}
