<?php

namespace App\Http\Controllers\Operations;

use App\Models\Flat;
use App\Models\Floor;
use App\Models\Building;
use App\Models\Partition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FlatController extends Controller
{
    // Show All Flats
    public function index() {
        $flats = Flat::withCount(['partitions'])->with(['floor', 'building'])->orderBy('flat_no', 'asc')->get();

        return view('operations.flats.index', compact('flats'));
    }

    // Create Flat
    public function create() {
        $buildings = Building::orderBy('name', 'asc')->get();

        return view('operations.flats.create', compact('buildings'));
    }

    // Store Flat
    public function store(Request $request) {
        $request->validate([
            'flat_no' => 'required',
            'building_id' => 'required',
            'floor_id' => 'required',
        ],
        [
            'flat_no.required' => 'The flat no. field is required.',
            'building_id.required' => 'The building field is required.',
            'floor_id.required' => 'The floor field is required.',
        ]);

        Flat::create([
            'flat_no' => $request->flat_no,
            'building_id' => $request->building_id,
            'floor_id' => $request->floor_id,
        ]);

        return redirect()->route('flats.index')->with('success', 'You have successfully created a new flat!');
    }

    // Show Single Flat
    public function show($id) {
        $flat = Flat::withCount('partitions')->with('partitions', 'partitions.building', 'partitions.floor', 'partitions.flat')->findOrFail($id);

        return view('operations.flats.show', compact('flat'));
    }

    // Edit Flat
    public function edit($id) {
        $flat = Flat::findOrFail($id);
        $buildings = Building::orderBy('name', 'asc')->get();
        // Related Floors To Building
        $building_for_related_floors = Building::firstWhere('id', $flat->building_id);
        $floors = Floor::where('building_id', $building_for_related_floors->id)->orderBy('name', 'asc')->get();

        return view('operations.flats.edit', compact('flat', 'buildings', 'floors'));
    }

    // Store Flat
    public function update(Request $request, $id) {
        $request->validate([
            'flat_no' => 'required',
            'building_id' => 'required',
            'floor_id' => 'required',
        ],
        [
            'flat_no.required' => 'The flat no. field is required.',
            'building_id.required' => 'The building field is required.',
            'floor_id.required' => 'The floor field is required.',
        ]);

        $flat = Flat::findOrFail($id);
        $flat->update([
            'flat_no' => $request->flat_no,
            'floor_id' => $request->floor_id,
            'building_id' => $request->building_id
        ]);

        return redirect()->route('flats.index')->with('success', 'You have successfully updated a flat!');
    }

    // Destroy Flat
    public function destroy($id) {
        $flat = Flat::where('id', $id)->first();
        $partitions = Partition::where('flat_id', $flat->id)->get();

        if($partitions->count() > 0) {
            return redirect()->route('flats.index')->with('error', 'You can not delete this flat because it has one or more related partitions!');
        }

        $flat->delete();

        return redirect()->route('flats.index')->with('success', 'You have successfully deleted a flat!');
    }
}
