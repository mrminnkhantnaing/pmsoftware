<?php

namespace App\Http\Controllers\Operations;

use App\Models\Flat;
use App\Models\Floor;
use App\Models\Building;
use App\Models\Partition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartitionController extends Controller
{
    // Show All Partitions
    public function index() {
        // $partitions = Cache::remember('partitions-index', now()->addDay(), function() {
        //     return Partition::with(['building', 'floor', 'flat'])->orderBy('p_number', 'asc')->get();
        // });

        $partitions = Partition::with(['building', 'floor', 'flat'])->orderBy('p_number', 'asc')->get();

        return view('operations.partitions.index', compact('partitions'));
    }

    // Create Partition
    public function create() {
        $buildings = Building::orderBy('name', 'asc')->get();

        return view('operations.partitions.create', compact('buildings'));
    }

    // Store Partition
    public function store(Request $request) {
        $request->validate([
            'p_number' => 'required',
            'building_id' => 'required',
            'floor_id' => 'required',
            'flat_id' => 'required',
        ],
        [
            'p_number.required' => 'The partition no. field is required.',
            'building_id.required' => 'The building field is required.',
            'floor_id.required' => 'The floor field is required.',
            'flat_id.required' => 'The flat field is required.',
        ]);

        Partition::create([
            'p_number' => $request->p_number,
            'building_id' => $request->building_id,
            'floor_id' => $request->floor_id,
            'flat_id' => $request->flat_id,
            'status' => 'available',
        ]);

        return redirect()->route('partitions.index')->with('success', 'You have successfully created a new partition!');
    }

    // Show Single Partition
    public function show($id) {
        $partition = Partition::findOrFail($id);

        return view('operations.partitions/show', compact('partition'));
    }

    // Edit Partition
    public function edit($id) {
        $partition = Partition::findOrFail($id);
        $buildings = Building::orderBy('name', 'asc')->get();

        // Related Floors To Building
        $building_for_related_floors = Building::firstWhere('id', $partition->building_id);
        $floors = Floor::where('building_id', $building_for_related_floors->id)->orderBy('name', 'asc')->get();

        // Related Flats To Floors
        $floor_for_related_flats = Floor::firstWhere('id', $partition->floor_id);
        $flats = Flat::where('floor_id', $floor_for_related_flats->id)->orderBy('flat_no', 'asc')->get();

        return view('operations.partitions.edit', compact('buildings', 'floors', 'flats', 'partition'));
    }

    // Update Partition
    public function update(Request $request, $id) {
        $request->validate([
            'p_number' => 'required',
            'building_id' => 'required',
            'floor_id' => 'required',
            'flat_id' => 'required',
        ],
        [
            'p_number.required' => 'The partition no. field is required.',
            'building_id.required' => 'The building field is required.',
            'floor_id.required' => 'The floor field is required.',
            'flat_id.required' => 'The flat field is required.',
        ]);

        $partition = Partition::findOrFail($id);
        $partition->update([
            'p_number' => $request->p_number,
            'building' => $request->building_id,
            'floor_id' => $request->floor_id,
            'flat_id' => $request->flat_id,
        ]);

        return redirect()->route('partitions.index')->with('success', 'You have successfully updated a partition!');
    }

    // Destroy Partition
    public function destroy($id) {
        $partition = Partition::findOrFail($id);

        $partition->delete();

        return redirect()->route('partitions.index')->with('success', 'You have successfully deleted a partition!');
    }
}
