{{-- filepath: c:\xampp\htdocs\ASI-INVENTORY\resources\views\gatepass\index.blade.php --}}

@section('title', 'Gatepass List')
@include('layouts.title')

<style>
    .gatepass-page { padding: 1.25rem; }
    .gatepass-card { overflow: hidden; border: 0; border-radius: 14px; }
    .gatepass-header { padding: 1.5rem; color: #fff; background: linear-gradient(135deg, #123b78, #1769aa); }
    .gatepass-header h1 { margin: 0; font-size: 1.35rem; }
    .gatepass-header p { margin: .35rem 0 0; opacity: .85; }
    .gatepass-table-wrapper { overflow-x: auto; }
    .gatepass-table { min-width: 1100px; margin: 0; }
    .gatepass-table th { padding: .85rem; color: #334155; background: #f1f5f9; font-size: .78rem; text-transform: uppercase; white-space: nowrap; }
    .gatepass-table td { padding: .8rem; vertical-align: middle; }
    .gatepass-table tbody tr.main-row { border-bottom: 1px solid #e5e7eb; }
    .gatepass-table tbody tr.main-row:hover { background: #f8fbff; }
    .gatepass-id { display: inline-block; padding: .3rem .55rem; color: #1d4ed8; background: #eff6ff; border-radius: 6px; font-weight: 600; }
    .action-cell { min-width: 105px; white-space: nowrap; }
    .status-badge { display: inline-block; padding: .3rem .55rem; border-radius: 999px; font-size: .75rem; font-weight: 700; }
    .status-ongoing { color: #92400e; background: #fef3c7; }
    .status-completed { color: #166534; background: #dcfce7; }
    .status-cancelled { color: #991b1b; background: #fee2e2; }
    .details-row td { padding: 0 !important; background: #f8fafc; }
    .details-box { padding: 1.1rem; border-left: 4px solid #1769aa; }
    .detail-item { height: 100%; padding: .7rem; background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; }
    .detail-label { display: block; margin-bottom: .2rem; color: #64748b; font-size: .72rem; font-weight: 700; text-transform: uppercase; }
    @media (max-width: 768px) { .gatepass-page { padding: .75rem; } .gatepass-header { padding: 1.1rem; } }
    @media print { .sidebar, .header, .gatepass-header a, .action-cell, .alert, .pagination, .list-actions { display: none !important; } .main { margin: 0 !important; padding: 0 !important; } .gatepass-page { padding: 0; } .gatepass-card { box-shadow: none !important; } }
</style>

<body>
    @include('layouts.header')
    @include('layouts.sidebar')

    <main id="main" class="main">
        <div class="container-fluid gatepass-page">
            <div class="card gatepass-card shadow-sm">
                <div class="gatepass-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h1><i class="bi bi-file-earmark-text me-2"></i>Gatepass List</h1>
                        <p>View saved gatepass records and their details.</p>
                    </div>
                    <a href="{{ route('inventory.gatepass.create') }}" class="btn btn-light text-primary">
                        <i class="bi bi-plus-lg me-1"></i>Create Gatepass
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="list-actions d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="mb-1">Saved Gatepasses</h5>
                            <small class="text-muted">{{ $gatepasses->total() }} record(s)</small>
                        </div>
                        
                    </div>

                    <div class="gatepass-table-wrapper">
                        <table class="table gatepass-table align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 100px; min-width:100px; max-width:100px;">Item</th>
                                    <th style="width: 100px; min-width:100px; max-width:100px;">Owner</th>
                                    <th style="width: 100px; min-width:100px; max-width:100px;">Bearer</th>
                                    <th style="width: 150px; min-width:150px; max-width:150px;">Time & Date</th>
                                    <th style="width: 150px; min-width:150px; max-width:150px;"> Site/Floor </th>
                                    <th style="width: 100px; min-width:100px; max-width:100px;">Status</th>
                                    <th style="width: 100px; min-width:100px; max-width:100px;" class="action-cell">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($gatepasses as $gatepass)
                                    @php $detailsId = 'gatepass-details-' . $gatepass->id; @endphp
                                    <tr class="main-row">
                                        <td style="
    width:100px;
    min-width:100px;
    max-width:100px;
    white-space:normal;
    word-wrap:break-word;
    overflow-wrap:break-word;
">{{ $gatepass->inventoryItem?->item_name ?? 'N/A' }}</td>
                                        <td style="
    width:100px;
    min-width:100px;
    max-width:100px;
    white-space:normal;
    word-wrap:break-word;
    overflow-wrap:break-word;
">{{ $gatepass->owner ?: '—' }}</td>
                                        <td style="
    width:100px;
    min-width:100px;
    max-width:100px;
    white-space:normal;
    word-wrap:break-word;
    overflow-wrap:break-word;
">{{ $gatepass->bearer ?: '—' }}</td>
                                        <td style="
    width:100px;
    min-width:100px;
    max-width:100px;
    white-space:normal;
    word-wrap:break-word;
    overflow-wrap:break-word;
">{{ $gatepass->time ?: '—' }} - {{ $gatepass->date ? \Carbon\Carbon::parse($gatepass->date)->format('M d, Y') : '—' }}</td>
                                        <td style="
    width:150px;
    min-width:150px;
    max-width:150px;
    white-space:normal;
    word-wrap:break-word;
    overflow-wrap:break-word;
">
    {{ $gatepass->site_floor ?: '—' }}
</td>
                                        @php $status = $gatepass->status ?: 'Ongoing'; @endphp
                                        <td><span class="status-badge status-{{ strtolower($status) }}">{{ $status }}</span></td>
                                        <td class="action-cell">
                                            <a href="{{ route('inventory.gatepass.show', $gatepass->id) }}" class="btn btn-sm " title="View full details">
                                                <i class="bi bi-view-list"></i>
                                            </a>
                                            <a href="{{ route('inventory.gatepass.edit', $gatepass->id) }}" class="btn btn-sm btn-warning" title="Edit gatepass">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('inventory.gatepass.print', $gatepass->id) }}" target="_blank" class="btn btn-sm btn-secondary" title="Print this gatepass">
                                                <i class="bi bi-printer"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="details-row collapse" id="{{ $detailsId }}">
                                        <td colspan="11">
                                            <div class="details-box">
                                                <div class="row g-3">
                                                    <div class="col-md-4"><div class="detail-item"><span class="detail-label">Contact</span>{{ $gatepass->contact ?: '—' }}</div></div>
                                                    <div class="col-md-4"><div class="detail-item"><span class="detail-label">Unit</span>{{ $gatepass->unit ?: '—' }}</div></div>
                                                    <div class="col-md-4"><div class="detail-item"><span class="detail-label">Quantity</span>{{ $gatepass->quantity }}</div></div>
                                                    <div class="col-12"><div class="detail-item"><span class="detail-label">Description</span>{{ $gatepass->description ?: '—' }}</div></div>
                                                    <div class="col-12"><div class="detail-item"><span class="detail-label">Remarks</span>{{ $gatepass->remarks ?: '—' }}</div></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="10" class="text-center text-muted py-5"><i class="bi bi-inbox fs-1 d-block mb-2"></i>No gatepasses found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $gatepasses->links() }}</div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>
</html>
