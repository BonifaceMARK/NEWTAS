<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\InventoryOption;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display Stock List
     */
    public function index(Request $request)
    {
        $query = Stock::query();

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('item_name', 'like', '%' . $request->search . '%')
                    ->orWhere('category', 'like', '%' . $request->search . '%')
                    ->orWhere('brand', 'like', '%' . $request->search . '%')
                    ->orWhere('model', 'like', '%' . $request->search . '%');

            });

        }

        $stocks = $query
            ->orderBy('item_name')
            ->paginate(15);

        $totalItems = Stock::count();

        $totalStock = Stock::sum('quantity');

        $lowStock = Stock::whereColumn(
            'quantity',
            '<=',
            'reorder_level'
        )
        ->where('quantity', '>', 0)
        ->count();

        $outOfStock = Stock::where('quantity', 0)
            ->count();

        return view('stock.index', compact(
            'stocks',
            'totalItems',
            'totalStock',
            'lowStock',
            'outOfStock'
        ));
    }

    /**
     * Show Create Form
     */
    public function create()
    {
        $options = InventoryOption::orderBy('option_type')->orderBy('option_value')->get()->groupBy('option_type');

        return view('stock.add', compact('options'));
    }

    /**
     * Save Stock Item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'reorder_level' => 'nullable|integer|min:0',
            'location' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        Stock::create($validated);

        return redirect()
            ->route('stock.index')
            ->with('success', 'Stock item created successfully.');
    }

    /**
     * View Single Item
     */
    public function show($id)
    {
        $stock = Stock::findOrFail($id);

        return view('stock.show', compact('stock'));
    }

    /**
     * Edit Form
     */
    public function edit($id)
    {
        $stock = Stock::findOrFail($id);

        $options = [];

        return view('stock.edit', compact(
            'stock',
            'options'
        ));
    }

    /**
     * Update Item
     */
    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);

        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'reorder_level' => 'nullable|integer|min:0',
            'location' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        $stock->update($validated);

        return redirect()
            ->route('stock.index')
            ->with('success', 'Stock item updated successfully.');
    }

    /**
     * Delete Item
     */
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);

        $stock->delete();

        return redirect()
            ->route('stock.index')
            ->with('success', 'Stock item deleted successfully.');
    }

    /**
     * Stock In Page
     */
    public function stockIn($id)
    {
        $stock = Stock::findOrFail($id);

        return view('stock.stock-in', compact('stock'));
    }

    /**
     * Process Stock In
     */
    public function processStockIn(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $stock = Stock::findOrFail($id);

        $stock->increment(
            'quantity',
            $request->quantity
        );

        return redirect()
            ->route('stock.index')
            ->with('success', 'Stock added successfully.');
    }

    /**
     * Stock Out Page
     */
    public function stockOut($id)
    {
        $stock = Stock::findOrFail($id);

        return view('stock.stock-out', compact('stock'));
    }

    /**
     * Process Stock Out
     */
    public function processStockOut(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $stock = Stock::findOrFail($id);

        if ($request->quantity > $stock->quantity) {

            return back()->withErrors([
                'quantity' => 'Not enough stock available.'
            ]);
        }

        $stock->decrement(
            'quantity',
            $request->quantity
        );

        return redirect()
            ->route('stock.index')
            ->with('success', 'Stock removed successfully.');
        }   
}