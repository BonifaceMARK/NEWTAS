
@section('title', env('APP_NAME'))

@include('layouts.title')

<body>
    @include('layouts.header')
    @include('layouts.sidebar')

    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Fixed Asset Transfer Form</h5>

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
                            <label for="reference_no" class="form-label">Reference No.</label>
                            <input type="text" class="form-control" id="reference_no" name="reference_no" value="{{ old('reference_no', $reference ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="date_of_transfer" class="form-label">Date of Transfer</label>
                            <input type="date" class="form-control" id="date_of_transfer" name="date_of_transfer" value="{{ old('date_of_transfer', $date ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
    <label for="from_campaign" class="form-label">Original Campaign/Team</label>
    <select class="form-select" id="from_campaign" name="from_campaign" required>
        <option value="">Select Campaign/Team</option>
        @foreach ($campaignOptions as $option)
            <option value="{{ $option->option_value }}" 
                {{ old('from_campaign', $fromCampaign ?? '') == $option->option_value ? 'selected' : '' }}>
                {{ $option->option_value }}
            </option>
        @endforeach
    </select>
</div>


                      <div class="col-md-6">
    <label for="to_campaign" class="form-label">Transferred Campaign</label>
    <select class="form-select" id="to_campaign" name="to_campaign" required>
        <option value="">Select Transferred Campaign</option>
        @foreach ($campaignOptions as $option)
            <option value="{{ $option->option_value }}" 
                {{ old('to_campaign', $toCampaign ?? '') == $option->option_value ? 'selected' : '' }}>
                {{ $option->option_value }}
            </option>
        @endforeach
    </select>
</div>


                        <div class="col-md-6">
                            <label for="asset_type" class="form-label">Asset Type</label>
                            <input type="text" class="form-control" id="asset_type" name="asset_type" value="{{ old('asset_type', $assetType ?? '') }}" required>
                        </div>

                        <div class="col-12">
                            <label for="remarks" class="form-label">Reason for Transfer</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3">{{ old('remarks', $remarks ?? '') }}</textarea>
                        </div>

                        <div class="col-12">
                            <!-- Save button (same tab) -->
                            <button type="submit" name="action" value="save" class="btn btn-success">
                                Save Transfer
                            </button>

                            <!-- Print button (new tab) -->
                            <button type="submit" name="action" value="print" class="btn btn-primary" formtarget="_blank">
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
