<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Workstation;
use App\Models\WorkstationStatus;
use Illuminate\Http\Request;

class WorkstationController extends Controller
{
    /**
     * Display workstation list
     */
public function createFloor()
{
return view('floors.create');
}
   public function storeFloor(Request $request)
{
    $validated = $request->validate([
        'floor_no' => 'required',
        'floor_name' => 'required',
        'max_workstations' => 'nullable|integer|min:0',
        'remarks' => 'nullable|string|max:1000',
    ]);

    Floor::create([
        'floor_no' => $validated['floor_no'],
        'floor_name' => $validated['floor_name'],
        'max_workstations' => $validated['max_workstations'] ?? null,
        'remarks' => $validated['remarks'] ?? null,
    ]);

    return redirect()
        ->route('workstations.bulkCreate')
        ->with('success', 'Floor created successfully.');
}
    public function index()
    {
        $workstations = Workstation::with([
            'floor',
            'statuses'
        ])->latest()->get();

        return view('workstations.index', compact('workstations'));
    }

    /**
     * Show bulk create page
     */
    public function bulkCreate()
    {
      $floors = Floor::orderBy('floor_name')->get();

        return view('workstations.bulk-create', compact('floors'));
    }

    /**
     * Store bulk workstations
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'floor_id' => 'required|exists:tbl_floors,id',
            'prefix'   => 'required|string|max:50',
            'quantity' => 'required|integer|min:1|max:500',
        ]);

        for ($i = 1; $i <= $request->quantity; $i++) {

            $workstation = Workstation::create([
                'workstation_no' => $request->prefix . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'floor_id'       => $request->floor_id,
                'hostname'       => null,
                'ip_address'     => null,
                'mac_address'    => null,
                'os'             => null,
                'assigned_user'  => null,
                'role'           => null,
                'status'         => 'Pending',
                'remarks'        => null,
            ]);

            WorkstationStatus::insert([
                [
                    'workstation_id' => $workstation->id,
                    'task_name'      => '1st PC Sweep',
                    'status'         => 'Pending',
                    'remarks'        => null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ],
                [
                    'workstation_id' => $workstation->id,
                    'task_name'      => '2nd PC Sweep',
                    'status'         => 'Pending',
                    'remarks'        => null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ],
                [
                    'workstation_id' => $workstation->id,
                    'task_name'      => '3rd PC Sweep',
                    'status'         => 'Pending',
                    'remarks'        => null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ],
            ]);
        }

        return redirect()
            ->route('workstations.index')
            ->with('success', $request->quantity . ' workstations created successfully.');
    }

    /**
     * Show create workstation page
     */
    public function create()
    {
        $floors = Floor::orderBy('name')->get();

        return view('workstations.create', compact('floors'));
    }

    /**
     * Show workstation details
     */
    public function show($id)
    {
        $workstation = Workstation::with([
            'floor',
            'statuses',
            'assets',
            'pcSweeps'
        ])->findOrFail($id);

        return view('workstations.show', compact('workstation'));
    }

    /**
     * Show edit workstation page
     */
    public function edit($id)
    {
        $workstation = Workstation::findOrFail($id);
        $floors = Floor::orderBy('name')->get();

        return view('workstations.edit', compact('workstation', 'floors'));
    }

    /**
     * Delete workstation
     */
    public function destroy($id)
    {
        $workstation = Workstation::findOrFail($id);

        WorkstationStatus::where(
            'workstation_id',
            $workstation->id
        )->delete();

        $workstation->delete();

        return redirect()
            ->route('workstations.index')
            ->with('success', 'Workstation deleted successfully.');
    }
}