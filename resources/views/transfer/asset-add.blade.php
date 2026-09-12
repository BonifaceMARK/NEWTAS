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

                    <form action="{{ route('asset.transfer') }}" method="POST" class="row g-3">
                        @csrf

                        <!-- Transfer Identification Section -->
                        <div class="col-12">
                            <div class="form-section-header">
                                <i class="bi bi-tag-fill" style="margin-right: 8px; color: #0d6efd;"></i>
                                Transfer Identification
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-icon">
                                <label for="reference_no" class="form-label">
                                    <i class="bi bi-hash"></i> Reference No.
                                </label>
                                <span class="form-icon"><i class="bi bi-hash"></i></span>
                                <input type="text" class="form-control" id="reference_no" name="reference_no" placeholder="REF-001" value="{{ old('reference_no') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-icon">
                                <label for="date_of_transfer" class="form-label">
                                    <i class="bi bi-calendar-event"></i> Date of Transfer
                                </label>
                                <span class="form-icon"><i class="bi bi-calendar"></i></span>
                                <input type="date" class="form-control" id="date_of_transfer" name="date_of_transfer" value="{{ old('date_of_transfer') }}" required>
                            </div>
                        </div>

                        <!-- Campaign Transfer Section -->
                        <div class="col-12">
                            <div class="form-divider"></div>
                            <div class="form-section-header">
                                <i class="bi bi-diagram-3-fill" style="margin-right: 8px; color: #0d6efd;"></i>
                                Campaign Transfer
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-icon">
                                <label for="from_campaign" class="form-label">
                                    <i class="bi bi-box-arrow-left"></i> Original Campaign/Team
                                </label>
                                <span class="form-icon"><i class="bi bi-building"></i></span>
                                <select class="form-select" id="from_campaign" name="from_campaign" required>
                                    <option value="">Select Campaign/Team</option>
                                    @foreach ($campaignOptions as $option)
                                        <option value="{{ $option->option_value }}" {{ old('from_campaign') == $option->option_value ? 'selected' : '' }}>
                                            {{ $option->option_value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-icon">
                                <label for="to_campaign" class="form-label">
                                    <i class="bi bi-box-arrow-right"></i> Transferred Campaign
                                </label>
                                <span class="form-icon"><i class="bi bi-building"></i></span>
                                <select class="form-select" id="to_campaign" name="to_campaign" required>
                                    <option value="">Select Transferred Campaign</option>
                                    @foreach ($campaignOptions as $option)
                                        <option value="{{ $option->option_value }}" {{ old('to_campaign') == $option->option_value ? 'selected' : '' }}>
                                            {{ $option->option_value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Asset Details Section -->
                        <div class="col-12">
                            <div class="form-divider"></div>
                            <div class="form-section-header">
                                <i class="bi bi-box-seam-fill" style="margin-right: 8px; color: #0d6efd;"></i>
                                Asset Details
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-icon">
                                <label for="asset_type" class="form-label">
                                    <i class="bi bi-tools"></i> Asset Type
                                </label>
                                <span class="form-icon"><i class="bi bi-tools"></i></span>
                                <input type="text" class="form-control" id="asset_type" name="asset_type" placeholder="e.g., Computer, Printer" value="{{ old('asset_type') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-icon">
                                <label for="status" class="form-label">
                                    <i class="bi bi-circle-fill"></i> Status
                                </label>
                                <span class="form-icon"><i class="bi bi-graph-up"></i></span>
                                <select class="form-select" id="status" name="status" required>
                                    @foreach (['Ongoing', 'Completed', 'Cancelled'] as $status)
                                        <option value="{{ $status }}" @selected(old('status', 'Ongoing') === $status)>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="col-12">
                            <div class="form-divider"></div>
                            <div class="form-section-header">
                                <i class="bi bi-chat-left-text-fill" style="margin-right: 8px; color: #0d6efd;"></i>
                                Additional Information
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group-icon">
                                <label for="remarks" class="form-label">
                                    <i class="bi bi-pencil"></i> Reason for Transfer
                                </label>
                                <span class="form-icon"><i class="bi bi-pencil"></i></span>
                                <textarea class="form-control" id="remarks" name="remarks" rows="4" placeholder="Provide detailed reason for transfer...">{{ old('remarks') }}</textarea>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-12">
                            <div class="btn-group-custom">
                                <button type="submit" name="action" value="save" class="btn btn-success">
                                    <i class="bi bi-check-circle me-2"></i> Save Transfer
                                </button>
                                <button type="submit" name="action" value="print" class="btn btn-primary" formtarget="_blank">
                                    <i class="bi bi-printer me-2"></i> Print Transfer
                                </button>
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
