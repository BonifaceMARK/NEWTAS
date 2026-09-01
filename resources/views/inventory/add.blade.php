@section('title', env('APP_NAME'))

@include('layouts.title')

<body>
    @include('layouts.header')
    @include('layouts.sidebar')

    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Inventory Item</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf

                        <div class="col-md-6">
                            <label for="asset_tag" class="form-label">Asset Tag</label>
                            <input type="text" class="form-control" id="asset_tag" name="asset_tag" value="{{ old('asset_tag') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="item_name" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="item_name" name="item_name" value="{{ old('item_name') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Select category</option>
                                @foreach ($options['category'] ?? [] as $option)
                                    <option value="{{ $option->option_value }}" @selected(old('category') === $option->option_value)>{{ $option->option_value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="brand" class="form-label">Brand</label>
                            <select class="form-select" id="brand" name="brand">
                                <option value="">Select brand</option>
                                @foreach ($options['brand'] ?? [] as $option)
                                    <option value="{{ $option->option_value }}" @selected(old('brand') === $option->option_value)>{{ $option->option_value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="model" class="form-label">Model</label>
                            <input type="text" class="form-control" id="model" name="model" value="{{ old('model') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{ old('serial_number') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="purchase_date" class="form-label">Purchase Date</label>
                            <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="warranty_expiry" class="form-label">Warranty Expiry</label>
                            <input type="date" class="form-control" id="warranty_expiry" name="warranty_expiry" value="{{ old('warranty_expiry') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="assigned_to" class="form-label">Assigned To</label>
                            <input type="text" class="form-control" id="assigned_to" name="assigned_to" value="{{ old('assigned_to') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="department" class="form-label">Department</label>
                            <select class="form-select" id="department" name="department">
                                <option value="">Select department</option>
                                @foreach ($options['department'] ?? [] as $option)
                                    <option value="{{ $option->option_value }}" @selected(old('department') === $option->option_value)>{{ $option->option_value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="campaign" class="form-label">Campaign</label>
                            <select class="form-select" id="campaign" name="campaign">
                                <option value="">Select campaign</option>
                                @foreach ($options['campaign'] ?? [] as $option)
                                    <option value="{{ $option->option_value }}" @selected(old('campaign') === $option->option_value)>{{ $option->option_value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label">Location</label>
                            <select class="form-select" id="location" name="location">
                                <option value="">Select location</option>
                                @foreach ($options['location'] ?? [] as $option)
                                    <option value="{{ $option->option_value }}" @selected(old('location') === $option->option_value)>{{ $option->option_value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Select status</option>
                                @foreach (($options['status'] ?? collect())->isNotEmpty() ? $options['status'] : collect(['Available', 'Assigned', 'Under Maintenance', 'Defective']) as $status)
                                    @php($statusValue = is_string($status) ? $status : $status->option_value)
                                    <option value="{{ $statusValue }}" @selected(old('status') === $statusValue)>{{ $statusValue }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="file_attach" class="form-label">Attachments</label>
                            <input type="file" class="form-control" id="file_attach" name="file_attach[]" multiple>
                        </div>
                        <div class="col-12">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3">{{ old('remarks') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Save Item</button>
                            <a href="{{ route('inventory.dashboard') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    @include('layouts.footer')
</body>

</html>