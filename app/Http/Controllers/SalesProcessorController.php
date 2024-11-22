<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Log;
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



class SalesProcessorController extends Controller
{
    public function showForm()
    {


        $teams = Team::select('name', 'id')->where('status', 'active')->get();
        $salesAssociates = SalesAssociate::select('name', 'id', 'team_id')->where('status', 'active')->get();
        $salesManagers = SalesManager::select('name', 'id', 'team_id')->where('status', 'active')->get();



        $providers = Provider::select('name', 'id')->where('status', 'active')->get();
        $products = Product::select('name', 'id')->where('status', 'active')->get();
        $subproducts = Subproduct::select('name', 'id')->where('status', 'active')->get();
        $sources = Source::select('name', 'id')->where('status', 'active')->get();
        $sourcebranches = SourceBranch::select('name', 'id')->where('status', 'active')->get();
        $ifGdfis = IfGdfi::select('name', 'id')->where('status', 'active')->get();
        $areas = Area::select('name', 'id')->where('status', 'active')->get();
        $alfcbranches = AlfcBranch::select('name', 'id')->where('status', 'active')->get();
        $mops = ModeOfPayment::select('name', 'id')->where('status', 'active')->get();
        $commissioners = Commissioner::select('name', 'id')->where('status', 'active')->get();


        return view('form.form', compact(

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
}
