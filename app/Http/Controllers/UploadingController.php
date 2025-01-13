<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Validator;
use App\Imports\DataImport;
use Maatwebsite\Excel\Facades\Excel;

class UploadingController extends Controller
{
    public function uploadDataIndex()
    {
        $userID = auth()->user()->id;

        return view('uploading.uploadDataIndex', compact( 'userID'));
    }

    public function uploadDataStore(Request $request)
    {
        $userID = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|file|mimes:xls,xlsx',
        ]);

        if ($validator->fails()) {
            Log::info("PLEASE INPUT VALID EXCEL FILE");
            return redirect()->back()->with('uploadError', "PLEASE INPUT A VALID EXCEL FILE");
        }

        try {
            // usleep(3000000);
            $progressKey = 'upload_progress_' . uniqid();
            $file = $request->file('excel_file');
            $import = new DataImport();
            Excel::import($import, $file);

            Log::info('Excel data has been successfully imported with no errors');
            return redirect()->back()->with(['uploadSuccess' => true]);

        } catch (\Exception $e) {
            // Handle error: DISPLAY ERROR TO MODAL
            return redirect()->back()->with('uploadError', $e->getMessage());
        }
    }
    
}
