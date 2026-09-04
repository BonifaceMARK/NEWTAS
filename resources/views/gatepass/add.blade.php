@section('title', 'Create Gatepass')

@include('layouts.title')

<style>
    :root {
        --company-violet: #4f46e5;
        --company-violet-dark: #312e81;
        --company-violet-soft: rgba(79, 70, 229, 0.12);
        --company-yellow: #facc15;
        --company-yellow-deep: #eab308;
        --company-yellow-soft: rgba(250, 204, 21, 0.18);
        --company-ink: #1f2937;
    }

    .gatepass-form-card {
        border: 1px solid rgba(79, 70, 229, 0.18);
        border-radius: 18px;
        background: linear-gradient(180deg, #ffffff 0%, #fffdf5 100%);
        box-shadow: 0 18px 36px rgba(49, 46, 129, 0.08);
        overflow: hidden;
    }

    .gatepass-form-card .card-body {
        padding: 1.5rem;
    }

    .gatepass-hero {
        background: linear-gradient(135deg, var(--company-violet-soft), var(--company-yellow-soft));
        border: 1px solid rgba(79, 70, 229, 0.15);
        border-radius: 14px;
        padding: 1rem 1.1rem;
        margin-bottom: 1.2rem;
    }

    .gatepass-hero h1 {
        margin: 0;
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .gatepass-hero p {
        margin: 0.125rem 0 0;
        color: #64748b;
    }

    .summary-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(250, 204, 21, 0.18));
        color: var(--company-violet-dark);
        border: 1px solid rgba(79, 70, 229, 0.18);
        border-radius: 999px;
        padding: 0.45rem 0.75rem;
        font-size: 0.8rem;
        font-weight: 700;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .summary-pill strong {
        font-size: 0.9rem;
    }

    .interactive-note {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        margin-bottom: 0.8rem;
        padding: 0.45rem 0.7rem;
        border-radius: 999px;
        background: rgba(79, 70, 229, 0.08);
        border: 1px solid rgba(79, 70, 229, 0.14);
        color: var(--company-violet-dark);
        font-size: 0.75rem;
        font-weight: 700;
    }

    .transfer-highlight {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(250, 204, 21, 0.15));
        border: 1px solid rgba(79, 70, 229, 0.18);
        border-radius: 16px;
        padding: 1rem 1.1rem;
        margin-bottom: 1rem;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.5);
    }

    .transfer-highlight .form-label {
        color: var(--company-violet-dark);
        font-weight: 800;
    }

    .transfer-highlight .form-control {
        border: 1px solid rgba(79, 70, 229, 0.28);
        background: rgba(255,255,255,0.76);
    }

    .drag-drop-shell {
        margin-top: 0.5rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .asset-pool,
    .transfer-box {
        min-height: 220px;
        border: 1px dashed rgba(79, 70, 229, 0.35);
        border-radius: 16px;
        background: linear-gradient(180deg, rgba(255,255,255,0.9), rgba(248, 250, 252, 0.9));
        padding: 0.85rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .transfer-box {
        border-style: solid;
        background: linear-gradient(180deg, rgba(79, 70, 229, 0.04), rgba(250, 204, 21, 0.08));
    }

    .transfer-box.is-active,
    .asset-pool.is-active {
        border-color: rgba(79, 70, 229, 0.7);
        box-shadow: 0 10px 30px rgba(79, 70, 229, 0.08);
    }

    .dnd-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }

    .dnd-panel-header h6 {
        margin: 0;
        font-weight: 800;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: var(--company-violet-dark);
    }

    .asset-drag-card {
        border: 1px solid rgba(79, 70, 229, 0.18);
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(255,255,255,1), rgba(244, 237, 255, 0.8));
        padding: 0.75rem 0.8rem;
        margin-bottom: 0.7rem;
        cursor: grab;
        box-shadow: 0 6px 18px rgba(49, 46, 129, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .asset-drag-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 24px rgba(49, 46, 129, 0.08);
        border-color: rgba(79, 70, 229, 0.4);
    }

    .asset-drag-card.is-blocked {
        opacity: 0.55;
        border-style: dashed;
        border-color: rgba(148, 163, 184, 0.8);
        background: linear-gradient(135deg, rgba(255,255,255,1), rgba(226, 232, 240, 0.8));
    }

    .asset-drag-card.dragging {
        opacity: 0.55;
    }

    .asset-drag-card.is-transferred {
        opacity: 0;
        pointer-events: none;
        transform: scale(0.95);
        transition: opacity 0.25s ease, transform 0.25s ease;
        max-height: 0;
        margin-bottom: 0;
        overflow: hidden;
    }

    .asset-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.74rem;
        color: var(--company-violet-dark);
        font-weight: 700;
    }

    .asset-card-name {
        margin-top: 0.35rem;
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--company-ink);
    }

    .asset-card-meta {
        margin-top: 0.2rem;
        font-size: 0.75rem;
        color: #64748b;
    }

    .qty-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.2rem 0.45rem;
        border-radius: 999px;
        background: rgba(250, 204, 21, 0.2);
        color: #7c5b00;
        font-size: 0.68rem;
        font-weight: 800;
    }

    .blocked-location-badge {
        display: inline-flex;
        align-items: center;
        margin-top: 0.45rem;
        padding: 0.22rem 0.5rem;
        border-radius: 999px;
        background: rgba(148, 163, 184, 0.14);
        border: 1px solid rgba(148, 163, 184, 0.4);
        color: #475569;
        font-size: 0.68rem;
        font-weight: 700;
    }

    .transfer-item {
        border: 1px solid rgba(79, 70, 229, 0.2);
        border-radius: 12px;
        background: rgba(255,255,255,0.9);
        padding: 0.75rem;
        margin-bottom: 0.7rem;
        animation: fadeInUp 0.2s ease;
    }

    .transfer-item-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .transfer-item-head strong {
        font-size: 0.9rem;
    }

    .transfer-item-meta {
        font-size: 0.75rem;
        color: #64748b;
        margin-bottom: 0.55rem;
    }

    .asset-search-input {
        width: 100%;
        padding: 0.6rem 0.8rem;
        border: 1px solid rgba(79, 70, 229, 0.25);
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.8);
        font-size: 0.85rem;
        color: var(--company-ink);
        margin-bottom: 0.85rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .asset-search-input:focus {
        outline: none;
        border-color: rgba(79, 70, 229, 0.6);
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.12);
    }

    .asset-search-input::placeholder {
        color: #a0aec0;
    }

    .no-results-state {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        min-height: 120px;
        color: #64748b;
        font-weight: 600;
        padding: 1rem;
    }

    .asset-filter-controls {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .filter-btn {
        padding: 0.35rem 0.65rem;
        border: 1px solid rgba(79, 70, 229, 0.3);
        background: rgba(255, 255, 255, 0.7);
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--company-violet-dark);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .filter-btn:hover {
        background: rgba(79, 70, 229, 0.08);
        border-color: rgba(79, 70, 229, 0.6);
    }

    .filter-btn.active {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.2), rgba(250, 204, 21, 0.15));
        border-color: rgba(79, 70, 229, 0.6);
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.12);
    }

    .clear-filters-btn {
        padding: 0.35rem 0.65rem;
        border: 1px solid rgba(220, 38, 38, 0.4);
        background: rgba(254, 242, 242, 0.8);
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        color: #991b1b;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-left: auto;
    }

    .clear-filters-btn:hover {
        background: rgba(220, 38, 38, 0.08);
        border-color: rgba(220, 38, 38, 0.7);
    }

    .clear-filters-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .asset-drag-card.hidden-by-default {
        display: none;
    }

    .transfer-item-field {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .transfer-item-field label {
        font-size: 0.76rem;
        color: var(--company-violet-dark);
        font-weight: 700;
    }

    .transfer-item-field input {
        width: 90px;
    }

    .empty-drop-state {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 160px;
        text-align: center;
        color: #64748b;
        border: 1px dashed rgba(79, 70, 229, 0.2);
        border-radius: 12px;
        background: rgba(255,255,255,0.45);
        font-weight: 600;
        padding: 1rem;
    }

    .form-control,
    .form-select,
    .btn {
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: rgba(79, 70, 229, 0.7);
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.12);
    }

    .btn {
        border-radius: 10px;
        font-weight: 700;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--company-violet) 0%, var(--company-violet-dark) 100%);
        border-color: var(--company-violet);
        box-shadow: 0 8px 18px rgba(79, 70, 229, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--company-violet-dark) 0%, var(--company-violet) 100%);
        border-color: var(--company-violet-dark);
    }

    .btn-outline-primary {
        color: var(--company-violet-dark);
        border-color: rgba(79, 70, 229, 0.45);
        background: rgba(255, 255, 255, 0.75);
    }

    .btn-outline-primary:hover {
        background: rgba(79, 70, 229, 0.06);
        border-color: var(--company-violet);
        color: var(--company-violet-dark);
    }

    .btn-outline-dark {
        border-color: rgba(79, 70, 229, 0.3);
        color: var(--company-violet-dark);
    }

    .btn-outline-dark:hover {
        background: rgba(250, 204, 21, 0.12);
        border-color: rgba(234, 179, 8, 0.7);
        color: var(--company-violet-dark);
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .form-label {
        margin-bottom: 0.45rem;
    }

    .asset-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        animation: fadeIn 0.2s ease;
    }

    .asset-modal-overlay.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .asset-modal-content {
        background: white;
        border-radius: 18px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        max-width: 500px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
        animation: slideUp 0.3s ease;
    }

    .asset-modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(79, 70, 229, 0.15);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .asset-modal-header h5 {
        margin: 0;
        font-weight: 800;
        color: var(--company-ink);
    }

    .asset-modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #64748b;
        transition: color 0.2s ease;
    }

    .asset-modal-close:hover {
        color: var(--company-violet-dark);
    }

    .asset-modal-body {
        padding: 1.5rem;
    }

    .asset-modal-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(79, 70, 229, 0.08);
    }

    .asset-modal-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .asset-modal-label {
        font-weight: 800;
        color: var(--company-violet-dark);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .asset-modal-value {
        color: var(--company-ink);
        font-size: 0.95rem;
        text-align: right;
        max-width: 60%;
        word-break: break-word;
    }

    .asset-modal-qty-selector {
        padding: 1rem;
        background: rgba(79, 70, 229, 0.06);
        border-radius: 12px;
        margin-top: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .asset-modal-qty-selector label {
        font-weight: 800;
        color: var(--company-violet-dark);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        white-space: nowrap;
    }

    .asset-modal-qty-selector input {
        flex: 1;
        padding: 0.5rem 0.75rem;
        border: 1px solid rgba(79, 70, 229, 0.3);
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--company-ink);
    }

    .asset-modal-qty-selector input:focus {
        outline: none;
        border-color: rgba(79, 70, 229, 0.7);
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.12);
    }

    .asset-modal-qty-selector input.is-invalid {
        border-color: #991b1b;
        background: rgba(220, 38, 38, 0.05);
    }

    #modal-qty-error {
        color: #991b1b;
        font-size: 0.75rem;
        font-weight: 700;
        display: none;
        margin-top: 0.25rem;
    }

    .asset-modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid rgba(79, 70, 229, 0.15);
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
    }

    .asset-modal-footer .btn {
        font-size: 0.85rem;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<body>
    <!-- Asset Detail Modal -->
    <div class="asset-modal-overlay" id="asset-modal-overlay">
        <div class="asset-modal-content">
            <div class="asset-modal-header">
                <h5 id="modal-asset-tag">Asset Details</h5>
                <button type="button" class="asset-modal-close" id="modal-close-btn">&times;</button>
            </div>
            <div class="asset-modal-body" id="modal-body">
                <!-- Content populated by JavaScript -->
            </div>
            <div class="asset-modal-footer">
                <button type="button" class="btn btn-secondary" id="modal-close-btn-footer">Close</button>
                <button type="button" class="btn btn-primary" id="modal-add-btn">Add to Transfer</button>
            </div>
        </div>
    </div>

    @include('layouts.header')
    @include('layouts.sidebar')

    <main id="main" class="main">
        <section class="section">
            <div class="card gatepass-form-card">
                <div class="card-body">
                    <div class="gatepass-hero d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                        <div>
                            <h1 class="h4 mb-1">Create Gatepass</h1>
                            <p class="mb-0">Create a single gatepass for one or multiple assets.</p>
                        </div>
                        <div class="summary-pill">
                            <i class="bi bi-box-seam"></i>
                            <span><strong id="asset-count-display">0</strong> asset(s)</span>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('inventory.gatepass') }}" class="row g-3">
                        <div class="col-12 transfer-highlight">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-6">
                                    <label for="from_site_floor" class="form-label fw-semibold">From Site / Floor</label>
                                    <select id="from_site_floor" name="from_site_floor" class="form-select" required>
                                        <option value="">Select source site</option>
                                        @foreach ($locationOptions ?? [] as $option)
                                            <option value="{{ $option->option_value }}">{{ $option->option_value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="to_site_floor" class="form-label fw-semibold">To Site / Floor</label>
                                    <select id="to_site_floor" name="to_site_floor" class="form-select" required>
                                        <option value="">Select destination site</option>
                                        @foreach ($locationOptions ?? [] as $option)
                                            <option value="{{ $option->option_value }}">{{ $option->option_value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="owner" class="form-label fw-semibold">Owner</label>
                            <input id="owner" name="owner" type="text" class="form-control" placeholder="Owner / department head">
                        </div>

                        <div class="col-md-6">
                            <label for="bearer" class="form-label fw-semibold">Bearer</label>
                            <input id="bearer" name="bearer" type="text" class="form-control" placeholder="Mr./Ms.">
                        </div>

                        <div class="col-md-6">
                            <label for="contact" class="form-label fw-semibold">Contact</label>
                            <input id="contact" name="contact" type="text" class="form-control" placeholder="Contact number or person">
                        </div>

                        <div class="col-md-4">
                            <label for="date" class="form-label fw-semibold">Date</label>
                            <input id="date" name="date" type="date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="col-md-4">
                            <label for="time" class="form-label fw-semibold">Time</label>
                            <input id="time" name="time" type="time" class="form-control" value="{{ date('H:i') }}">
                        </div>

                        <div class="col-md-4">
                            <label for="quantity_total" class="form-label fw-semibold">Reference Qty</label>
                            <input id="quantity_total" type="number" min="1" value="1" class="form-control" readonly>
                        </div>

                        <div class="col-12">
                            <label for="remarks" class="form-label fw-semibold">Gatepass note</label>
                            <textarea id="remarks" name="remarks" rows="4" class="form-control" placeholder="General remarks for the gatepass..."></textarea>
                        </div>

                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Transfer assets</h5>
                            </div>

                            <div class="drag-drop-shell">
                                <div class="asset-pool" id="inventory-pool" aria-label="All assets list">
                                    <div class="dnd-panel-header">
                                        <h6>All Assets</h6>
                                    </div>
                                    <input
                                        type="text"
                                        id="asset-search"
                                        class="asset-search-input"
                                        placeholder="Search by tag, name, brand, or model..."
                                        aria-label="Search assets"
                                    />
                                    <div class="asset-filter-controls" id="filter-controls"></div>
                                    <div class="interactive-note">
                                        <i class="bi bi-lightning-charge"></i>
                                        Use search or filters to find and add assets to the transfer list.
                                    </div>
                                    @foreach ($inventoryItems as $item)
                                        @php
                                            $availableQty = (int) ($item->quantity ?? 1);
                                            $availableQty = max(1, $availableQty);
                                            $description = trim(($item->item_name ?? 'Inventory Item') . ' ' . ($item->brand ?? '') . ' ' . ($item->model ?? ''));
                                        @endphp
                                        <div
                                            class="asset-drag-card hidden-by-default"
                                            draggable="true"
                                            data-item-id="{{ $item->id }}"
                                            data-item-name="{{ $item->item_name }}"
                                            data-unit="{{ $item->category ?? 'Unit' }}"
                                            data-category="{{ $item->category ?? '' }}"
                                            data-available-qty="{{ $availableQty }}"
                                            data-original-qty="{{ $availableQty }}"
                                            data-description="{{ $description }}"
                                            data-asset-tag="{{ $item->asset_tag ?? 'ASSET' }}"
                                            data-brand="{{ $item->brand ?? 'N/A' }}"
                                            data-model="{{ $item->model ?? 'N/A' }}"
                                            data-current-location="{{ $item->location ?? 'Unknown' }}">
                                            <div class="asset-card-top">
                                                <span>{{ $item->asset_tag ?? 'ASSET' }}</span>
                                                <span class="qty-badge">Qty: {{ $availableQty }}</span>
                                            </div>
                                            <div class="asset-card-name">{{ $item->item_name }}</div>
                                            <div class="asset-card-meta">
                                                {{ trim(($item->brand ?? '') . ' ' . ($item->model ?? '')) ?: 'No details provided' }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="transfer-box" id="transfer-box" aria-label="Transfer assets box">
                                    <div class="dnd-panel-header">
                                        <h6>Transfer List</h6>
                                    </div>
                                    <div class="empty-drop-state">Drag an asset here to transfer it.</div>
                                </div>
                            </div>
                        </div>

                



                        <div class="col-12 d-flex justify-content-end gap-2">
                               <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmSaveModal">
        <i class="bi bi-save me-1"></i>Save Changes
    </button>
                           <button type="submit" class="btn btn-primary" formtarget="_blank">
    <i class="bi bi-printer me-1"></i>Generate Gatepass
</button>

<button type="submit" formaction="{{ route('inventory.gatepass.list') }}" 
        class="btn btn-outline-dark" formtarget="_blank">
    <i class="bi bi-list-ul me-1"></i>Print List Only
</button>

                        </div>
                    </form>
                </div>
            </div>
        </section>
            <!-- Save Confirmation Modal -->
<div class="modal fade" id="confirmSaveModal" tabindex="-1" aria-labelledby="confirmSaveLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="confirmSaveLabel">Confirm Save</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        Are you sure you want to save these changes?
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        
        <!-- Actual save button submits the form -->
        <button type="submit" class="btn btn-success" form="gatepassForm">
          Yes, Save Changes
        </button>
      </div>

    </div>
  </div>
</div>
    </main>

    @include('layouts.footer')

    <script>
        const inventoryPool = document.getElementById('inventory-pool');
        const transferBox = document.getElementById('transfer-box');
        const totalQtyField = document.getElementById('quantity_total');
        const assetCountDisplay = document.getElementById('asset-count-display');

        function clampQty(value, maxQty) {
            const safeMax = Number(maxQty) > 0 ? Number(maxQty) : 1;
            const parsed = Number(value) || 1;
            return Math.min(Math.max(parsed, 1), safeMax);
        }

        function updateTransferSummary() {
            const transferItems = transferBox.querySelectorAll('.transfer-item');
            let totalQty = 0;

            transferItems.forEach((item) => {
                const qtyInput = item.querySelector('.transfer-qty');
                if (qtyInput) {
                    totalQty += Number(qtyInput.value || 0);
                }
            });

            if (assetCountDisplay) {
                assetCountDisplay.textContent = transferItems.length;
            }

            if (totalQtyField) {
                totalQtyField.value = totalQty;
            }

            if (transferItems.length === 0) {
                if (!transferBox.querySelector('.empty-drop-state')) {
                    const emptyState = document.createElement('div');
                    emptyState.className = 'empty-drop-state';
                    emptyState.textContent = 'Drag an asset here to transfer it.';
                    transferBox.appendChild(emptyState);
                }
            } else {
                const emptyState = transferBox.querySelector('.empty-drop-state');
                if (emptyState) {
                    emptyState.remove();
                }
            }

            updateAllAssetTransferStates();
        }

        function updateAssetTransferState(itemId) {
            const sourceCard = inventoryPool.querySelector(`.asset-drag-card[data-item-id="${itemId}"]`);
            if (!sourceCard) return;

            const availableQty = Number(sourceCard.dataset.availableQty || 1);
            const originalQty = Number(sourceCard.dataset.originalQty || availableQty);
            const transferRows = Array.from(transferBox.querySelectorAll(`.transfer-item[data-item-id="${itemId}"]`));
            
            let transferredQty = 0;
            transferRows.forEach((row) => {
                const qtyInput = row.querySelector('.transfer-qty');
                if (qtyInput) {
                    transferredQty += Number(qtyInput.value || 0);
                }
            });

            const remainingQty = Math.max(0, originalQty - transferredQty);
            
            if (transferredQty >= originalQty) {
                sourceCard.classList.add('is-transferred');
            } else {
                sourceCard.classList.remove('is-transferred');
            }

            const qtyBadge = sourceCard.querySelector('.qty-badge');
            if (qtyBadge) {
                qtyBadge.textContent = `Qty: ${remainingQty}`;
            }
        }

        function updateAllAssetTransferStates() {
            inventoryPool.querySelectorAll('.asset-drag-card').forEach((card) => {
                const itemId = card.dataset.itemId;
                updateAssetTransferState(itemId);
            });
        }

        function reindexTransferItems() {
            const rows = transferBox.querySelectorAll('.transfer-item');
            rows.forEach((row, index) => {
                row.querySelectorAll('input').forEach((input) => {
                    if (input.name) {
                        input.name = input.name.replace(/items\[\d+\]/, `items[${index}]`);
                    }
                });
                row.dataset.index = index;
            });
        }

        function removeTransferItem(button) {
            const row = button.closest('.transfer-item');
            if (row) {
                const itemId = row.dataset.itemId;
                row.remove();
                reindexTransferItems();
                updateTransferSummary();
                updateAssetTransferState(itemId);
            }
        }

        function showTransferWarning(message) {
            if (window.alert) {
                window.alert(message);
            }
        }

        function handleQuickAdd(card, customQty = null) {
            const destination = document.getElementById('to_site_floor')?.value || '';
            const currentLocation = (card.dataset.currentLocation || '').trim();

            if (destination !== '' && currentLocation !== '' && currentLocation.toLowerCase() === destination.toLowerCase()) {
                showTransferWarning('This asset is already at the selected destination site and cannot be transferred there.');
                return;
            }

            addTransferItem({
                id: card.dataset.itemId,
                name: card.dataset.itemName,
                unit: card.dataset.unit,
                description: card.dataset.description,
                availableQty: card.dataset.availableQty,
                customQty: customQty,
                currentLocation: card.dataset.currentLocation || '',
                fromSite: document.getElementById('from_site_floor')?.value || 'current site',
                toSite: document.getElementById('to_site_floor')?.value || 'new site'
            });
        }

        function syncBlockedAssets() {
            const destination = document.getElementById('to_site_floor')?.value || '';
            inventoryPool.querySelectorAll('.asset-drag-card').forEach((card) => {
                const currentLocation = (card.dataset.currentLocation || '').trim();
                const isBlocked = destination !== '' && currentLocation !== '' && currentLocation.toLowerCase() === destination.toLowerCase();
                card.classList.toggle('is-blocked', isBlocked);
                card.setAttribute('aria-disabled', isBlocked ? 'true' : 'false');
                card.draggable = !isBlocked;

                const cardName = card.querySelector('.asset-card-name');
                if (cardName) {
                    const existingBadge = card.querySelector('.blocked-location-badge');
                    if (isBlocked) {
                        if (!existingBadge) {
                            const badge = document.createElement('span');
                            badge.className = 'blocked-location-badge';
                            badge.textContent = 'Already here';
                            card.appendChild(badge);
                        }
                    } else if (existingBadge) {
                        existingBadge.remove();
                    }
                }
            });
        }

        function addTransferItem(item) {
            const destination = document.getElementById('to_site_floor')?.value || '';
            const currentLocation = (item.currentLocation || '').trim();
            const maxQty = Number(item.availableQty || 1);
            const defaultQty = item.customQty ? Math.min(Number(item.customQty), maxQty) : maxQty;

            if (destination !== '' && currentLocation !== '' && currentLocation.toLowerCase() === destination.toLowerCase()) {
                showTransferWarning('This asset is already at the selected destination site and cannot be added to the transfer list.');
                return;
            }

            const existing = transferBox.querySelector(`.transfer-item[data-item-id="${item.id}"]`);
            if (existing) {
                const qtyInput = existing.querySelector('.transfer-qty');
                if (qtyInput) {
                    qtyInput.focus();
                    const currentValue = Number(qtyInput.value || 1);
                    qtyInput.value = clampQty(currentValue + 1, maxQty);
                    updateTransferSummary();
                }
                return;
            }

            const index = transferBox.querySelectorAll('.transfer-item').length;
            const row = document.createElement('div');
            row.className = 'transfer-item';
            row.dataset.itemId = item.id;
            row.innerHTML = `
                <div class="transfer-item-head">
                    <strong>${item.name}</strong>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-transfer-item" title="Remove asset">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <div class="transfer-item-meta">Available qty: ${maxQty}</div>
                <div class="transfer-item-field">
                    <label>Qty</label>
                    <input type="number" class="form-control transfer-qty" name="items[${index}][quantity]" min="1" max="${maxQty}" value="${defaultQty}" data-item-id="${item.id}" />
                    <input type="hidden" name="items[${index}][item_id]" value="${item.id}" />
                    <input type="hidden" name="items[${index}][unit]" value="${item.unit}" />
                    <input type="hidden" name="items[${index}][description]" value="${item.description}" />
                    <input type="hidden" name="items[${index}][remarks]" value="Transferred from ${item.fromSite || 'current site'} to ${item.toSite || 'new site'}" />
                </div>
            `;

            row.querySelector('.remove-transfer-item').addEventListener('click', function () {
                removeTransferItem(this);
            });

            row.querySelector('.transfer-qty').addEventListener('input', function () {
                const maxQty = Number(item.availableQty || 1);
                const currentValue = Number(this.value || 1);
                this.value = clampQty(currentValue, maxQty);
                updateTransferSummary();
                updateAssetTransferState(item.id);
            });

            transferBox.appendChild(row);
            reindexTransferItems();
            updateTransferSummary();
        }

        inventoryPool.querySelectorAll('.asset-drag-card').forEach((card) => {
            card.addEventListener('click', function () {
                if (card.classList.contains('is-blocked')) {
                    showTransferWarning('This asset is already at the selected destination site and cannot be transferred there.');
                    return;
                }

                openAssetModal(card);
            });

            card.addEventListener('dragstart', function (event) {
                const destination = document.getElementById('to_site_floor')?.value || '';
                const currentLocation = (card.dataset.currentLocation || '').trim();

                if (destination !== '' && currentLocation !== '' && currentLocation.toLowerCase() === destination.toLowerCase()) {
                    event.preventDefault();
                    showTransferWarning('This asset is already at the selected destination site and cannot be transferred there.');
                    return;
                }

                card.classList.add('dragging');
                event.dataTransfer.setData('text/plain', JSON.stringify({
                    id: card.dataset.itemId,
                    name: card.dataset.itemName,
                    unit: card.dataset.unit,
                    description: card.dataset.description,
                    availableQty: card.dataset.availableQty,
                    currentLocation: card.dataset.currentLocation || '',
                    fromSite: document.getElementById('from_site_floor')?.value || 'current site',
                    toSite: document.getElementById('to_site_floor')?.value || 'new site'
                }));
            });

            card.addEventListener('dragend', function () {
                card.classList.remove('dragging');
                transferBox.classList.remove('is-active');
            });
        });

        transferBox.addEventListener('dragover', function (event) {
            event.preventDefault();
            transferBox.classList.add('is-active');
        });

        transferBox.addEventListener('dragleave', function (event) {
            if (!transferBox.contains(event.relatedTarget)) {
                transferBox.classList.remove('is-active');
            }
        });

        transferBox.addEventListener('drop', function (event) {
            event.preventDefault();
            transferBox.classList.remove('is-active');

            try {
                const item = JSON.parse(event.dataTransfer.getData('text/plain'));
                if (!item || !item.id) {
                    return;
                }

                addTransferItem(item);
            } catch (error) {
                console.error('Invalid drag data', error);
            }
        });

        transferBox.addEventListener('click', function (event) {
            const removeButton = event.target.closest('.remove-transfer-item');
            if (!removeButton) {
                return;
            }
            removeTransferItem(removeButton);
        });

        document.addEventListener('input', function (event) {
            if (event.target.classList.contains('transfer-qty')) {
                const maxQty = Number(event.target.max || 1);
                event.target.value = clampQty(Number(event.target.value || 1), maxQty);
                updateTransferSummary();
            }
        });

        document.getElementById('from_site_floor').addEventListener('change', function () {
            syncBlockedAssets();
        });

        document.getElementById('to_site_floor').addEventListener('change', function () {
            syncBlockedAssets();

            document.querySelectorAll('.transfer-item').forEach((item) => {
                const remarksInput = item.querySelector('input[name$="[remarks]"]');
                if (remarksInput) {
                    remarksInput.value = `Transferred from ${document.getElementById('from_site_floor')?.value || 'current site'} to ${document.getElementById('to_site_floor')?.value || 'new site'}`;
                }
            });
        });

        document.querySelector('form').addEventListener('submit', function (event) {
            const destination = document.getElementById('to_site_floor')?.value || '';
            const blockedAssets = Array.from(inventoryPool.querySelectorAll('.asset-drag-card.is-blocked'));

            if (blockedAssets.length > 0 && destination !== '') {
                event.preventDefault();
                showTransferWarning('Some items are already at the selected destination site and cannot be included in this transfer.');
                return;
            }

            const transferItems = Array.from(transferBox.querySelectorAll('.transfer-item'));
            const invalidTransfer = transferItems.some((item) => {
                const itemId = item.dataset.itemId;
                const card = inventoryPool.querySelector(`.asset-drag-card[data-item-id="${itemId}"]`);
                const currentLocation = (card?.dataset.currentLocation || '').trim();
                return destination !== '' && currentLocation !== '' && currentLocation.toLowerCase() === destination.toLowerCase();
            });

            if (invalidTransfer) {
                event.preventDefault();
                showTransferWarning('One or more selected assets are already at the destination site. Remove them before generating the gatepass.');
            }
        });

        syncBlockedAssets();
        updateTransferSummary();

        // Initialize filter buttons from unique categories
        function initializeFilterButtons() {
            const filterControls = document.getElementById('filter-controls');
            if (!filterControls) return;

            const categories = new Set();
            inventoryPool.querySelectorAll('.asset-drag-card').forEach((card) => {
                const category = card.dataset.category || '';
                if (category) categories.add(category);
            });

            if (categories.size === 0) return;

            const sortedCategories = Array.from(categories).sort();
            sortedCategories.forEach((category) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'filter-btn';
                btn.textContent = category;
                btn.dataset.filter = category;
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    this.classList.toggle('active');
                    updateClearButtonState();
                    applyFiltersAndSearch();
                });
                filterControls.appendChild(btn);
            });

            // Add clear filters button
            const clearBtn = document.createElement('button');
            clearBtn.type = 'button';
            clearBtn.className = 'clear-filters-btn';
            clearBtn.id = 'clear-filters-btn';
            clearBtn.textContent = '✕ Clear Filters';
            clearBtn.disabled = true;
            clearBtn.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelectorAll('.filter-btn.active').forEach((btn) => {
                    btn.classList.remove('active');
                });
                document.getElementById('asset-search').value = '';
                updateClearButtonState();
                applyFiltersAndSearch();
            });
            filterControls.appendChild(clearBtn);
        }

        function updateClearButtonState() {
            const clearBtn = document.getElementById('clear-filters-btn');
            const activeFilters = document.querySelectorAll('.filter-btn.active').length;
            const searchTerm = document.getElementById('asset-search')?.value.trim() || '';
            
            if (clearBtn) {
                clearBtn.disabled = activeFilters === 0 && !searchTerm;
            }
        }

      function normalizeLocation(value) {
    return (value || '')
        .toString()
        .trim()
        .replace(/\s+/g, ' ')
        .toLowerCase();
}

