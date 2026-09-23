@section('title', env('APP_NAME'))

@include('layouts.title')

<style>
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .card-body {
        padding: 24px;
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

    .stat-card {
        border-radius: 10px;
        padding: 20px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .stat-card i {
        position: absolute;
        right: 20px;
        top: 15px;
        font-size: 40px;
        opacity: .3;
    }

    .stat-card h6 {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .stat-card h3 {
        font-weight: bold;
        margin: 0;
    }

    .table thead th {
        background: #f8f9fa;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #dee2e6;
        white-space: nowrap;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-action {
        margin-right: 4px;
    }

    .badge {
        padding: 6px 10px;
        font-size: 11px;
    }

    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 10px;
        flex-wrap: wrap;
    }

    .search-box {
        min-width: 300px;
    }

    .search-box input {
        border-radius: 6px;
    }

    .pagination {
        margin-bottom: 0;
    }
</style>

<body>

@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">

    <section class="section">

        <div class="section-title">
            <i class="bi bi-boxes"></i>
            Stock Inventory
        </div>

        <p class="form-section-subtitle">
            Manage inventory items, stock levels, and warehouse supplies.
        </p>

        {{-- DASHBOARD CARDS --}}
        <div class="row mb-4">

            <div class="col-md-3">
                <div class="stat-card bg-primary">
                    <h6>Total Stock Items</h6>
                    <h3>{{ $totalItems ?? 0 }}</h3>
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card bg-success">
                    <h6>Total Quantity</h6>
                    <h3>{{ $totalStock ?? 0 }}</h3>
                    <i class="bi bi-stack"></i>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card bg-warning">
                    <h6>Low Stock</h6>
                    <h3>{{ $lowStock ?? 0 }}</h3>
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card bg-danger">
                    <h6>Out Of Stock</h6>
                    <h3>{{ $outOfStock ?? 0 }}</h3>
                    <i class="bi bi-x-circle"></i>
                </div>
            </div>

        </div>

        <div class="card">

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- TOOLBAR --}}
                <div class="toolbar">

                    <div class="search-box">

                        {{ route('stock.index') }}

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>

                                <input type="text"
                                       class="form-control"
                                       name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Search item name...">

                            </div>

                        </form>

                    </div>

                    <div>
<a href="{{ route('stock.create') }}"
   classbi-plus-circle"></i>
    Add Stock Item

</a>

                    </div>

                </div>

                {{-- TABLE --}}
                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>
                                <th>ID</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Location</th>
                                <th>Reorder Level</th>
                                <th>Status</th>
                                <th width="220">Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                        @forelse($stocks as $stock)

                            <tr>

                                <td>{{ $stock->stock_id }}</td>

                                <td>
                                    <strong>{{ $stock->item_name }}</strong>
                                </td>

                                <td>{{ $stock->category ?? '-' }}</td>

                                <td>{{ $stock->brand ?? '-' }}</td>

                                <td>{{ $stock->model ?? '-' }}</td>

                                <td>
                                    <strong>{{ number_format($stock->quantity) }}</strong>
                                </td>

                                <td>{{ strtoupper($stock->unit) }}</td>

                                <td>{{ $stock->location ?? '-' }}</td>

                                <td>{{ $stock->reorder_level }}</td>

                                <td>

                                    @if($stock->quantity <= 0)

                                        <span class="badge bg-danger">
                                            Out of Stock
                                        </span>

                                    @elseif($stock->quantity <= $stock->reorder_level)

                                        <span class="badge bg-warning text-dark">
                                            Low Stock
                                        </span>

                                    @else

                                        <span class="badge bg-success">
                                            Available
                                        </span>

                                    @endif

                                </td>

                       <td>

    <a href="{{ route('stock.show', $stock->stock_id) }}"
       class="btn btn-sm btn-info btn-action"
       title="View">

        <i class="bi bi-eye"></i>

    </a>

  <a href="{{ route('stock.edit', $stock->stock_id) }}"
       class="btn btn-sm btn-success btn-action"
       title="Stock edit">

        <i class="bi bi-pencil-square"></i>

    </a>

     <a href="{{ route('stock.edit', $stock->stock_id) }}"
       class="btn btn-sm btn-secondary btn-action"
       title="Stock Out">

        <i class="bi bi-dash-circle"></i>

    </a>

     <a href="{{ route('stock.show', $stock->stock_id) }}"
          method="POST"
          class="d-inline">

        @csrf
        @method('DELETE')

        <button type="submit"
                class="btn btn-sm btn-danger"
                onclick="return confirm('Delete this stock item?')">

            <i class="bi bi-trash"></i>

        </button>

    </form>

</td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="11" class="text-center py-4 text-muted">

                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>

                                    No stock items found.

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- PAGINATION --}}
                @if(method_exists($stocks, 'links'))
                    <div class="d-flex justify-content-end mt-3">
                        {{ $stocks->links() }}
                    </div>
                @endif

            </div>

        </div>

    </section>

</main>

@include('layouts.footer')

</body>
</html>