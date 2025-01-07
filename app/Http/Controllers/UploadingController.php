<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadingController extends Controller
{
    public function uploadDataIndex()
    {
        $userID = auth()->user()->id;

        return view('uploading.uploadDataIndex', compact( 'userID'));
    }
}
