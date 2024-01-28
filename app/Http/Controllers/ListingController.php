<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;

class ListingController extends Controller
{

    public function index(Request $request) {

        $user = auth()->check() ? auth()->user() : null;

        if($user->role_type === 'a'){
            $listings = Listing::paginate(10);
            return view('dashboard', compact('listings'));
        }
        return redirect()->route('profile');

    }

    public function edit($id) {
        
        $listing = Listing::findOrFail($id);

        return view('edit_form', compact('listing'));
    }

    public function create(Request $request) {

        $user = auth()->check() ? auth()->user() : null;

         $listing = Listing::create([
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'user_id' => $user->id
        ]);

        if($listing){
            return response(['success' => 'Successfully create list']);
        }
    }

    public function update(Request $request) {
        $listing = Listing::findOrFail($request->list_id);

        $listing->update([
            'name' => $request->list_name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        if($listing){
            return redirect()->route('dashboard')->with('error', 'Listing not found');
        }
        
    }

    public function delete($id) {
        
        $list = Listing::find($id);

        if ($list) {
            $list->delete();
            return redirect()->route('dashboard')->with('success', 'Listing deleted successfully');
        } else {
            return redirect()->route('dashboard')->with('error', 'Listing not found');
        }
       
    }
}
