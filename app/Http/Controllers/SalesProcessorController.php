<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Log;
use App\Models\SalesAssociate;
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



class SalesProcessorController extends Controller
{
    public function showForm()
    {

        $teams = Team::select('name', 'id')->get();
        $salesAssociates = SalesAssociate::select('name', 'id')->get();
        $providers = Provider::select('name', 'id')->get();
        $products = Product::select('name', 'id')->get();
        $subproducts = Subproduct::select('name', 'id')->get();
        $sources = Source::select('name', 'id')->get();
        $sourcebranches = SourceBranch::select('name', 'id')->get();
        $ifGdfis = IfGdfi::select('name', 'id')->get();
        $areas = Area::select('name', 'id')->get();
        $alfcbranches = AlfcBranch::select('name', 'id')->get();
        $mops = ModeOfPayment::select('name', 'id')->get();
        $commissioners = Commissioner::select('name', 'id')->get();


        return view('form.form', compact(

            'teams',
            'salesAssociates',
            'branchManagers',
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


        )); // Adjust the path if necessary



    }
}
