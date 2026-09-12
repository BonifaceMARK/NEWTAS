@section('title', env('APP_NAME'))

@include('layouts.title')

<style>
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
        justify-content: flex-start;
        margin-top: 32px;
    }

    .btn-group-custom .btn {
        border-radius: 6px;
        font-weight: 600;
        padding: 10px 28px;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary {
        background-color: #0d6efd;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .btn-secondary {
        background-color: #6c757d;
        color: #fff;
    }

    .btn-secondary:hover {
        background-color: #5c636a;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
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
                        <i class="bi bi-box-seam"></i>
                        Add Inventory Item
                    </div>
                    <p class="form-section-subtitle">Fill in all required fields to add a new inventory item</p>

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

                    <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf

                        <!-- Asset Identification Section -->
                        <div class="col-12">
                            <div class="form-section-header">
                                <i class="bi bi-tag" style="margin-right: 8px; color: #0d6efd;"></i>
                                Asset Identification
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-icon">
                                <label for="asset_tag" class="form-label">
                                    <i class="bi bi-hash"></i> Asset Tag
                                </label>
                                <span class="form-icon"><i class="bi bi-hash"></i></span>
                                <input type="text" class="form-control" id="asset_tag" name="asset_tag" placeholder="AST-001" value="{{ old('asset_tag') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-icon">
                                <label for="item_name" class="form-label">
                                    <i class="bi bi-pencil-square"></i> Item Name
                                </label>
                                <span class="form-icon"><i class="bi bi-pencil-square"></i></span>
                                <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Enter item name" value="{{ old('item_name') }}" required>
                            </div>
                        </div>

                        <!-- Classification Section -->
                        <div class="col-12">
                            <div class="form-divider"></div>
                            <div class="form-section-header">
                                <i class="bi bi-layers" style="margin-right: 8px; color: #0d6efd;"></i>
                                Classification
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group-icon">
                                <label for="category" class="form-label">
                                    <i class="bi bi-bookmarks"></i> Category
                                </label>
                                <span class="form-icon"><i class="bi bi-bookmarks"></i></span>
                                <select class="form-select" id="category" name="category">
                                    <option value="">Select category</option>
                                    @foreach ($options['category'] ?? [] as $option)
                                        <option value="{{ $option->option_value }}" @selected(old('category') === $option->option_value)>{{ $option->option_value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group-icon">
                                <label for="brand" class="form-label">
                                    <i class="bi bi-shield-check"></i> Brand
                                </label>
                                <span class="form-icon"><i class="bi bi-shield-check"></i></span>
                                <select class="form-select" id="brand" name="brand">
                                    <option value="">Select brand</option>
                                    @foreach ($options['brand'] ?? [] as $option)
                                        <option value="{{ $option->option_value }}" @selected(old('brand') === $option->option_value)>{{ $option->option_value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group-icon">
                                <label for="model" class="form-label">
                                    <i class="bi bi-cpu"></i> Model
                                </label>
                                <span class="form-icon"><i class="bi bi-cpu"></i></span>
                                <input type="text" class="form-control" id="model" name="model" placeholder="Enter model number" value="{{ old('model') }}">
                            </div>
                        </div>

                        <!-- Technical Details Section -->
                        <div class="col-12">
                            <div class="form-divider"></div>
                            <div class="form-section-header">
                                <i class="bi bi-gear" style="margin-right: 8px; color: #0d6efd;"></i>
                                Technical Details
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-icon">
                                <label for="serial_number" class="form-label">
                                    <i class="bi bi-barcode"></i> Serial Number
                                </label>
                                <span class="form-icon"><i class="bi bi-barcode"></i></span>
                                <input type="text" class="form-control" id="serial_number" name="serial_number" placeholder="Enter serial number" value="{{ old('serial_number') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group-icon">
                                <label for="purchase_date" class="form-label">
                                    <i class="bi bi-calendar"></i> Purchase Date
                                </label>
                                <span class="form-icon"><i class="bi bi-calendar"></i></span>
                                <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group-icon">
                                <label for="warranty_expiry" class="form-label">
                                    <i class="bi bi-calendar-check"></i> Warranty Expiry
                                </label>
                                <span class="form-icon"><i class="bi bi-calendar-check"></i></span>
                                <input type="date" class="form-control" id="warranty_expiry" name="warranty_expiry" value="{{ old('warranty_expiry') }}">
                            </div>
                        </div>

                        <!-- Assignment Section -->
                        <div class="col-12">
                            <div class="form-divider"></div>
                            <div class="form-section-header">
                                <i class="bi bi-person-check" style="margin-right: 8px; color: #0d6efd;"></i>
                                Assignment & Organization
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-icon">
                                <label for="assigned_to" class="form-label">
                                    <i class="bi bi-person"></i> Assigned To
                                </label>
                                <span class="form-icon"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="assigned_to" name="assigned_to" placeholder="Enter name" value="{{ old('assigned_to') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-icon">
                                <label for="department" class="form-label">
                                    <i class="bi bi-building"></i> Department
                                </label>
                                <span class="form-icon"><i class="bi bi-building"></i></span>
                                <select class="form-select" id="department" name="department">
                                    <option value="">Select department</option>
                                    @foreach ($options['department'] ?? [] as $option)
                                        <option value="{{ $option->option_value }}" @selected(old('department') === $option->option_value)>{{ $option->option_value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-icon">
                                <label for="campaign" class="form-label">
                                    <i class="bi bi-diagram-3"></i> Campaign
                                </label>
                                <span class="form-icon"><i class="bi bi-diagram-3"></i></span>
                                <select class="form-select" id="campaign" name="campaign">
                                    <option value="">Select campaign</option>
                                    @foreach ($options['campaign'] ?? [] as $option)
                                        <option value="{{ $option->option_value }}" @selected(old('campaign') === $option->option_value)>{{ $option->option_value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-icon">
                                <label for="location" class="form-label">
                                    <i class="bi bi-geo-alt"></i> Location
                                </label>
                                <span class="form-icon"><i class="bi bi-geo-alt"></i></span>
                                <select class="form-select" id="location" name="location">
                                    <option value="">Select location</option>
                                    @foreach ($options['location'] ?? [] as $option)
                                        <option value="{{ $option->option_value }}" @selected(old('location') === $option->option_value)>{{ $option->option_value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Status Section -->
                        <div class="col-12">
                            <div class="form-divider"></div>
                            <div class="form-section-header">
                                <i class="bi bi-activity" style="margin-right: 8px; color: #0d6efd;"></i>
                                Status & Attachments
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-icon">
                                <label for="status" class="form-label">
                                    <i class="bi bi-circle-fill"></i> Status
                                </label>
                                <span class="form-icon"><i class="bi bi-graph-up"></i></span>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="">Select status</option>
                                    @foreach (($options['status'] ?? collect())->isNotEmpty() ? $options['status'] : collect(['Available', 'Assigned', 'Under Maintenance', 'Defective']) as $status)
                                        @php($statusValue = is_string($status) ? $status : $status->option_value)
                                        <option value="{{ $statusValue }}" @selected(old('status') === $statusValue)>{{ $statusValue }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-icon">
                                <label for="file_attach" class="form-label">
                                    <i class="bi bi-paperclip"></i> Attachments
                                </label>
                                <span class="form-icon"><i class="bi bi-paperclip"></i></span>
                                <input type="file" class="form-control" id="file_attach" name="file_attach[]" multiple>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="col-12">
                            <div class="form-divider"></div>
                            <div class="form-section-header">
                                <i class="bi bi-chat-left-text" style="margin-right: 8px; color: #0d6efd;"></i>
                                Additional Information
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group-icon">
                                <label for="remarks" class="form-label">
                                    <i class="bi bi-pencil"></i> Remarks
                                </label>
                                <span class="form-icon"><i class="bi bi-pencil"></i></span>
                                <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Enter any additional notes...">{{ old('remarks') }}</textarea>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-12">
                            <div class="btn-group-custom">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i> Save Item
                                </button>
                                <a href="{{ route('inventory.dashboard') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-2"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    @include('layouts.footer')
</body>

</html>