function applyFiltersAndSearch() {
    const fromSite = document.getElementById('from_site_floor')?.value || '';
    const normalizedFromSite = normalizeLocation(fromSite);

    const searchTerm =
        document.getElementById('asset-search')?.value.toLowerCase().trim() || '';

    const activeFilters = Array.from(
        document.querySelectorAll('.filter-btn.active')
    ).map((btn) => btn.dataset.filter);

    const assetCards = inventoryPool.querySelectorAll('.asset-drag-card');

    let visibleCount = 0;

    /*
     * If no From Site is selected, don't show assets.
     */
    if (!normalizedFromSite) {
        assetCards.forEach((card) => {
            card.classList.add('hidden-by-default');
            card.style.display = 'none';
        });

        let noResultsState = inventoryPool.querySelector('.no-results-state');

        if (!noResultsState) {
            noResultsState = document.createElement('div');
            noResultsState.className = 'no-results-state';
            noResultsState.textContent =
                'Please select a From Site / Floor to view available assets.';
            inventoryPool.appendChild(noResultsState);
        }

        updateClearButtonState();
        return;
    }

    /*
     * Remove the "select From Site" message.
     */
    const noSiteMessage = inventoryPool.querySelector('.no-results-state');

    if (noSiteMessage) {
        noSiteMessage.remove();
    }

    assetCards.forEach((card) => {
        const currentLocation =
            normalizeLocation(card.dataset.currentLocation);

        const assetTag =
            (card.dataset.assetTag || '').toLowerCase();

        const itemName =
            (card.dataset.itemName || '').toLowerCase();

        const description =
            (card.dataset.description || '').toLowerCase();

        const category =
            (card.dataset.category || '').toLowerCase();

        /*
         * MAIN FILTER:
         * Only show assets currently located at the selected From Site / Floor.
         */
        const matchesFromSite =
            currentLocation === normalizedFromSite;

        /*
         * Search filter.
         */
        const matchesSearch =
            !searchTerm ||
            assetTag.includes(searchTerm) ||
            itemName.includes(searchTerm) ||
            description.includes(searchTerm);

        /*
         * Category filter.
         */
        const matchesFilter =
            activeFilters.length === 0 ||
            activeFilters.some(
                (filter) => filter.toLowerCase() === category
            );

        /*
         * Asset must match ALL conditions.
         */
        const shouldShow =
            matchesFromSite &&
            matchesSearch &&
            matchesFilter;

        if (shouldShow) {
            card.classList.remove('hidden-by-default');
            card.style.display = '';
            visibleCount++;
        } else {
            card.classList.add('hidden-by-default');
            card.style.display = 'none';
        }
    });

    /*
     * Show message when the selected From Site has no assets.
     */
    let noResultsState = inventoryPool.querySelector('.no-results-state');

    if (visibleCount === 0) {
        if (!noResultsState) {
            noResultsState = document.createElement('div');
            noResultsState.className = 'no-results-state';
            inventoryPool.appendChild(noResultsState);
        }

        if (searchTerm || activeFilters.length > 0) {
            noResultsState.textContent =
                'No assets found at the selected From Site matching your search or filters.';
        } else {
            noResultsState.textContent =
                'No assets are currently available at the selected From Site / Floor.';
        }
    } else if (noResultsState) {
        noResultsState.remove();
    }

    updateClearButtonState();
}

        const assetSearch = document.getElementById('asset-search');
        if (assetSearch) {
            assetSearch.addEventListener('input', function () {
                applyFiltersAndSearch();
                updateClearButtonState();
            });
        }

        let currentAssetCard = null;

        function openAssetModal(card) {
            currentAssetCard = card;
            const modalOverlay = document.getElementById('asset-modal-overlay');
            const modalTag = document.getElementById('modal-asset-tag');
            const modalBody = document.getElementById('modal-body');
            const availableQty = Number(card.dataset.availableQty || 1);

            modalTag.textContent = card.dataset.assetTag || 'Asset Details';

            const fields = [
                { label: 'Item Name', value: card.dataset.itemName },
                { label: 'Asset Tag', value: card.dataset.assetTag },
                { label: 'Category', value: card.dataset.category || card.dataset.unit },
                { label: 'Brand', value: card.dataset.brand },
                { label: 'Model', value: card.dataset.model },
                { label: 'Current Location', value: card.dataset.currentLocation },
                { label: 'Available Qty', value: card.dataset.availableQty }
            ];

            modalBody.innerHTML = fields.map((field) => `
                <div class="asset-modal-row">
                    <span class="asset-modal-label">${field.label}</span>
                    <span class="asset-modal-value">${field.value || 'N/A'}</span>
                </div>
            `).join('') + `
                <div class="asset-modal-qty-selector">
                    <label for="modal-qty-input">Transfer Qty:</label>
                    <input 
                        type="number" 
                        id="modal-qty-input" 
                        min="1" 
                        max="${availableQty}" 
                        value="${availableQty}"
                        class="form-control"
                        data-available="${availableQty}"
                    />
                    <span id="modal-qty-error" style="display: none; color: #991b1b; font-size: 0.75rem; margin-top: 0.25rem;"></span>
                </div>
            `;

            // Add real-time validation to quantity input
            setTimeout(() => {
                const qtyInput = document.getElementById('modal-qty-input');
                const errorSpan = document.getElementById('modal-qty-error');
                if (qtyInput) {
                    qtyInput.addEventListener('input', function () {
                        const val = Number(this.value);
                        const maxVal = Number(this.dataset.available);
                        let error = '';

                        if (isNaN(val) || val === '') {
                            error = 'Please enter a valid number';
                        } else if (val < 1) {
                            error = 'Quantity must be at least 1';
                        } else if (val > maxVal) {
                            error = `Quantity cannot exceed ${maxVal}`;
                        } else if (!Number.isInteger(val)) {
                            error = 'Quantity must be a whole number';
                        }

                        if (error) {
                            errorSpan.textContent = error;
                            errorSpan.style.display = 'block';
                            this.classList.add('is-invalid');
                        } else {
                            errorSpan.style.display = 'none';
                            this.classList.remove('is-invalid');
                        }
                    });
                }
            }, 50);

            modalOverlay.classList.add('active');
        }

        function closeAssetModal() {
            const modalOverlay = document.getElementById('asset-modal-overlay');
            modalOverlay.classList.remove('active');
            currentAssetCard = null;
        }

        // Modal event listeners
        const modalOverlay = document.getElementById('asset-modal-overlay');
        const modalCloseBtn = document.getElementById('modal-close-btn');
        const modalCloseBtnFooter = document.getElementById('modal-close-btn-footer');
        const modalAddBtn = document.getElementById('modal-add-btn');

        if (modalCloseBtn) {
            modalCloseBtn.addEventListener('click', closeAssetModal);
        }

        if (modalCloseBtnFooter) {
            modalCloseBtnFooter.addEventListener('click', closeAssetModal);
        }

        if (modalOverlay) {
            modalOverlay.addEventListener('click', function (e) {
                if (e.target === this) {
                    closeAssetModal();
                }
            });
        }

        if (modalAddBtn) {
            modalAddBtn.addEventListener('click', function () {
                if (currentAssetCard) {
                    const qtyInput = document.getElementById('modal-qty-input');
                    const errorSpan = document.getElementById('modal-qty-error');
                    
                    if (!qtyInput) {
                        handleQuickAdd(currentAssetCard, null);
                        closeAssetModal();
                        return;
                    }

                    const customQty = Number(qtyInput.value);
                    const maxQty = Number(qtyInput.dataset.available);
                    let isValid = true;
                    let errorMsg = '';

                    if (isNaN(customQty) || customQty === '') {
                        isValid = false;
                        errorMsg = 'Please enter a valid number';
                    } else if (customQty < 1) {
                        isValid = false;
                        errorMsg = 'Quantity must be at least 1';
                    } else if (customQty > maxQty) {
                        isValid = false;
                        errorMsg = `Quantity cannot exceed ${maxQty}`;
                    } else if (!Number.isInteger(customQty)) {
                        isValid = false;
                        errorMsg = 'Quantity must be a whole number';
                    }

                    if (!isValid) {
                        if (errorSpan) {
                            errorSpan.textContent = errorMsg;
                            errorSpan.style.display = 'block';
                        }
                        showTransferWarning(`Invalid quantity: ${errorMsg}`);
                        return;
                    }

                    if (errorSpan) {
                        errorSpan.style.display = 'none';
                    }
                    
                    handleQuickAdd(currentAssetCard, customQty);
                    closeAssetModal();
                }
            });
        }

        initializeFilterButtons();
    </script>
</body>

</html>
