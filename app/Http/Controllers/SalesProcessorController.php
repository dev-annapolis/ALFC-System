<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Log;

use App\Models\AssuredDetail;
use App\Models\SalesAssociate;
use App\Models\SalesManager;
use App\Models\Provider;
use App\Models\Product;
use App\Models\Subproduct;
use App\Models\Source;
use App\Models\SourceBranch;
use App\Models\IfGdfi;
use App\Models\Area;
use App\Models\AlfcBranch;
use App\Models\Team;
use App\Models\ModeOfPayment;
use App\Models\Commissioner;
use Illuminate\Support\Facades\Crypt;



class SalesProcessorController extends Controller
{
    public function showForm()
    {


        $clients = AssuredDetail::all();

        $teams = Team::select('name', 'id')->where('status', 'active')->get();
        $salesAssociates = SalesAssociate::select('name', 'id', 'team_id')->where('status', 'active')->get();
        $salesManagers = SalesManager::select('name', 'id', 'team_id')->where('status', 'active')->get();



        $providers = Provider::select('name', 'id')->where('status', 'active')->get();

        $products = Product::select('name', 'id')->where('status', 'active')->get();
        $subproducts = Subproduct::select('name', 'id', 'product_id')->where('status', 'active')->get();

        $sources = Source::select('name', 'id')->where('status', 'active')->get();
        $sourcebranches = SourceBranch::select('name', 'id')->where('status', 'active')->get();
        $ifGdfis = IfGdfi::select('name', 'id')->where('status', 'active')->get();
        $areas = Area::select('name', 'id')->where('status', 'active')->get();
        $alfcbranches = AlfcBranch::select('name', 'id')->where('status', 'active')->get();
        $mops = ModeOfPayment::select('name', 'id')->where('status', 'active')->get();
        $commissioners = Commissioner::select('name', 'id')->where('status', 'active')->get();


        return view('form.form', compact(
            'clients',
            'teams',
            'salesAssociates',
            'salesManagers',

            'providers',
            'products',
            'subproducts',
            'sources',
            'sourcebranches',
            'ifGdfis',
            'areas',
            'alfcbranches',
            'mops',
            'commissioners',


        ));


    }


    public function searchClients(Request $request)
    {
        $clientName = $request->input('query'); // Assuming the input field name is 'query'

        $clients = AssuredDetail::where('name', 'like', '%' . $clientName . '%')
            ->select('id', 'name', 'lot_number', 'street', 'barangay', 'city', 'country', 'email', 'contact_number') // Select only needed columns
            ->get();

        $clients->transform(function ($client) {
            $client->encrypted_id = Crypt::encryptString($client->id);
            return $client;
        });

        return response()->json($clients);
    }


    public function submitForm(Request $request)
    {
        // Capture the form data
        $formData = $request->all();

        // Decrypt the assuredIdValue
        if (isset($formData['assuredIdValue'])) {
            try {
                // Decrypt the assuredIdValue
                $decryptedId = Crypt::decryptString($formData['assuredIdValue']);
                Log::info('Decrypted Assured ID:', ['id' => $decryptedId]);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                // Handle decryption failure
                Log::error('Decryption failed:', ['error' => $e->getMessage()]);
            }
        }

        // Log the form data
        Log::info('Form Data Submitted:', $formData);

        // Optionally, you can return a response if needed
        return response()->json(['message' => 'Form data received successfully.']);
    }



}
