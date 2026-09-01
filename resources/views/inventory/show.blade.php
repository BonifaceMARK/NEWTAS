@section('title', env('APP_NAME'))

@include('layouts.title')

<body>
    @include('layouts.header')
    @include('layouts.sidebar')

    <main id="main" class="main">
        <section class="section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1 class="h4 mb-1">Inventory Item</h1>
                    <p class="text-muted mb-0">{{ $inventoryItem->asset_tag }}</p>
                </div>
                <a href="{{ route('inventory.list') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $inventoryItem->item_name }}</h5>
                    <dl class="row mb-0">
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
                            <dt class="col-sm-4 col-lg-3">{{ $label }}</dt>
                            <dd class="col-sm-8 col-lg-9">{{ $inventoryItem->{$field} ?: 'N/A' }}</dd>
                        @endforeach
                        <dt class="col-sm-4 col-lg-3">Remarks</dt>
                        <dd class="col-sm-8 col-lg-9">{{ $inventoryItem->remarks ?: 'N/A' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card mt-4">
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
</body>

</html>