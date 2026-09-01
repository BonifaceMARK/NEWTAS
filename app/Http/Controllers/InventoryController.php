<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\InventoryOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    public function inventorydash(Request $request){
      $department = $request->query('department');
      $search = trim((string) $request->query('search'));
      $status = $request->query('status');
      $inventoryItems = InventoryItem::when($department, function ($query, $department) {
        $query->where('department', $department);
      })->when($search, function ($query, $search) {
        $query->where(function ($query) use ($search) {
          $query->where('asset_tag', 'like', "%{$search}%")
            ->orWhere('item_name', 'like', "%{$search}%")
            ->orWhere('serial_number', 'like', "%{$search}%")
            ->orWhere('assigned_to', 'like', "%{$search}%");
        });
      })->when($status, function ($query, $status) {
        $query->where('status', $status);
      })->latest()->get();
      $departments = InventoryItem::query()
        ->whereNotNull('department')
        ->where('department', '<>', '')
        ->distinct()
        ->orderBy('department')
        ->pluck('department');

      $statuses = InventoryItem::query()
        ->whereNotNull('status')
        ->where('status', '<>', '')
        ->distinct()
        ->orderBy('status')
        ->pluck('status');

      return view('inventory.index', compact('inventoryItems', 'departments', 'department', 'search', 'status', 'statuses'));
    }

      public function inventoryadd(){
        $options = InventoryOption::orderBy('option_type')->orderBy('option_value')->get()->groupBy('option_type');

        return view('inventory.add', compact('options'));
      }

      public function values(){
        $options = InventoryOption::orderBy('option_type')->orderBy('option_value')->get()->groupBy('option_type');

        return view('inventory.values', compact('options'));
      }

      public function storeValue(Request $request){
        $validated = $request->validate([
          'option_type' => ['required', 'in:category,brand,department,campaign,location,status'],
          'option_value' => ['required', 'string', 'max:255'],
        ]);

        InventoryOption::firstOrCreate([
          'option_type' => $validated['option_type'],
          'option_value' => trim($validated['option_value']),
        ]);

        return redirect()->route('inventory.values')->with('success', 'Inventory option saved successfully.');
      }

      public function deleteValue(InventoryOption $option){
        $option->delete();

        return redirect()->route('inventory.values')->with('success', 'Inventory option deleted successfully.');
      }

      public function bulkDelete(Request $request){
        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
          return redirect()->back()->with('error', 'Please select at least one inventory item to delete.');
        }

        $deletedCount = InventoryItem::whereIn('id', $selectedItems)->delete();

        return redirect()->back()->with('success', $deletedCount . ' inventory item(s) deleted successfully.');
      }

      public function store(Request $request){
        $validated = $request->validate([
            'asset_tag' => ['required', 'string', 'max:255', 'unique:tbl_inventory_items,asset_tag'],
            'item_name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'purchase_date' => ['nullable', 'date'],
            'warranty_expiry' => ['nullable', 'date', 'after_or_equal:purchase_date'],
            'assigned_to' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'campaign' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'remarks' => ['nullable', 'string'],
            'file_attach' => ['nullable', 'array'],
            'file_attach.*' => ['file', 'max:5120'],
        ]);

        $filePaths = [];
        foreach ($request->file('file_attach', []) as $file) {
            $filePaths[] = $file->store('inventory', 'public');
        }

        $validated['history'] = json_encode([]);
        $validated['file_attach'] = json_encode($filePaths);

        $inventoryItem = InventoryItem::create($validated);

        if ($inventoryItem->campaign) {
          $inventoryItem->campaignHistory()->create([
            'campaign' => $inventoryItem->campaign,
            'department' => $inventoryItem->department,
            'assigned_to' => $inventoryItem->assigned_to,
          ]);
        }

        return redirect()->route('inventory.dashboard')
            ->with('success', 'Inventory item added successfully.');
      }

      public function inventorylist(){
        $inventoryItems = InventoryItem::latest()->get();

        return view('inventory.index', compact('inventoryItems'));
      }

      public function show(InventoryItem $inventoryItem){
        $inventoryItem->load('campaignHistory');

        return view('inventory.show', compact('inventoryItem'));
      }

      public function gatepass(){
        return view('gatepass.print');
      }

      public function inventoryreports(){
        return view('inventory.reports');
        }
        
}
