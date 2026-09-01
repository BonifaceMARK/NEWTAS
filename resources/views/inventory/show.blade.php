@section('title', env('APP_NAME'))

@include('layouts.title')

<style>
    :root {
        --company-violet: #4f46e5;
        --company-violet-dark: #312e81;
        --company-muted: #64748b;
        --company-ink: #1f2937;
        --company-border: rgba(15, 23, 42, 0.12);
        --company-soft: #f8fafc;
    }

    .inventory-show-wrap {
        padding: 1rem 0 1.5rem;
    }

    .inventory-header-card {
        background: #fff;
        border: 1px solid var(--company-border);
        border-radius: 12px;
        padding: 1rem 1.15rem;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
    }

    .inventory-header-card h1 {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--company-ink);
        margin: 0;
    }

    .inventory-header-card .asset-tag {
        display: inline-block;
        margin-top: 0.35rem;
        color: var(--company-violet-dark);
        background: #f5f3ff;
        border: 1px solid rgba(79, 70, 229, 0.12);
        border-radius: 999px;
        padding: 0.25rem 0.7rem;
        font-size: 0.74rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .inventory-action-group {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 0.6rem;
    }

    .inventory-action-group .btn {
        border-radius: 8px;
        padding: 0.6rem 0.9rem;
        font-weight: 600;
    }

    .inventory-hero-card,
    .inventory-edit-card,
    .inventory-history-card {
        background: #fff;
        border: 1px solid var(--company-border);
        border-radius: 12px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
    }

    .inventory-hero-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 0.95rem 1.2rem;
        border-bottom: 1px solid var(--company-border);
        background: #f8fafc;
    }

    .inventory-hero-title {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--company-ink);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.35rem 0.7rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 700;
        background: #ecfdf5;
        color: #166534;
        border: 1px solid rgba(22, 101, 52, 0.14);
    }

    .inventory-detail-body,
    .inventory-edit-card .card-body,
    .inventory-history-card .card-body {
        padding: 1rem 1.15rem;
    }

    .invoice-detail-box {
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 10px;
        background: #fff;
        overflow: hidden;
    }

    .invoice-detail-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(180px, 1fr));
        gap: 0;
    }

    .invoice-cell {
        border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        border-right: 1px solid rgba(15, 23, 42, 0.08);
        min-height: 74px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .invoice-cell:nth-child(4n) {
        border-right: none;
    }

    .invoice-cell-label {
        background: #f8fafc;
        color: #374151;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        padding: 0.7rem 0.85rem 0.45rem;
    }

    .invoice-cell-value {
        color: var(--company-ink);
        font-weight: 500;
        padding: 0 0.85rem 0.75rem;
    }

    .invoice-cell-value.muted {
        color: var(--company-muted);
    }

    .inventory-edit-card {
        margin-top: 1rem;
    }

    .inventory-edit-card .card-title,
    .inventory-history-card .card-title {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        color: var(--company-ink);
    }

    .inventory-edit-card .form-label {
        font-weight: 600;
        color: #374151;
    }

    .inventory-edit-card .form-control,
    .inventory-edit-card .form-select,
    .inventory-edit-card textarea {
        border-radius: 8px;
        border: 1px solid rgba(15, 23, 42, 0.15);
        min-height: 40px;
        background: #fff;
    }

    .table thead th {
        background: #f8fafc;
        color: #374151;
        font-size: 0.72rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(15, 23, 42, 0.1);
    }

    .table td {
        padding: 0.8rem 0.75rem;
        color: var(--company-ink);
    }

    @media (max-width: 767.98px) {
        .inventory-header-card {
            padding: 0.9rem 1rem;
        }

        .inventory-action-group {
            justify-content: flex-start;
            margin-top: 0.75rem;
        }

        .detail-list {
            grid-template-columns: 1fr;
            row-gap: 0.3rem;
        }
    }
</style>

<body>
    @include('layouts.header')
    @include('layouts.sidebar')

    <main id="main" class="main inventory-show-wrap">
        <section class="section">
            <div class="inventory-header-card d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                <div>
                    <h1>Inventory Item</h1>
                    <span class="asset-tag">{{ $inventoryItem->asset_tag }}</span>
                </div>
                <div class="inventory-action-group">
                    <button type="button" class="btn btn-outline-primary" id="toggleInventoryEdit">
                        <i class="bi bi-pencil-square me-1"></i> Edit Item
                    </button>
                    <a href="{{ route('inventory.gatepass.item', $inventoryItem) }}" target="_blank" class="btn btn-primary">
                        <i class="bi bi-printer me-1"></i> Generate Gatepass
                    </a>
                    <a href="{{ route('inventory.list') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>

            <div class="inventory-hero-card">
                <div class="inventory-hero-header">
                    <h5 class="inventory-hero-title">{{ $inventoryItem->item_name }}</h5>
                    <span class="status-badge">{{ $inventoryItem->status ?: 'Available' }}</span>
                </div>
                <div class="inventory-detail-body">
                    <div class="invoice-detail-box">
                        <div class="invoice-detail-grid">
                            @foreach ([
                                'Asset Tag' => 'asset_tag',
                                'Category' => 'category',
                                'Brand' => 'brand',
                                'Model' => 'model',
                                'Serial Number' => 'serial_number',
                                'Assigned To' => 'assigned_to',
                                'Department' => 'department',
                                'Campaign' => 'campaign',
                                'Location' => 'location',
                                'Status' => 'status',
                                'Purchase Date' => 'purchase_date',
                                'Warranty Expiry' => 'warranty_expiry',
                            ] as $label => $field)
                                <div class="invoice-cell">
                                    <div class="invoice-cell-label">{{ $label }}</div>
                                    <div class="invoice-cell-value {{ $inventoryItem->{$field} ? '' : 'muted' }}">
                                        {{ $inventoryItem->{$field} ?: 'N/A' }}
                                    </div>
                                </div>
                            @endforeach
                            <div class="invoice-cell">
                                <div class="invoice-cell-label">Remarks</div>
                                <div class="invoice-cell-value {{ $inventoryItem->remarks ? '' : 'muted' }}">
                                    {{ $inventoryItem->remarks ?: 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="inventory-edit-card" id="inventory-edit-panel" style="display: none;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Edit Inventory Item</h5>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="cancelInventoryEdit">Cancel</button>
                    </div>

                    <form action="{{ route('inventory.update', $inventoryItem) }}" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-md-6">
                            <label for="asset_tag" class="form-label">Asset Tag</label>
                            <input type="text" class="form-control" id="asset_tag" name="asset_tag" value="{{ old('asset_tag', $inventoryItem->asset_tag) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="item_name" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="item_name" name="item_name" value="{{ old('item_name', $inventoryItem->item_name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Select category</option>
                                @foreach ($options['category'] ?? [] as $option)
                                    <option value="{{ $option->option_value }}" @selected(old('category', $inventoryItem->category) === $option->option_value)>{{ $option->option_value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="brand" class="form-label">Brand</label>
                            <select class="form-select" id="brand" name="brand">
                                <option value="">Select brand</option>
                                @foreach ($options['brand'] ?? [] as $option)
                                    <option value="{{ $option->option_value }}" @selected(old('brand', $inventoryItem->brand) === $option->option_value)>{{ $option->option_value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="model" class="form-label">Model</label>
                            <input type="text" class="form-control" id="model" name="model" value="{{ old('model', $inventoryItem->model) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{ old('serial_number', $inventoryItem->serial_number) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="assigned_to" class="form-label">Assigned To</label>
                            <input type="text" class="form-control" id="assigned_to" name="assigned_to" value="{{ old('assigned_to', $inventoryItem->assigned_to) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="department" class="form-label">Department</label>
                            <select class="form-select" id="department" name="department">
                                <option value="">Select department</option>
                                @foreach ($options['department'] ?? [] as $option)
                                    <option value="{{ $option->option_value }}" @selected(old('department', $inventoryItem->department) === $option->option_value)>{{ $option->option_value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="campaign" class="form-label">Campaign</label>
                            <select class="form-select" id="campaign" name="campaign">
                                <option value="">Select campaign</option>
                                @foreach ($options['campaign'] ?? [] as $option)
                                    <option value="{{ $option->option_value }}" @selected(old('campaign', $inventoryItem->campaign) === $option->option_value)>{{ $option->option_value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="location" class="form-label">Location</label>
                            <select class="form-select" id="location" name="location">
                                <option value="">Select location</option>
                                @foreach ($options['location'] ?? [] as $option)
                                    <option value="{{ $option->option_value }}" @selected(old('location', $inventoryItem->location) === $option->option_value)>{{ $option->option_value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Select status</option>
                                @foreach (($options['status'] ?? collect())->isNotEmpty() ? $options['status'] : collect(['Available', 'Assigned', 'Under Maintenance', 'Defective']) as $status)
                                    @php($statusValue = is_string($status) ? $status : $status->option_value)
                                    <option value="{{ $statusValue }}" @selected(old('status', $inventoryItem->status) === $statusValue)>{{ $statusValue }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="purchase_date" class="form-label">Purchase Date</label>
                            <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ old('purchase_date', optional($inventoryItem->purchase_date)->format('Y-m-d') ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label for="warranty_expiry" class="form-label">Warranty Expiry</label>
                            <input type="date" class="form-control" id="warranty_expiry" name="warranty_expiry" value="{{ old('warranty_expiry', optional($inventoryItem->warranty_expiry)->format('Y-m-d') ?? '') }}">
                        </div>

                        <div class="col-12">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3">{{ old('remarks', $inventoryItem->remarks) }}</textarea>
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary" id="cancelInventorySave">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="inventory-history-card">
                <div class="card-body">
                    <h5 class="card-title">Campaign History</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Campaign</th>
                                    <th>Department</th>
                                    <th>Assigned To</th>
                                    <th>Started</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($inventoryItem->campaignHistory as $campaign)
                                    <tr>
                                        <td>{{ $campaign->campaign }}</td>
                                        <td>{{ $campaign->department ?: 'N/A' }}</td>
                                        <td>{{ $campaign->assigned_to ?: 'N/A' }}</td>
                                        <td>{{ optional($campaign->created_at)->format('M d, Y h:i A') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No campaign history found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layouts.footer')

    <script>
        const editPanel = document.getElementById('inventory-edit-panel');
        const toggleEditBtn = document.getElementById('toggleInventoryEdit');
        const cancelEditBtn = document.getElementById('cancelInventoryEdit');
        const cancelInventorySave = document.getElementById('cancelInventorySave');

        function toggleInventoryEdit(show) {
            if (!editPanel) {
                return;
            }

            editPanel.style.display = show ? 'block' : 'none';
            if (show) {
                editPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        toggleEditBtn?.addEventListener('click', function () {
            toggleInventoryEdit(true);
        });

        cancelEditBtn?.addEventListener('click', function () {
            toggleInventoryEdit(false);
        });

        cancelInventorySave?.addEventListener('click', function () {
            toggleInventoryEdit(false);
        });
    </script>
</body>

</html>