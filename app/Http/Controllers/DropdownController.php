<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Team;
use App\Models\Provider;
use App\Models\AlfcBranch;


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




}
