<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Team;

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













}
