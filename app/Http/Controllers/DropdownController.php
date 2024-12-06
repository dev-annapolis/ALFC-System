<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Team;
use App\Models\Provider;
use App\Models\AlfcBranch;
use App\Models\Product;

use App\Models\Area;

use App\Models\Source;


class DropdownController extends Controller
{

    public function teamsIndex()
    {
        $teams = Team::orderBy('status', 'asc')->get();
        return view('dropdown.teams', compact( 'teams'));
    }

    public function teamsStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name',
        ]);

        Team::create([
            'name' => $validated['name']
        ]);

        return redirect()->back()->with('success', 'Team added successfully!');
    }

    public function teamsUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:teams,id',
            'name' => 'required|string|max:255|unique:teams,name,' . $request->id,
        ]);

        $team = Team::findOrFail($validated['id']);
        $team->update([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Team updated successfully!');
    }

    public function teamsChangeStatus($id)
    {
        $team = Team::findOrFail($id);
        $team->status = $team->status === 'active' ? 'inactive' : 'active';
        $team->save();

        return redirect()->back()->with('success', 'Team status updated successfully!');
    }





    // Display a list of providers
    public function providersIndex()
    {
        $providers = Provider::orderBy('status', 'asc')->get();
        return view('dropdown.providers', compact('providers'));
    }

    // Store a new provider
    public function providersStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:providers,name',
        ]);

        Provider::create([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Provider added successfully!');
    }

    // Update an existing provider
    public function providersUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:providers,id',
            'name' => 'required|string|max:255|unique:providers,name,' . $request->id,
        ]);

        $provider = Provider::findOrFail($validated['id']);
        $provider->update([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Provider updated successfully!');
    }

    // Change the status of a provider
    public function providersChangeStatus($id)
    {
        $provider = Provider::findOrFail($id);
        $provider->status = $provider->status === 'active' ? 'inactive' : 'active';
        $provider->save();

        return redirect()->back()->with('success', 'Provider status updated successfully!');
    }






    // Display a list of ALFC branches
    public function alfcBranchesIndex()
    {
        $alfcBranches = AlfcBranch::orderBy('status', 'asc')->get();
        return view('dropdown.alfcBranches', compact('alfcBranches'));
    }

    // Store a new ALFC branch
    public function alfcBranchesStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:alfc_branches,name',
        ]);

        AlfcBranch::create([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'ALFC Branch added successfully!');
    }

    // Update an existing ALFC branch
    public function alfcBranchesUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:alfc_branches,id',
            'name' => 'required|string|max:255|unique:alfc_branches,name,' . $request->id,
        ]);

        $alfcBranch = AlfcBranch::findOrFail($validated['id']);
        $alfcBranch->update([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'ALFC Branch updated successfully!');
    }

    // Change the status of an ALFC branch
    public function alfcBranchesChangeStatus($id)
    {
        $alfcBranch = AlfcBranch::findOrFail($id);
        $alfcBranch->status = $alfcBranch->status === 'active' ? 'inactive' : 'active';
        $alfcBranch->save();

        return redirect()->back()->with('success', 'ALFC Branch status updated successfully!');
    }





    public function productsIndex()
    {
        $products = Product::orderBy('status', 'asc')->get();
        return view('dropdown.products', compact('products'));
    }

    public function productsStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
        ]);

        Product::create([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function productsUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:products,id',
            'name' => 'required|string|max:255|unique:products,name,' . $request->id,
        ]);

        $product = Product::findOrFail($validated['id']);
        $product->update([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function productsChangeStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();

        return redirect()->back()->with('success', 'Product status updated successfully!');
    }




    public function areasIndex()
    {
        $areas = Area::orderBy('status', 'asc')->get();
        return view('dropdown.areas', compact('areas'));
    }

    public function areasStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:areas,name',
        ]);

        Area::create([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Area added successfully!');
    }

    public function areasUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:products,id',
            'name' => 'required|string|max:255|unique:areas,name,' . $request->id,
        ]);

        $area = Area::findOrFail($validated['id']);
        $area->update([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Area updated successfully!');
    }

    public function areasChangeStatus($id)
    {
        $area = Area::findOrFail($id);
        $area->status = $area->status === 'active' ? 'inactive' : 'active';
        $area->save();

        return redirect()->back()->with('success', 'Area status updated successfully!');
    }





    public function sourcesIndex()
    {
        $sources = Source::orderBy('status', 'asc')->get();
        return view('dropdown.sources', compact('sources'));
    }

    public function sourcesStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sources,name',
        ]);

        Source::create([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Source added successfully!');
    }

    public function sourcesUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:sources,id',
            'name' => 'required|string|max:255|unique:sources,name,' . $request->id,
        ]);

        $source = Source::findOrFail($validated['id']);
        $source->update([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Source updated successfully!');
    }

    public function sourcesChangeStatus($id)
    {
        $source = Source::findOrFail($id);
        $source->status = $source->status === 'active' ? 'inactive' : 'active';
        $source->save();

        return redirect()->back()->with('success', 'Source status updated successfully!');
    }







}
