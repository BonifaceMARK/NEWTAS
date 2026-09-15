<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Floor;
use App\Models\PCSweep;
use App\Models\Workstation;


class WorkstationController extends Controller
{
     // Display all workstations
    public function index()
    {
        $workstations = Workstation::with('floor')->get();
        $floors = Floor::all();
        return view('workstations.index', compact('workstations', 'floors'));
    }

    // Store new workstation
    public function store(Request $request)
    {
        $request->validate([
            'workstation_no' => 'required|unique:tbl_workstations,workstation_no',
            'floor_id' => 'required|exists:floors,id',
            'hostname' => 'nullable|string',
            'ip_address' => 'nullable|ip',
            'mac_address' => 'nullable|string',
            'os' => 'nullable|string',
            'assigned_user' => 'nullable|string',
            'role' => 'nullable|string',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        Workstation::create($request->all());

        return redirect()->route('workstations.index')->with('success', 'Workstation added successfully.');
    }

    // Delete workstation
    public function destroy($id)
    {
        $ws = Workstation::findOrFail($id);
        $ws->delete();

        return redirect()->route('workstations.index')->with('success', 'Workstation deleted successfully.');
    }
}
