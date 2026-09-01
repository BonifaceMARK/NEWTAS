@section('title', env('APP_NAME'))

@include('layouts.title')

<style>
    .inventory-toolbar { background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; padding: 1rem; }
    #inventory-items-table thead th { background: #f8f9fa; color: #495057; font-size: 11px; letter-spacing: .04em; text-transform: uppercase; white-space: nowrap; }
    #inventory-items-table tbody tr { transition: background-color .15s ease; }
    #inventory-items-table tbody tr:hover { background-color: #f8fbff; }
    #inventory-items-table .checkbox-col,
    #inventory-items-table th.checkbox-col,
    #inventory-items-table td.checkbox-col {
        width: 42px;
        text-align: center;
        vertical-align: middle;
    }
    #inventory-items-table .inventory-row-checkbox,
    #inventory-items-table .inventory-select-toggle,
    #select-all-inventory {
        display: block;
        margin: 0 auto;
        width: 1rem;
        height: 1rem;
        vertical-align: middle;
    }
    #select-all-inventory {
        margin-top: 2px;
    }
    .inventory-status { font-size: 11px; font-weight: 600; }
</style>

<body>
    @include('layouts.header')
    @include('layouts.sidebar')

    <main id="main" class="main">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <div><h5 class="card-title mb-1">Inventory Items</h5><small class="text-muted">{{ $inventoryItems->count() }} item(s) shown</small></div>
                        <a href="{{ route('inventory.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add item</a>
                    </div>
                    <form method="GET" action="{{ route('inventory.dashboard') }}" class="inventory-toolbar row g-2 align-items-end mb-4">
                        <div class="col-12 col-lg-5">
                            <label for="inventory-search" class="form-label small fw-semibold">Search inventory</label>
                            <input id="inventory-search" name="search" type="search" value="{{ $search ?? request('search') }}" class="form-control" placeholder="Asset tag, item, serial or assignee">
                        </div>
                        <div class="col-12 col-md-5 col-lg-3">
                            <label for="department-filter" class="form-label small fw-semibold">Department</label>
                            <select id="department-filter" name="department" class="form-select"><option value="">All departments</option>@foreach ($departments ?? [] as $departmentOption)<option value="{{ $departmentOption }}" @selected(($department ?? request('department')) === $departmentOption)>{{ $departmentOption }}</option>@endforeach</select>
                        </div>
                        <div class="col-12 col-md-5 col-lg-2">
                            <label for="status-filter" class="form-label small fw-semibold">Status</label>
                            <select id="status-filter" name="status" class="form-select"><option value="">All statuses</option>@foreach ($statuses ?? [] as $statusOption)<option value="{{ $statusOption }}" @selected(($status ?? request('status')) === $statusOption)>{{ $statusOption }}</option>@endforeach</select>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2 d-flex gap-2"><button type="submit" class="btn btn-dark flex-grow-1"><i class="bi bi-search"></i><span class="ms-1">Filter</span></button>@if (request()->hasAny(['search', 'department', 'status']))<a href="{{ route('inventory.dashboard') }}" class="btn btn-outline-secondary" title="Clear filters"><i class="bi bi-x-lg"></i></a>@endif</div>
                    </form>
                    <form id="bulk-delete-form" method="POST" action="{{ route('inventory.bulk-delete') }}" onsubmit="return confirm('Delete the selected inventory items?');">
                        @csrf
                        @method('DELETE')

                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                            <input id="select-all-inventory" type="checkbox" class="form-check-input" aria-label="Select all inventory items">
                            <button type="submit" class="btn btn-sm btn-outline-danger" id="bulk-delete-button">
                                <i class="bi bi-trash3 me-1"></i>Delete selected
                                <span class="selected-count ms-1">(0)</span>
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table id="inventory-items-table" class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="checkbox-col text-center" style="width: 42px;"></th>
                                        <th>Asset</th><th>Item</th><th>Assignment</th>
                                        <th>Department</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($inventoryItems as $inventoryItem)
                                        @php $statusClass = match (strtolower((string) $inventoryItem->status)) { 'available' => 'bg-success-subtle text-success-emphasis', 'assigned' => 'bg-primary-subtle text-primary-emphasis', 'under maintenance' => 'bg-warning-subtle text-warning-emphasis', default => 'bg-secondary-subtle text-secondary-emphasis' }; @endphp
                                        <tr>
                                            <td class="checkbox-col text-center"><input type="checkbox" class="form-check-input inventory-row-checkbox" name="selected_items[]" value="{{ $inventoryItem->id }}" aria-label="Select item {{ $inventoryItem->asset_tag ?? 'inventory item' }}"></td>
                                            <td><strong>{{ $inventoryItem->asset_tag ?? 'N/A' }}</strong><br><small class="text-muted">{{ $inventoryItem->serial_number ?? 'No serial number' }}</small></td>
                                            <td>{{ $inventoryItem->item_name ?? 'N/A' }}<br><small class="text-muted">{{ $inventoryItem->brand ?? '-' }} {{ $inventoryItem->model ?? '' }}</small></td>
                                            <td>{{ $inventoryItem->assigned_to ?? 'Unassigned' }}<br><small class="text-muted">{{ $inventoryItem->campaign ?? 'No campaign' }}</small></td>
                                            <td>{{ $inventoryItem->department ?? 'N/A' }}</td>
                                            <td>{{ $inventoryItem->location ?? 'N/A' }}</td>
                                            <td><span class="badge rounded-pill inventory-status {{ $statusClass }}">{{ $inventoryItem->status ?? 'Unknown' }}</span></td>
                                            <td class="text-end"><a href="{{ route('inventory.show', $inventoryItem) }}" class="btn btn-sm btn-outline-primary" title="View inventory item"><i class="bi bi-arrow-up-right"></i><span class="visually-hidden">View details</span></a></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="8" class="text-center py-5 text-muted">No inventory items match these filters.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </main>

    @include('layouts.footer')

    <script>
        const selectAllCheckbox = document.getElementById('select-all-inventory');
        const headerToggle = document.querySelector('.inventory-select-toggle');
        const rowCheckboxes = document.querySelectorAll('.inventory-row-checkbox');
        const selectedCount = document.querySelector('.selected-count');

        function updateSelectionState() {
            const checkedBoxes = document.querySelectorAll('.inventory-row-checkbox:checked');
            const totalBoxes = rowCheckboxes.length;

            if (selectedCount) {
                selectedCount.textContent = `(${checkedBoxes.length})`;
            }

            const allChecked = totalBoxes > 0 && checkedBoxes.length === totalBoxes;
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
            }
            if (headerToggle) {
                headerToggle.checked = allChecked;
            }
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function () {
                rowCheckboxes.forEach((checkbox) => {
                    checkbox.checked = this.checked;
                });
                updateSelectionState();
            });
        }

        if (headerToggle) {
            headerToggle.addEventListener('change', function () {
                rowCheckboxes.forEach((checkbox) => {
                    checkbox.checked = this.checked;
                });
                updateSelectionState();
            });
        }

        rowCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', updateSelectionState);
        });

        updateSelectionState();
    </script>
</body>

</html>