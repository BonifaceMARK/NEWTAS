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
            'from_campaign' => null,
            'to_campaign' => $inventoryItem->campaign,
            'department' => $inventoryItem->department,
            'from_department' => null,
            'to_department' => $inventoryItem->department,
            'assigned_to' => $inventoryItem->assigned_to,
            'from_assigned_to' => null,
            'to_assigned_to' => $inventoryItem->assigned_to,
            'moved_at' => now(),
            'remarks' => 'Initial item registration',
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
        $options = InventoryOption::orderBy('option_type')->orderBy('option_value')->get()->groupBy('option_type');

        return view('inventory.show', compact('inventoryItem', 'options'));
      }

      public function edit(InventoryItem $inventoryItem){
        $inventoryItem->load('campaignHistory');
        $options = InventoryOption::orderBy('option_type')->orderBy('option_value')->get()->groupBy('option_type');

        return view('inventory.show', compact('inventoryItem', 'options'));
      }

      public function update(Request $request, InventoryItem $inventoryItem){
        $validated = $request->validate([
            'asset_tag' => ['required', 'string', 'max:255', 'unique:tbl_inventory_items,asset_tag,' . $inventoryItem->id],
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
        ]);

        $inventoryItem->update($validated);

        return redirect()->route('inventory.show', $inventoryItem)
            ->with('success', 'Inventory item updated successfully.');
      }

      public function createGatepass(){
        $inventoryItems = InventoryItem::orderBy('item_name')->get();
        $locationOptions = InventoryOption::where('option_type', 'location')
          ->orderBy('option_value')
          ->get();

        return view('gatepass.add', compact('inventoryItems', 'locationOptions'));
      }

      public function gatepass(Request $request){
        $this->validateTransferSelection($request);
        $items = $this->prepareGatepassItems($request);

        return view('gatepass.print', [
          'items' => $items,
          'owner' => $request->input('owner') ?: 'N/A',
          'contact' => $request->input('contact') ?: 'N/A',
          'fromSiteFloor' => $request->input('from_site_floor') ?: 'N/A',
          'toSiteFloor' => $request->input('to_site_floor') ?: 'N/A',
          'bearer' => $request->input('bearer') ?: 'N/A',
          'date' => $request->input('date') ?: now()->format('M d, Y'),
          'time' => $request->input('time') ?: now()->format('h:i A'),
        ]);
      }

      public function gatepassList(Request $request){
        $this->validateTransferSelection($request);
        $items = $this->prepareGatepassItems($request);

        return view('gatepass.list', [
          'items' => $items,
          'owner' => $request->input('owner') ?: 'N/A',
          'bearer' => $request->input('bearer') ?: 'N/A',
          'date' => $request->input('date') ?: now()->format('M d, Y'),
          'fromSiteFloor' => $request->input('from_site_floor') ?: 'N/A',
          'toSiteFloor' => $request->input('to_site_floor') ?: 'N/A',
        ]);
      }

      protected function validateTransferSelection(Request $request): void
      {
        $toLocation = trim((string) $request->input('to_site_floor', ''));
        $fromLocation = trim((string) $request->input('from_site_floor', ''));

        if ($toLocation !== '' && strtolower($toLocation) === strtolower($fromLocation)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'to_site_floor' => ['Destination site cannot be the same as the source site.'],
            ]);
        }

        $rawItems = $request->input('items', []);

        foreach ($rawItems as $row) {
            $itemId = $row['item_id'] ?? null;
            if (!$itemId || $toLocation === '') {
                continue;
            }

            $inventoryItem = InventoryItem::find($itemId);
            if (!$inventoryItem) {
                continue;
            }

            if ($inventoryItem->isAlreadyAtLocation($toLocation)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'to_site_floor' => ['Item "' . ($inventoryItem->item_name ?? 'Selected asset') . '" is already at ' . $toLocation . '.'],
                ]);
            }
        }
      }

      protected function prepareGatepassItems(Request $request): array
      {
        $rawItems = $request->input('items', []);
        $items = [];

        if (!empty($rawItems)) {
          foreach ($rawItems as $row) {
            if (empty($row)) {
              continue;
            }

            $itemId = $row['item_id'] ?? null;
            $inventoryItem = $itemId ? InventoryItem::find($itemId) : null;

            $items[] = [
              'item_id' => $itemId,
              'asset_tag' => $inventoryItem?->asset_tag ?? ($row['asset_tag'] ?? ''),
              'item_name' => $inventoryItem?->item_name ?? ($row['item_name'] ?? 'Inventory Item'),
              'brand' => $inventoryItem?->brand ?? ($row['brand'] ?? ''),
              'model' => $inventoryItem?->model ?? ($row['model'] ?? ''),
              'quantity' => (int) ($row['quantity'] ?? 1),
              'unit' => $row['unit'] ?? ($inventoryItem?->category ?? 'Unit'),
              'description' => $row['description'] ?? trim(($inventoryItem?->item_name ?? 'Inventory Item') . ' - ' . ($inventoryItem?->brand ?? '') . ' ' . ($inventoryItem?->model ?? '')),
              'remarks' => $row['remarks'] ?? 'Transferred from ' . ($inventoryItem?->location ?? 'current site') . ' to new site',
            ];
          }
        } elseif ($request->filled('item_id')) {
          $inventoryItem = InventoryItem::find($request->item_id);

          $items[] = [
            'item_id' => $inventoryItem?->id,
            'asset_tag' => $inventoryItem?->asset_tag ?? '',
            'item_name' => $inventoryItem?->item_name ?? 'Inventory Item',
            'brand' => $inventoryItem?->brand ?? '',
            'model' => $inventoryItem?->model ?? '',
            'quantity' => (int) ($request->input('quantity') ?: 1),
            'unit' => $request->input('unit') ?: ($inventoryItem?->category ?? 'Unit'),
            'description' => $request->input('description') ?: trim(($inventoryItem?->item_name ?? 'Inventory Item') . ' - ' . ($inventoryItem?->brand ?? '') . ' ' . ($inventoryItem?->model ?? '')),
            'remarks' => $request->input('remarks') ?: 'Transferred from ' . ($inventoryItem?->location ?? 'current site') . ' to new site',
          ];
        }

        if (empty($items)) {
          $items[] = [
            'item_id' => null,
            'asset_tag' => '',
            'item_name' => 'Inventory Item',
            'brand' => '',
            'model' => '',
            'quantity' => 1,
            'unit' => 'Unit',
            'description' => 'Inventory Item',
            'remarks' => 'Transferred',
          ];
        }

        return $items;
      }

      public function gatepassForItem(InventoryItem $inventoryItem){
        $inventoryItem->load('campaignHistory');

        return view('gatepass.print', [
          'inventoryItem' => $inventoryItem,
          'owner' => $inventoryItem->assigned_to ?: 'N/A',
          'contact' => $inventoryItem->department ?: 'N/A',
          'siteFloor' => $inventoryItem->location ?: 'N/A',
          'bearer' => $inventoryItem->assigned_to ?: 'N/A',
          'quantity' => 1,
          'unit' => $inventoryItem->category ?: 'Unit',
          'description' => trim(($inventoryItem->item_name ?? 'Inventory Item') . ' - ' . ($inventoryItem->brand ?? '') . ' ' . ($inventoryItem->model ?? '')),
          'remarks' => 'Transferred from ' . ($inventoryItem->location ?: 'current site') . ' to new site',
          'date' => now()->format('M d, Y'),
          'time' => now()->format('h:i A'),
        ]);
      }

      public function inventoryreports(){
        return view('inventory.reports');
        }


        public function asset(){
          return view('inventory.asset');
        }
        
}
