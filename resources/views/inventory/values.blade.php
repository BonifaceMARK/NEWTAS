@section('title', env('APP_NAME'))

@include('layouts.title')

<body>
    @include('layouts.header')
    @include('layouts.sidebar')

    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Inventory Options</h5>
                    <p class="text-muted">Save reusable values for inventory item fields.</p>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ route('inventory.values.store') }}" method="POST" class="row g-3 mb-4">
                        @csrf
                        <div class="col-md-4">
                            <label for="option_type" class="form-label">Field</label>
                            <select class="form-select" id="option_type" name="option_type" required>
                                <option value="">Select field</option>
                                @foreach (['category' => 'Category', 'brand' => 'Brand', 'department' => 'Department', 'campaign' => 'Campaign', 'location' => 'Location', 'status' => 'Status'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('option_type') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="option_value" class="form-label">Option</label>
                            <input type="text" class="form-control" id="option_value" name="option_value" value="{{ old('option_value') }}" maxlength="255" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Add Option</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr><th>Field</th><th>Saved Option</th><th class="text-end">Action</th></tr>
                            </thead>
                            <tbody>
                                @forelse ($options->flatten() as $option)
                                    <tr>
                                        <td>{{ ucfirst($option->option_type) }}</td>
                                        <td>{{ $option->option_value }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('inventory.values.delete', $option) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted">No saved options yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layouts.footer')
</body>

</html>