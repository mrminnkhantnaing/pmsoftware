<?php

namespace App\Http\Controllers\Operations;

use App\Models\Flat;
use App\Models\Floor;
use App\Models\Building;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FloorController extends Controller
{
    // Show All Floors
    public function index() {
        $floors = Floor::withCount(['flats', 'partitions'])->with('building')->orderBy('name', 'asc')->get();

        return view('operations.floors.index', compact('floors'));
    }

    // Create Floor
    public function create() {
        $buildings = Building::orderBy('name', 'asc')->get();

        return view('operations.floors/create', compact('buildings'));
    }

    // Store Floor
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'building_id' => 'required',
        ],
        [
            'building_id.required' => 'The building field is required.',
        ]);

        Floor::create([
            'name' => $request->name,
            'building_id' => $request->building_id,
        ]);

        return redirect()->route('floors.index')->with('success', 'You have successfully created a new floor!');
    }

    // Show Single Floor
    public function show($id) {
        $floor = Floor::withCount(['flats', 'partitions'])->with('flats')->findOrFail($id);

        return view('operations.floors.show', compact('floor'));
    }

    // Edit Floor
    public function edit($id) {
        $floor = Floor::findOrFail($id);
        $buildings = Building::orderBy('name', 'asc')->get();

        return view('operations.floors/edit', compact('floor', 'buildings'));
    }

    // Update Floor
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'building_id' => 'required',
        ],
        [
            'building_id.required' => 'The building field is required.',
        ]);

        $building = Floor::findOrFail($id);
        $building->update([
            'name' => $request->name,
            'building_id' => $request->building_id,
        ]);

        return redirect()->route('floors.index')->with('success', 'You have successfully updated a floor!');
    }

    // Destroy Floor
    public function destroy($id) {
        $floor = Floor::findOrFail($id);
        $flats = Flat::where('floor_id', $floor->id)->get();

        if ($flats->count() > 0) {
            return redirect()->route('floors.index')->with('error', 'You can not delete this floor because it has one or more related flats!');
        }

        $floor->delete();

        return redirect()->route('floors.index')->with('success', 'You have successfully deleted a floor!');
    }
}
