{{-- filepath: c:\xampp\htdocs\ASI-INVENTORY\resources\views\transfer\edit.blade.php --}}

@section('title', 'Edit Fixed Asset Transfer')
@include('layouts.title')

<style>
    .transfer-edit-page { padding: 1.25rem; }
    .transfer-edit-card { max-width: 980px; margin: 0 auto; border: 0; border-radius: 14px; overflow: hidden; }
    .transfer-edit-header { padding: 1.5rem; color: #fff; background: linear-gradient(135deg, #123b78, #1769aa); }
    .transfer-edit-header h1 { margin: 0; font-size: 1.35rem; }
    .transfer-edit-header p { margin: .35rem 0 0; opacity: .85; }
    .transfer-edit-body { padding: 1.5rem; }
    .form-label { font-weight: 600; color: #334155; }
    .required::after { content: ' *'; color: #dc3545; }
    @media (max-width: 768px) {
        .transfer-edit-page, .transfer-edit-body { padding: 1rem; }
    }
</style>

<body>
    @include('layouts.header')
    @include('layouts.sidebar')
    <main id="main" class="main-fluid">
    <div class="card transfer-edit-card shadow-sm">
        <div class="transfer-edit-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">

     
                    <div>
                        <h1><i class="bi bi-pencil-square me-2"></i>Edit Fixed Asset Transfer</h1>
                        <p>Update the information for this asset transfer record.</p>
                    </div>
                    <a href="{{ route('asset.transfer.index') }}" class="btn btn-light text-primary">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                </div>

                <div class="transfer-edit-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Please correct the following:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('asset.transfer.update', $assetTransfer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="reference_no" class="form-label required">Reference No.</label>
                                <input type="text" id="reference_no" name="reference_no" class="form-control"
                                       value="{{ old('reference_no', $assetTransfer->reference_no) }}" required maxlength="100">
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="date_of_transfer" class="form-label required">Date of Transfer</label>
                                    <input type="date" id="date_of_transfer" name="date_of_transfer" class="form-control"
                                        value="{{ old('date_of_transfer', $assetTransfer->date_of_transfer ? \Carbon\Carbon::parse($assetTransfer->date_of_transfer)->format('Y-m-d') : '') }}" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="from_campaign" class="form-label required">Original Campaign/Team</label>
                                <input type="text" id="from_campaign" name="from_campaign" class="form-control"
                                       value="{{ old('from_campaign', $assetTransfer->from_campaign) }}" required maxlength="255">
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="to_campaign" class="form-label required">Transferred Campaign</label>
                                <input type="text" id="to_campaign" name="to_campaign" class="form-control"
                                       value="{{ old('to_campaign', $assetTransfer->to_campaign) }}" required maxlength="255">
                            </div>

                            <div class="col-12">
                                <label for="asset_type" class="form-label required">Asset Type</label>
                                <input type="text" id="asset_type" name="asset_type" class="form-control"
                                       value="{{ old('asset_type', $assetTransfer->asset_type) }}" required maxlength="255">
                            </div>
                            <div class="col-12">
                                <label for="quantity" class="form-label required">Quantity</label>
                                <input type="number" id="quantity" name="quantity" class="form-control"
                                       value="{{ old('quantity', $assetTransfer->quantity) }}" required maxlength="255">
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="status" class="form-label required">Status</label>
                                <select id="status" name="status" class="form-select" required>
                                    @foreach (['Ongoing', 'Completed', 'Cancelled'] as $status)
                                        <option value="{{ $status }}" @selected(old('status', $assetTransfer->status ?: 'Ongoing') === $status)>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="remarks" class="form-label">Reason for Transfer / Remarks</label>
                                <textarea id="remarks" name="remarks" class="form-control" rows="4">{{ old('remarks', $assetTransfer->remarks) }}</textarea>
                            </div>

                            <div class="col-12 d-flex flex-wrap justify-content-end gap-2 mt-3">
                                <a href="{{ route('asset.transfer.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <a href="{{ route('asset.transfer.print', $assetTransfer->id) }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="bi bi-printer me-1"></i>Print
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>
</html>
