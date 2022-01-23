<?php

namespace App\Http\Controllers\Operations;

use App\Models\Floor;
use App\Models\Building;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuildingController extends Controller
{
    // Show All Buildings
    public function index() {
        $buildings = Building::withCount(['floors', 'flats', 'partitions'])->orderBy('name', 'asc')->get();

        return view('operations.buildings.index', compact('buildings'));
    }

    // Create Building
    public function create() {
        return view('operations.buildings.create');
    }

    // Store Building
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:buildings,name',
            'location' => 'required',
            'full_address' => 'required',
        ],
        [
            'full_address.required' => 'The address field is required.',
        ]);

        $building = Building::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'location' => $request->location,
            'full_address' => $request->full_address,
        ]);

        return redirect()->route('buildings.index')->with('success', 'You have successfully created a building!');
    }

    // Show Single Building
    public function show($slug) {
        $building = Building::withCount(['floors', 'flats', 'partitions'])->where('slug', $slug)->firstOrFail();

        return view('operations.buildings.show', compact('building'));
    }

    // Edit Building
    public function edit($slug) {
        $building = Building::withCount(['floors', 'flats', 'partitions'])->where('slug', $slug)->firstOrFail();

        return view('operations.buildings.edit', compact('building'));
    }

    // Update Building
    public function update(Request $request, $slug) {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'full_address' => 'required',
        ],
        [
            'full_address.required' => 'The address field is required.',
        ]);

        $building = Building::where('slug', $slug)->first();

        $building->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'location' => $request->location,
            'full_address' => $request->full_address,
        ]);

        return redirect()->route('buildings.index')->with('success', 'You have successfully updated the building!');
    }

    // Destroy Building
    public function destroy($slug) {
        $building = Building::where('slug', $slug)->first();
        $floors = Floor::where('building_id', $building->id)->get();

        if($floors->count() > 0) {
            return redirect()->route('buildings.index')->with('error', 'You can not delete this building because it has one or more related floors!');
        }

        $building->delete();

        return redirect()->route('buildings.index')->with('success', 'You have successfully deleted a building!');
    }
}
