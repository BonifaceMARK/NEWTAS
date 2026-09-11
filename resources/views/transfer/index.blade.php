
@section('title', 'Fixed Asset Transfers')

@include('layouts.title')
@include('layouts.header')
@include('layouts.sidebar')

<style>
    .transfer-page {
        padding: 1.25rem;
    }

    .transfer-header {
        padding: 1.5rem;
        color: #fff;
        background: linear-gradient(135deg, #123b78, #1769aa);
        border-radius: 14px 14px 0 0;
    }

    .transfer-header h1 {
        margin: 0;
        font-size: 1.4rem;
    }

    .transfer-header p {
        margin: .35rem 0 0;
        opacity: .85;
    }

    .transfer-card {
        overflow: hidden;
        border: 0;
        border-radius: 14px;
    }

    .transfer-table-wrapper {
        overflow-x: auto;
    }

    .transfer-table {
        min-width: 1050px;
        margin: 0;
    }

    .transfer-table th {
        padding: .9rem;
        color: #334155;
        background: #f1f5f9;
        font-size: .8rem;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .transfer-table td {
        padding: .85rem .9rem;
        vertical-align: middle;
    }

    .transfer-table tbody tr.main-row {
        border-bottom: 1px solid #e5e7eb;
    }

    .transfer-table tbody tr.main-row:hover {
        background: #f8fbff;
    }

    .reference-badge {
        display: inline-block;
        padding: .35rem .6rem;
        color: #1d4ed8;
        background: #eff6ff;
        border-radius: 6px;
        font-weight: 600;
    }

    .asset-badge {
        display: inline-block;
        padding: .35rem .6rem;
        color: #166534;
        background: #ecfdf5;
        border-radius: 6px;
    }

    .status-badge { display: inline-block; padding: .3rem .55rem; border-radius: 999px; font-size: .75rem; font-weight: 700; }
    .status-ongoing { color: #92400e; background: #fef3c7; }
    .status-completed { color: #166534; background: #dcfce7; }
    .status-cancelled { color: #991b1b; background: #fee2e2; }

    .actions-cell {
        min-width: 210px;
        white-space: nowrap;
    }

    .details-row td {
        padding: 0 !important;
        background: #f8fafc;
    }

    .details-box {
        padding: 1.25rem;
        border-left: 4px solid #1769aa;
    }

    .detail-item {
        height: 100%;
        padding: .75rem;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
    }

    .detail-label {
        display: block;
        margin-bottom: .25rem;
        color: #64748b;
        font-size: .75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .remarks-box {
        min-height: 60px;
        padding: .75rem;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        white-space: pre-wrap;
    }

    @media (max-width: 768px) {
        .transfer-page {
            padding: .75rem;
        }

        .transfer-header {
            padding: 1.1rem;
        }
    }

    @media print {
        .sidebar,
        .header,
        .transfer-header a,
        .actions-cell,
        .alert,
        .pagination {
            display: none !important;
        }

        .main {
            margin: 0 !important;
            padding: 0 !important;
        }

        .transfer-page {
            padding: 0;
        }

        .transfer-card {
            box-shadow: none !important;
        }
    }
</style>

<main id="main" class="main">
    <div class="container-fluid transfer-page">
        <div class="card transfer-card shadow-sm">

            <div class="transfer-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h1>
                        <i class="bi bi-arrow-left-right me-2"></i>
                        Fixed Asset Transfers
                    </h1>
                    <p>View, edit, print, and manage fixed asset transfer records.</p>
                </div>

                <a href="{{ route('asset.transfer.create') }}"
                   class="btn btn-light text-primary">
                    <i class="bi bi-plus-lg me-1"></i>
                    Create Transfer
                </a>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                        </button>
                    </div>
                @endif

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                    <div>
                        <h5 class="mb-1">Transfer Records</h5>
                        <small class="text-muted">
                            {{ method_exists($transfers, 'total') ? $transfers->total() : $transfers->count() }}
                            record(s)
                        </small>
                    </div>

                    <button type="button"
                            class="btn btn-outline-secondary btn-sm"
                            onclick="window.print()">
                        <i class="bi bi-printer me-1"></i>
                        Print List
                    </button>
                </div>

                <div class="transfer-table-wrapper">
                    <table class="table transfer-table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Reference No.</th>
                                <th>Date</th>
                                <th>Original Campaign/Team</th>
                                <th>Transferred Campaign</th>
                                <th>Asset Type</th>
                                <th>Status</th>
                                <th class="actions-cell">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($transfers as $transfer)
                                @php
                                    $detailsId = 'transfer-details-' . $transfer->id;
                                @endphp

                                <tr class="main-row">
                                    <td>
                                        {{ method_exists($transfers, 'firstItem')
                                            ? $transfers->firstItem() + $loop->index
                                            : $loop->iteration }}
                                    </td>

                                    <td>
                                        <span class="reference-badge">
                                            {{ $transfer->reference_no ?: 'No reference' }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $transfer->date_of_transfer
                                            ? \Carbon\Carbon::parse($transfer->date_of_transfer)->format('M d, Y')
                                            : '—' }}
                                    </td>

                                    <td>{{ $transfer->from_campaign ?: '—' }}</td>
                                    <td>{{ $transfer->to_campaign ?: '—' }}</td>

                                    <td>
                                        <span class="asset-badge">
                                            {{ $transfer->asset_type ?: '—' }}
                                        </span>
                                    </td>
                                    @php $status = $transfer->status ?: 'Ongoing'; @endphp
                                    <td><span class="status-badge status-{{ strtolower($status) }}">{{ $status }}</span></td>

                                    <td class="actions-cell">
                                        <button type="button"
                                                class="btn btn-sm btn-info text-white"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#{{ $detailsId }}"
                                                aria-controls="{{ $detailsId }}">
                                            <i class="bi bi-eye me-1"></i>
                                        </button>

                                        <a href="{{ route('asset.transfer.edit', $transfer->id) }}"
                                           class="btn btn-sm btn-warning"
                                           title="Edit transfer">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <a href="{{ route('asset.transfer.print', $transfer->id) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-secondary"
                                           title="Print transfer">
                                            <i class="bi bi-printer"></i>
                                        </a>

                                        <form action="{{ route('asset.transfer.destroy', $transfer->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this fixed asset transfer?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Delete transfer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <tr class="details-row collapse" id="{{ $detailsId }}">
                                    <td colspan="8">
                                        <div class="details-box">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0 fw-bold">
                                                    <i class="bi bi-file-text me-1"></i>
                                                    Transfer Details
                                                </h6>

                                                <a href="{{ route('asset.transfer.print', $transfer->id) }}"
                                                   target="_blank"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-printer me-1"></i>
                                                    Print Details
                                                </a>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-12 col-md-4">
                                                    <div class="detail-item">
                                                        <span class="detail-label">Reference No.</span>
                                                        {{ $transfer->reference_no ?: '—' }}
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-4">
                                                    <div class="detail-item">
                                                        <span class="detail-label">Date of Transfer</span>
                                                        {{ $transfer->date_of_transfer
                                                            ? \Carbon\Carbon::parse($transfer->date_of_transfer)->format('F d, Y')
                                                            : '—' }}
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-4">
                                                    <div class="detail-item">
                                                        <span class="detail-label">Asset Type</span>
                                                        {{ $transfer->asset_type ?: '—' }}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="detail-item">
                                                        <span class="detail-label">Status</span>
                                                        {{ $transfer->status ?: 'Ongoing' }}
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="detail-item">
                                                        <span class="detail-label">Original Campaign/Team</span>
                                                        {{ $transfer->from_campaign ?: '—' }}
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="detail-item">
                                                        <span class="detail-label">Transferred Campaign</span>
                                                        {{ $transfer->to_campaign ?: '—' }}
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <span class="detail-label">Remarks</span>
                                                    <div class="remarks-box">
                                                        {{ $transfer->remarks ?: 'No remarks provided.' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        No fixed asset transfers found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if (method_exists($transfers, 'links'))
                    <div class="mt-4">
                        {{ $transfers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>

@include('layouts.footer')