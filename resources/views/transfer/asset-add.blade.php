@section('title', env('APP_NAME'))

@include('layouts.title')

<body>
    @include('layouts.header')
    @include('layouts.sidebar')

    <main id="main" class="main">
        <section class="section">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-center fw-bold mb-4">Fixed Asset Transfer Form</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('asset.transfer') }}" method="POST" class="row g-3">
                        @csrf

                        <div class="col-md-6">
                            <label for="reference_no" class="form-label fw-semibold">Reference No.</label>
                            <input type="text" class="form-control border-dark" id="reference_no" name="reference_no" placeholder="Enter reference number" value="{{ old('reference_no') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="date_of_transfer" class="form-label fw-semibold">Date of Transfer</label>
                            <input type="date" class="form-control border-dark" id="date_of_transfer" name="date_of_transfer" value="{{ old('date_of_transfer') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="from_campaign" class="form-label fw-semibold">Original Campaign/Team</label>
                            <select class="form-select border-dark" id="from_campaign" name="from_campaign" required>
                                <option value="">Select Campaign/Team</option>
                                @foreach ($campaignOptions as $option)
                                    <option value="{{ $option->option_value }}" {{ old('from_campaign') == $option->option_value ? 'selected' : '' }}>
                                        {{ $option->option_value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="to_campaign" class="form-label fw-semibold">Transferred Campaign</label>
                            <select class="form-select border-dark" id="to_campaign" name="to_campaign" required>
                                <option value="">Select Transferred Campaign</option>
                                @foreach ($campaignOptions as $option)
                                    <option value="{{ $option->option_value }}" {{ old('to_campaign') == $option->option_value ? 'selected' : '' }}>
                                        {{ $option->option_value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="asset_type" class="form-label fw-semibold">Asset Type</label>
                            <input type="text" class="form-control border-dark" id="asset_type" name="asset_type" placeholder="Enter asset type" value="{{ old('asset_type') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select class="form-select border-dark" id="status" name="status" required>
                                @foreach (['Ongoing', 'Completed', 'Cancelled'] as $status)
                                    <option value="{{ $status }}" @selected(old('status', 'Ongoing') === $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="remarks" class="form-label fw-semibold">Reason for Transfer</label>
                            <textarea class="form-control border-dark" id="remarks" name="remarks" rows="3" placeholder="Provide reason">{{ old('remarks') }}</textarea>
                        </div>

                        <div class="col-12 text-center mt-3">
                            <button type="submit" name="action" value="save" class="btn btn-success px-4 me-2">
                                Save Transfer
                            </button>
                            <button type="submit" name="action" value="print" class="btn btn-primary px-4" formtarget="_blank">
                                Print Transfer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    @include('layouts.footer')
</body>
</html>
