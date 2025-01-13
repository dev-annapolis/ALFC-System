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

    public function uploadDataStore()
    {
        $userID = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|file|mimes:xls,xlsx',
        ]);

        if ($validator->fails()) {
            Log::info("PLEASE INPUT VALID EXCEL FILE");
            return back()->with('error', "PLEASE INPUT VALID EXCEL FILE");
        }

        $file = $request->file('excel_file');
        $import = new DataImport();
        Excel::import($import, $file);

        usleep(500000);
        Log::info('Excel data has been successfully imported with no errors');
        return back()->with(['uploadSuccess' => true]);
    }
}
