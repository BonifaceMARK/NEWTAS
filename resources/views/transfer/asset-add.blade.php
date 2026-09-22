@section('title', env('APP_NAME'))

@include('layouts.title')

<style>
    .item-row:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(13,110,253,0.2);
}

    .form-group-icon {
        position: relative;
    }

    .form-group-icon .form-icon {
        position: absolute;
        left: 12px;
        top: 38px;
        color: #6c757d;
        font-size: 16px;
        pointer-events: none;
    }

    .form-control, .form-select {
        padding-left: 38px !important;
        border: 1px solid #e0e0e0 !important;
        border-radius: 6px;
        transition: all 0.3s ease;
        background-color: #f9f9f9;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd !important;
        background-color: #fff;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-label i {
        color: #0d6efd;
        font-size: 14px;
    }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .card-body {
        padding: 32px;
    }

    .section-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #0d6efd;
        font-size: 32px;
    }

    .form-section-subtitle {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 24px;
    }

    .form-divider {
        margin: 24px 0;
        border-top: 1px solid #e0e0e0;
    }

    .form-section-header {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0f0f0;
    }

    .btn-group-custom {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 32px;
    }

    .btn-group-custom .btn {
        border-radius: 6px;
        font-weight: 600;
        padding: 10px 28px;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-success {
        background-color: #198754;
    }

    .btn-success:hover {
        background-color: #157347;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
    }

    .btn-primary {
        background-color: #0d6efd;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .alert-danger {
        border-radius: 6px;
        border: none;
        background-color: #f8d7da;
    }

    textarea.form-control {
        resize: vertical;
        font-family: inherit;
    }
</style>

<body>
    @include('layouts.header')
    @include('layouts.sidebar')

    <main id="main" class="main">
        <section class="section">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="section-title mb-2">
                        <i class="bi bi-arrow-left-right"></i>
                        Fixed Asset Transfer Form
                    </div>
                    <p class="form-section-subtitle">Complete all required fields to process asset transfer</p>

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <div style="display: flex; gap: 10px;">
                                <i class="bi bi-exclamation-circle-fill" style="flex-shrink: 0;"></i>
                                <div>
                                    <strong>Please fix the following errors:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

        <form action="{{ route('asset.transfer') }}" method="POST" class="row g-3" style="padding:20px;">
    @csrf
 
        <div class="form-divider" style="border-top:1px solid #ddd; margin:20px 0;"></div>
    <div class="col-md-3">
        <div class="form-group-icon">
            <label for="reference_no" class="form-label">
                <i class="bi bi-hash"></i> Reference No.
            </label>
            <input type="text" class="form-control" id="reference_no" name="reference_no"
                   placeholder="REF-001" value="{{ old('reference_no') }}" required>
        </div>
          <div class="form-group-icon mt-2">
            <label for="date_of_transfer" class="form-label">
                <i class="bi bi-calendar-event"></i> Date of Transfer
            </label>
            <input type="date" class="form-control" id="date_of_transfer" name="date_of_transfer"
                   value="{{ old('date_of_transfer') }}" required>
        </div>
    </div>

 <div class="col-md-6">
        <label for="asset_type" class="form-label ">
            <i class="bi bi-tools"></i> Asset Type
        </label>
        <input type="text" class="form-control" id="asset_type" name="asset_type"
               placeholder="e.g., Computer, Printer" value="{{ old('asset_type') }}" required>
                <label for="status" class="form-label mt-2">
            <i class="bi bi-circle-fill"></i> Status
        </label>
        <select class="form-select" id="status" name="status" required>
            @foreach (['Ongoing', 'Completed', 'Cancelled'] as $status)
                <option value="{{ $status }}" @selected(old('status', 'Ongoing') === $status)>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>
 

    <div class="col-12">
        <label for="remarks" class="form-label">
            <i class="bi bi-pencil"></i> Reason for Transfer
        </label>
        <textarea class="form-control" id="remarks" name="remarks" rows="4"
                  placeholder="Provide detailed reason for transfer...">{{ old('remarks') }}</textarea>
    </div>



<div class="row mt-2">
    <!-- Original Campaign -->
    <div class="col-md-6">
        <label for="from_campaign" class="form-label">
            <i class="bi bi-box-arrow-left"></i> Original Campaign/Team
        </label>
        <select class="form-select" id="from_campaign" name="from_campaign" required>
            <option value="">Select Campaign/Team</option>
            @foreach ($campaignOptions as $option)
                <option value="{{ $option->option_value }}"
                    {{ old('from_campaign') == $option->option_value ? 'selected' : '' }}>
                    {{ $option->option_value }}
                </option>
            @endforeach
        </select>

        <!-- Item List -->
        <div id="item-list" class="mt-3 col-12"
             style="display:none; flex-wrap:wrap; gap:15px;">
            @foreach($inventoryItems as $item)
                <div class="item-row"
                     data-id="{{ $item->id }}"
                     data-campaign="{{ strtolower(trim($item->campaign)) }}"
                     draggable="true"
                     style="position:relative; flex:0 0 220px; padding:18px; border-radius:10px;
                            background-color:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.08);
                            transition:all 0.3s ease; text-align:center; cursor:grab;">
                    <i class="bi bi-box-seam" style="color:#0d6efd; font-size:28px; margin-bottom:8px;"></i>
                    <div style="font-weight:600; color:#333; font-size:14px;">
                        {{ $item->item_name }}
                    </div>
                    <div style="font-size:12px; color:#6c757d;">
                        {{ $item->asset_tag }}
                    </div>
                    <input type="checkbox" name="items[]" value="{{ $item->id }}" hidden>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Transferred Campaign -->
    <div class="col-md-6">
        <label for="to_campaign" class="form-label">
            <i class="bi bi-box-arrow-right"></i> Transferred Campaign
        </label>
        <select class="form-select" id="to_campaign" name="to_campaign" required>
            <option value="">Select Transferred Campaign</option>
            @foreach ($campaignOptions as $option)
                <option value="{{ $option->option_value }}"
                    {{ old('to_campaign') == $option->option_value ? 'selected' : '' }}>
                    {{ $option->option_value }}
                </option>
            @endforeach
        </select>

        <!-- Drop Zone -->
        <div id="transfer-box" class="mt-3"
             style="min-height:220px; border:2px dashed #0d6efd; border-radius:10px;
                    background:#f8fbff; padding:15px; display:flex; flex-wrap:wrap; gap:15px;
                    align-items:flex-start; justify-content:flex-start;">
            <p class="text-muted" style="width:100%; text-align:center;">Drag items here to transfer...</p>
        </div>

        <!-- Counter -->
        <div id="transfer-count" class="mt-2 text-muted" style="font-size:13px;">
            0 items transferred
        </div>
    </div>
