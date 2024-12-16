<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\Team;
use App\Models\Provider;
use App\Models\Product;
use App\Models\Area;
use App\Models\Source;
use App\Models\SourceBranch;
use App\Models\AlfcBranch;
use App\Models\ModeOfPayment;
use App\Models\Subproduct;
use App\Models\IfGdfi;
use App\Models\Commissioner;
use App\Models\SalesManager;
use App\Models\Tele;

use App\Models\User;



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




    public function sourceBranchesIndex()
    {
        $sourceBranches = SourceBranch::orderBy('status', 'asc')->get();
        return view('dropdown.source_branches', compact('sourceBranches'));
    }

    public function sourceBranchesStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:source_branches,name',
        ]);

        SourceBranch::create([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Source Branch added successfully!');
    }

    public function sourceBranchesUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:source_branches,id',
            'name' => 'required|string|max:255|unique:source_branches,name,' . $request->id,
        ]);

        $sourceBranch = SourceBranch::findOrFail($validated['id']);
        $sourceBranch->update([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Source Branch updated successfully!');
    }

    public function sourceBranchesChangeStatus($id)
    {
        $sourceBranch = SourceBranch::findOrFail($id);
        $sourceBranch->status = $sourceBranch->status === 'active' ? 'inactive' : 'active';
        $sourceBranch->save();

        return redirect()->back()->with('success', 'Source Branch status updated successfully!');
    }




    public function modeOfPaymentsIndex()
    {
        $modeOfPayments = ModeOfPayment::orderBy('status', 'asc')->get();

        return view('dropdown.mode_of_payments', compact(
            'modeOfPayments'
        ));
    }

    public function modeOfPaymentsStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:mode_of_payments,name',
        ]);

        ModeOfPayment::create([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Mode of Payment added successfully!');
    }

    public function modeOfPaymentsUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:mode_of_payments,id',
            'name' => 'required|string|max:255|unique:mode_of_payments,name,' . $request->id,
        ]);

        $modeOfPayment = ModeOfPayment::findOrFail($validated['id']);
        $modeOfPayment->update([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Mode of Payment updated successfully!');
    }

    public function modeOfPaymentsChangeStatus($id)
    {
        $modeOfPayment = ModeOfPayment::findOrFail($id);
        $modeOfPayment->status = $modeOfPayment->status === 'active' ? 'inactive' : 'active';
        $modeOfPayment->save();

        return redirect()->back()->with('success', 'Mode of Payment status updated successfully!');
    }







    public function subproductsIndex()
    {
        $subproducts = Subproduct::with('product')->orderBy('status', 'asc')->get();
        $products = Product::all(); // Fetch all products for the dropdown

        return view('dropdown.sub_product', compact(
            'subproducts',
            'products'

        ));
    }

    public function subproductsStore(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255|unique:subproducts,name',
        ]);

        Subproduct::create([
            'product_id' => $validated['product_id'],
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Subproduct added successfully!');
    }

    public function subproductsUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:subproducts,id',
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255|unique:subproducts,name,' . $request->id,
        ]);

        $subproduct = Subproduct::findOrFail($validated['id']);
        $subproduct->update([
            'product_id' => $validated['product_id'],
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Subproduct updated successfully!');
    }

    public function subproductsChangeStatus($id)
    {
        $subproduct = Subproduct::findOrFail($id);
        $subproduct->status = $subproduct->status === 'active' ? 'inactive' : 'active';
        $subproduct->save();

        return redirect()->back()->with('success', 'Subproduct status updated successfully!');
    }








    public function ifGdfiIndex()
    {
        $ifGdfis = IfGdfi::orderBy('status', 'asc')->get();
        return view('dropdown.ifGdfis', compact('ifGdfis'));
    }

    public function ifGdfiStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:if_gdfis,name',
        ]);

        IfGdfi::create([
            'name' => $validated['name']
        ]);

        return redirect()->back()->with('success', 'IfGdfi added successfully!');
    }

    public function ifGdfiUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:if_gdfis,id',
            'name' => 'required|string|max:255|unique:if_gdfis,name,' . $request->id,
        ]);

        $ifGdfi = IfGdfi::findOrFail($validated['id']);
        $ifGdfi->update([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'IfGdfi updated successfully!');
    }

    public function ifGdfiChangeStatus($id)
    {
        $ifGdfi = IfGdfi::findOrFail($id);
        $ifGdfi->status = $ifGdfi->status === 'active' ? 'inactive' : 'active';
        $ifGdfi->save();

        return redirect()->back()->with('success', 'IfGdfi status updated successfully!');
    }






    public function commissionersIndex()
    {
        $commissioners = Commissioner::orderBy('status', 'asc')->get();
        return view('dropdown.commissioners', compact('commissioners'));
    }

    public function commissionersStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:commissioners,name',
        ]);

        Commissioner::create([
            'name' => $validated['name']
        ]);

        return redirect()->back()->with('success', 'Commissioner added successfully!');
    }

    public function commissionersUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:commissioners,id',
            'name' => 'required|string|max:255|unique:commissioners,name,' . $request->id,
        ]);

        $commissioner = Commissioner::findOrFail($validated['id']);
        $commissioner->update([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Commissioner updated successfully!');
    }

    public function commissionersChangeStatus($id)
    {
        $commissioner = Commissioner::findOrFail($id);
        $commissioner->status = $commissioner->status === 'active' ? 'inactive' : 'active';
        $commissioner->save();

        return redirect()->back()->with('success', 'Commissioner status updated successfully!');
    }






    //Sales Managers
    public function salesManagersIndex()
    {
        $salesManagers = SalesManager::with(['user', 'team'])->orderBy('status', 'asc')->get();
        $users = User::all(); // Fetch all users for the dropdown
        $teams = Team::all(); // Fetch all teams for the dropdown

        return view('dropdown.salesManager', compact(
            'salesManagers',
            'users',
            'teams'
        ));
    }

    public function salesManagersStore(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'username' => 'required|string|max:255|unique:users,username',
                'password' => 'required|string|min:8|confirmed',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'viber_number' => 'nullable|string|max:20',
                'team_id' => 'required|exists:teams,id',
            ]);

            // Create a new user
            $user = User::create([
                'username' => $validated['username'],
                'password' => bcrypt($validated['password']),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'viber_number' => $validated['viber_number'] ?? null,
                'role_id' => 9,  // Automatically set role_id to 9
                'status' => 'active',  // Automatically set status to active
            ]);

            // Create the Sales Manager and associate it with the user and team
            SalesManager::create([
                'user_id' => $user->id,
                'team_id' => $validated['team_id'],
                'name' => $validated['name'],
            ]);

            return redirect()->back()->with('success', 'Sales Manager added successfully!');
        } catch (\Exception $e) {
            Log::error('Error adding Sales Manager: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while adding the Sales Manager.');
        }
    }

    public function salesManagersUpdate(Request $request)
    {
        try {
            // Get the current sales manager
            $salesManager = SalesManager::findOrFail($request->id);

            // Get the associated user
            $user = $salesManager->user;

            // Validate the incoming request
            $validated = $request->validate([
                'id' => 'required|exists:sales_managers,id',
                'name' => 'required|string|max:255',
                'password' => 'nullable|string|min:8|confirmed', // Password is optional
                'viber_number' => 'nullable|string|max:20',
                'team_id' => 'required|exists:teams,id', // Ensure valid team ID
            ]);

            // Only validate and update the username if it has changed
            if ($request->username !== $user->username) {
                $request->validate([
                    'username' => 'required|string|max:255|unique:users,username',
                ]);
            }

            // Only validate and update the email if it has changed
            if ($request->email !== $user->email) {
                $request->validate([
                    'email' => 'required|email|max:255|unique:users,email',
                ]);
            }

            // Update the user information only if something has changed
            $user->update(array_filter([
                'username' => $request->username !== $user->username ? $request->username : null,
                'password' => $request->password ? bcrypt($request->password) : null,
                'name' => $request->name !== $user->name ? $request->name : null,
                'email' => $request->email !== $user->email ? $request->email : null,
                'viber_number' => $request->viber_number !== $user->viber_number ? $request->viber_number : null,
                'role_id' => 9,  // Role is kept as 9
                'status' => 'active', // Keep status as active
            ]));

            // Update the Sales Manager's team information if team_id or name is changed
            $salesManager->update(array_filter([
                'team_id' => $request->team_id !== $salesManager->team_id ? $request->team_id : null,
                'name' => $request->name !== $salesManager->name ? $request->name : null,
            ]));

            // Success message
            return redirect()->back()->with('success', 'Sales Manager updated successfully!');
        } catch (\Exception $e) {
            // Log error details for debugging
            Log::error('Error updating Sales Manager: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the Sales Manager.');
        }
    }

    public function salesManagersChangeStatus($id)
    {
        $salesManager = SalesManager::findOrFail($id);
        $salesManager->status = $salesManager->status === 'active' ? 'inactive' : 'active';
        $salesManager->save();

        return redirect()->back()->with('success', 'Sales Manager status updated successfully!');
    }


    public function telesIndex()
    {
        $teles = Tele::orderBy('status', 'asc')->get();
        return view('dropdown.teles', compact('teles'));
    }

    public function telesStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teles,name',
        ]);

        Tele::create([
            'name' => $validated['name']
        ]);

        return redirect()->back()->with('success', 'Tele added successfully!');
    }

    public function telesUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:teles,id',
            'name' => 'required|string|max:255|unique:teles,name,' . $request->id,
        ]);

        $tele = Tele::findOrFail($validated['id']);
        $tele->update([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Tele updated successfully!');
    }

    public function telesChangeStatus($id)
    {
        $tele = Tele::findOrFail($id);
        $tele->status = $tele->status === 'active' ? 'inactive' : 'active';
        $tele->save();

        return redirect()->back()->with('success', 'Tele status updated successfully!');
    }










}
