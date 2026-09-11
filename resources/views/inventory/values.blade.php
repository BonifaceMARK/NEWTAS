

@section('title', 'Inventory Options')
@include('layouts.title')

<style>
    .options-page {
        padding: 1.25rem;
    }

    .options-card {
        overflow: hidden;
        border: 0;
        border-radius: 14px;
    }

    .options-header {
        padding: 1.5rem;
        color: #fff;
        background: linear-gradient(135deg, #123b78, #1769aa);
    }

    .options-header h1 {
        margin: 0;
        font-size: 1.35rem;
    }

    .options-header p {
        margin: .35rem 0 0;
        opacity: .85;
    }

    .options-content {
        padding: 1.5rem;
    }

    .filter-box {
        padding: 1rem;
        background: #f8fafc;
        border: 1px solid #e7edf5;
        border-radius: 12px;
    }

    .options-table-wrapper {
        overflow-x: auto;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    .options-table {
        min-width: 650px;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .options-table th,
    .options-table td {
        padding: .85rem 1rem;
        white-space: nowrap;
        vertical-align: middle;
    }

    .options-table thead th {
        color: #334155;
        background: #f1f5f9;
        font-size: .82rem;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    .options-table tbody tr {
        border-bottom: 4px solid #fff;
    }

    .options-table th:last-child,
    .options-table td:last-child {
        width: 120px;
        text-align: center;
        position: sticky;
        right: 0;
        background: inherit;
        box-shadow: -5px 0 10px rgba(0, 0, 0, .06);
    }

    .field-badge {
        display: inline-block;
        min-width: 90px;
        padding: .35rem .65rem;
        border-radius: 6px;
        font-size: .8rem;
        font-weight: 600;
        text-align: center;
    }

    .field-category td { background: #fff7ed; }
    .field-category .field-badge {
        color: #9a3412;
        background: #fed7aa;
    }

    .field-brand td { background: #eff6ff; }
    .field-brand .field-badge {
        color: #1d4ed8;
        background: #bfdbfe;
    }

    .field-department td { background: #f5f3ff; }
    .field-department .field-badge {
        color: #6d28d9;
        background: #ddd6fe;
    }

    .field-campaign td { background: #ecfdf5; }
    .field-campaign .field-badge {
        color: #166534;
        background: #bbf7d0;
    }

    .field-location td { background: #fefce8; }
    .field-location .field-badge {
        color: #854d0e;
        background: #fde68a;
    }

    .field-status td { background: #fdf2f8; }
    .field-status .field-badge {
        color: #9d174d;
        background: #fbcfe8;
    }

    .options-table tbody tr:hover td {
        filter: brightness(.97);
    }

    .empty-state {
        padding: 2.5rem 1rem !important;
        color: #64748b;
        text-align: center;
        background: #fff !important;
    }

    @media (max-width: 768px) {
        .options-page,
        .options-content {
            padding: 1rem;
        }

        .options-header {
            padding: 1.25rem;
        }
    }
</style>

<body>
    @include('layouts.header')
    @include('layouts.sidebar')

    @php
        $isPaginator = $options instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator
            || $options instanceof \Illuminate\Contracts\Pagination\Paginator;

        $optionRows = $isPaginator
            ? $options->getCollection()
            : collect($options ?? [])->flatten();

        $hasFilter = request()->filled('field');
    @endphp

    <main id="main" class="main">
        <div class="container-fluid options-page">
            <div class="card options-card shadow-sm">

                <div class="options-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h1>
                            <i class="bi bi-sliders me-2"></i>
                            Inventory Options
                        </h1>
                        <p>Manage reusable values for inventory item fields.</p>
                    </div>

                    <span class="badge bg-light text-primary fs-6">
                        {{ $hasFilter ? $optionRows->count() : 0 }} options
                    </span>
                </div>

                <div class="options-content">
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

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ $errors->first() }}

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert">
                            </button>
                        </div>
                    @endif

                    {{-- Add option --}}
                    <form action="{{ route('inventory.values.store') }}"
                          method="POST"
                          class="row g-3 align-items-end mb-4">
                        @csrf

                        <div class="col-12 col-lg-4">
                            <label for="option_type" class="form-label fw-semibold">
                                Field
                            </label>

                            <select id="option_type"
                                    name="option_type"
                                    class="form-select"
                                    required>
                                <option value="">Select field</option>

                                @foreach ([
                                    'category' => 'Category',
                                    'brand' => 'Brand',
                                    'department' => 'Department',
                                    'campaign' => 'Campaign',
                                    'location' => 'Location',
                                    'status' => 'Status'
                                ] as $value => $label)
                                    <option value="{{ $value }}"
                                        @selected(old('option_type') === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-lg-5">
                            <label for="option_value" class="form-label fw-semibold">
                                Option
                            </label>

                            <input type="text"
                                   id="option_value"
                                   name="option_value"
                                   class="form-control"
                                   value="{{ old('option_value') }}"
                                   maxlength="255"
                                   required>
                        </div>

                        <div class="col-12 col-lg-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-plus-lg me-1"></i>
                                Add Option
                            </button>
                        </div>
                    </form>

                    {{-- Server-side filters --}}
                    <form action="{{ route('inventory.values') }}"
                          method="GET"
                          class="filter-box mb-3">
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-4">
                                <label for="filterField" class="form-label fw-semibold">
                                    Select field
                                </label>

                                <select id="filterField"
                                        name="field"
                                        class="form-select"
                                        required>
                                    <option value="">Choose a field to view</option>
                                    <option value="category"
                                        @selected(request('field') === 'category')>
                                        Category
                                    </option>
                                    <option value="brand"
                                        @selected(request('field') === 'brand')>
                                        Brand
                                    </option>
                                    <option value="department"
                                        @selected(request('field') === 'department')>
                                        Department
                                    </option>
                                    <option value="campaign"
                                        @selected(request('field') === 'campaign')>
                                        Campaign
                                    </option>
                                    <option value="location"
                                        @selected(request('field') === 'location')>
                                        Location
                                    </option>
                                    <option value="status"
                                        @selected(request('field') === 'status')>
                                        Status
                                    </option>
                                </select>
                            </div>

                            <div class="col-12 col-md-5">
                                <label for="searchOption" class="form-label fw-semibold">
                                    Search option
                                </label>

                                <input type="search"
                                       id="searchOption"
                                       name="search"
                                       class="form-control"
                                       value="{{ request('search') }}"
                                       placeholder="Search selected field...">
                            </div>

                            <div class="col-12 col-md-3 d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="bi bi-search me-1"></i>
                                    View
                                </button>

                                <a href="{{ route('inventory.values') }}"
                                   class="btn btn-outline-secondary"
                                   title="Reset filters">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </a>
                            </div>
                        </div>
                    </form>

                    {{-- Options table --}}
                    <div class="options-table-wrapper">
                        <table class="table options-table">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Saved Option</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (!$hasFilter)
                                    <tr>
                                        <td colspan="3" class="empty-state">
                                            <i class="bi bi-funnel fs-3 d-block mb-2"></i>
                                            Select a field above to view its options.
                                        </td>
                                    </tr>
                                @elseif ($optionRows->isEmpty())
                                    <tr>
                                        <td colspan="3" class="empty-state">
                                            <i class="bi bi-search fs-3 d-block mb-2"></i>
                                            No options found for the selected field.
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($optionRows as $option)
                                        @php
                                            $field = strtolower($option->option_type);
                                        @endphp

                                        <tr class="field-{{ $field }}">
                                            <td>
                                                <span class="field-badge">
                                                    {{ ucfirst($option->option_type) }}
                                                </span>
                                            </td>

                                            <td>{{ $option->option_value }}</td>

                                            <td>
                                                <form action="{{ route('inventory.values.delete', $option) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Delete this option?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-danger"
                                                            title="Delete option">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if ($isPaginator)
                        <div class="mt-3">
                            {{ $options->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>
</html>