</div>



    <!-- Action Buttons -->
    <div class="col-12 text-center" style="margin-top:20px;">
        <button type="submit" name="action" value="save" class="btn btn-success me-2">
            <i class="bi bi-check-circle me-2"></i> Save Transfer
        </button>
        <button type="submit" name="action" value="print" class="btn btn-primary" formtarget="_blank">
            <i class="bi bi-printer me-2"></i> Print Transfer
        </button>
    </div>
</form>


                </div>
            </div>
        </section>
    </main>

    @include('layouts.footer')
<script>
    const fromCampaignSelect = document.getElementById('from_campaign');
    const toCampaignSelect   = document.getElementById('to_campaign');
    const form               = document.querySelector('form');

    document.addEventListener('DOMContentLoaded', () => {
        const transferBox = document.getElementById('transfer-box');
        const itemList = document.getElementById('item-list');
        const transferCount = document.getElementById('transfer-count');

        // --- Helper Functions ---
        function updateCount() {
            const count = transferBox.querySelectorAll('.item-row').length;
            transferCount.textContent = count + ' item' + (count !== 1 ? 's' : '') + ' transferred';
        }

        function enableDrag(item) {
            item.setAttribute('draggable', 'true');
            item.addEventListener('dragstart', e => {
                e.dataTransfer.setData('text/plain', item.dataset.id);
                e.dataTransfer.effectAllowed = 'move';
                item.classList.add('dragging');
            });
            item.addEventListener('dragend', () => {
                item.classList.remove('dragging');
            });
        }

        function refreshDraggableItems() {
            document.querySelectorAll('.item-row').forEach(enableDrag);
        }

        function attachReturnButtons() {
            document.querySelectorAll('#transfer-box .return-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const card = btn.closest('.item-row');
                    itemList.appendChild(card);
                    card.querySelector('input[type="checkbox"]').checked = false;

                    enableDrag(card);
                    refreshDraggableItems();
                    updateCount();

                    if (!transferBox.querySelector('.item-row')) {
                        transferBox.innerHTML = '<p class="text-muted" style="width:100%; text-align:center;">Drag items here to transfer...</p>';
                    }
                });
            });
        }

        // --- Initialize Draggable Items ---
        refreshDraggableItems();

        // --- Drop Zone Logic (Transfer to Transferred Campaign) ---
        transferBox.addEventListener('dragover', e => {
            e.preventDefault();
            transferBox.style.background = '#e6f0ff';
        });

        transferBox.addEventListener('dragleave', () => {
            transferBox.style.background = '#f8fbff';
        });

        transferBox.addEventListener('drop', e => {
            e.preventDefault();
            transferBox.style.background = '#f8fbff';
            const draggedItem = document.querySelector('.dragging');
            if (draggedItem) {
                transferBox.appendChild(draggedItem);
                draggedItem.querySelector('input[type="checkbox"]').checked = true;

                // Add return button if missing
                if (!draggedItem.querySelector('.return-btn')) {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'return-btn btn btn-sm btn-outline-secondary';
                    btn.style.position = 'absolute';
                    btn.style.top = '8px';
                    btn.style.right = '8px';
                    btn.innerHTML = '<i class="bi bi-arrow-counterclockwise"></i>';
                    draggedItem.appendChild(btn);
                }

                enableDrag(draggedItem);
                refreshDraggableItems();
                attachReturnButtons();
                updateCount();
            }
            if (transferBox.querySelector('p')) {
                transferBox.querySelector('p').remove();
            }
        });

        // --- Reverse Drop Logic (Return to Original Campaign) ---
        itemList.addEventListener('dragover', e => {
            e.preventDefault();
            itemList.style.background = '#f8f9fa';
        });

        itemList.addEventListener('dragleave', () => {
            itemList.style.background = 'transparent';
        });

        itemList.addEventListener('drop', e => {
            e.preventDefault();
            itemList.style.background = 'transparent';
            const draggedItem = document.querySelector('.dragging');
            if (draggedItem && draggedItem.closest('#transfer-box')) {
                itemList.appendChild(draggedItem);
                draggedItem.querySelector('input[type="checkbox"]').checked = false;

                // Remove return button when back in original list
                const btn = draggedItem.querySelector('.return-btn');
                if (btn) btn.remove();

                enableDrag(draggedItem);
                refreshDraggableItems();
                updateCount();

                if (!transferBox.querySelector('.item-row')) {
                    transferBox.innerHTML = '<p class="text-muted" style="width:100%; text-align:center;">Drag items here to transfer...</p>';
                }
            }
        });

        updateCount();
    });

    // --- Campaign Filtering ---
    fromCampaignSelect.addEventListener('change', function() {
        const selectedCampaign = this.value.toLowerCase();
        const itemList = document.getElementById('item-list');
        const items = itemList.querySelectorAll('.item-row');

        if (!selectedCampaign) {
            itemList.style.display = 'none';
        } else {
            itemList.style.display = 'flex';
        }

        items.forEach(item => {
            const itemCampaign = (item.dataset.campaign || '').toLowerCase();
            if (itemCampaign === selectedCampaign) {
                item.style.display = 'inline-block';
            } else {
                item.style.display = 'none';
                item.querySelector('input[type="checkbox"]').checked = false;
            }
        });

        updateCampaignOptions();
    });

    // --- Prevent Same Campaign Selection ---
    function updateCampaignOptions() {
        const fromValue = fromCampaignSelect.value;
        const toCampaignOptions = toCampaignSelect.querySelectorAll('option');

        toCampaignOptions.forEach(option => {
            if (option.value === fromValue && option.value !== '') {
                option.disabled = true;
                option.style.display = 'none';
            } else if (option.value !== '') {
                option.disabled = false;
                option.style.display = 'block';
            }
        });

        if (toCampaignSelect.value === fromValue && fromValue !== '') {
            toCampaignSelect.value = '';
        }
    }

    // --- Form Validation ---
    function validateCampaignTransfer(e) {
        const fromValue = fromCampaignSelect.value;
        const toValue   = toCampaignSelect.value;

        if (!fromValue || !toValue) {
            e.preventDefault();
            alert('Please select both Original Campaign and Transferred Campaign');
            return false;
        }

        if (fromValue === toValue) {
            e.preventDefault();
            alert('Cannot transfer items to the same campaign. Please select a different campaign.');
            return false;
        }

        return true;
    }

    if (toCampaignSelect) {
        toCampaignSelect.addEventListener('change', updateCampaignOptions);
    }

    if (form) {
        form.addEventListener('submit', validateCampaignTransfer);
    }

    // --- Tooltip Hover Logic ---
    document.addEventListener('DOMContentLoaded', function() {
        updateCampaignOptions();

        document.querySelectorAll('.item-row').forEach(item => {
            item.addEventListener('mouseenter', () => {
                const tooltip = item.querySelector('.item-tooltip');
                if (tooltip) tooltip.style.display = 'block';
            });
            item.addEventListener('mouseleave', () => {
                const tooltip = item.querySelector('.item-tooltip');
                if (tooltip) tooltip.style.display = 'none';
            });
        });
    });
</script>


</body>

</html>
