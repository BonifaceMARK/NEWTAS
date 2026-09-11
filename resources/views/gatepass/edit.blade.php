
@section('title', 'Edit Gatepass')
@include('layouts.title')

<style>
    .gatepass-edit-page { padding: 1.25rem; }
    .gatepass-edit-card { max-width: 1000px; margin: 0 auto; overflow: hidden; border: 0; border-radius: 14px; }
    .gatepass-edit-header { padding: 1.5rem; color: #fff; background: linear-gradient(135deg, #123b78, #1769aa); }
    .gatepass-edit-header h1 { margin: 0; font-size: 1.35rem; }
    .gatepass-edit-header p { margin: .35rem 0 0; opacity: .85; }
    .gatepass-edit-body { padding: 1.5rem; }
    .form-label { color: #334155; font-weight: 600; }
    .required::after { content: ' *'; color: #dc3545; }
    @media (max-width: 768px) { .gatepass-edit-page, .gatepass-edit-body { padding: 1rem; } .gatepass-edit-header { padding: 1.1rem; } }
</style>

<body>
    @include('layouts.header')
    @include('layouts.sidebar')

    <main id="main" class="main">
        <div class="container-fluid gatepass-edit-page">
            <div class="card gatepass-edit-card shadow-sm">
                <div class="gatepass-edit-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h1><i class="bi bi-pencil-square me-2"></i>Edit Gatepass #{{ $gatepass->id }}</h1>
                        <p>Update the saved gatepass information.</p>
                    </div>
                    <a href="{{ route('inventory.gatepass.show', $gatepass->id) }}" class="btn btn-light text-primary">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                </div>

                <div class="gatepass-edit-body">
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

                    <form action="{{ route('inventory.gatepass.update', $gatepass->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="owner" class="form-label">Owner</label>
                                <input type="text" id="owner" name="owner" class="form-control" maxlength="255" value="{{ old('owner', $gatepass->owner) }}">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" id="contact" name="contact" class="form-control" maxlength="255" value="{{ old('contact', $gatepass->contact) }}">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="bearer" class="form-label">Bearer</label>
                                <input type="text" id="bearer" name="bearer" class="form-control" maxlength="255" value="{{ old('bearer', $gatepass->bearer) }}">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="site_floor" class="form-label">Site / Floor</label>
                                <input type="text" id="site_floor" name="site_floor" class="form-control" maxlength="255" value="{{ old('site_floor', $gatepass->site_floor) }}">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="date" class="form-label required">Date</label>
                                <input type="date" id="date" name="date" class="form-control" value="{{ old('date', $gatepass->date ? \Carbon\Carbon::parse($gatepass->date)->format('Y-m-d') : '') }}" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="time" class="form-label required">Time</label>
                                <input type="time" id="time" name="time" class="form-control" value="{{ old('time', $gatepass->time ? \Carbon\Carbon::parse($gatepass->time)->format('H:i') : '') }}" required>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="quantity" class="form-label required">Quantity</label>
                                <input type="number" id="quantity" name="quantity" class="form-control" min="1" value="{{ old('quantity', $gatepass->quantity) }}" required>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="unit" class="form-label">Unit</label>
                                <input type="text" id="unit" name="unit" class="form-control" maxlength="50" value="{{ old('unit', $gatepass->unit) }}">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Inventory Item</label>
                                <input type="text" class="form-control" value="{{ $gatepass->inventoryItem?->item_name ?? 'N/A' }}" disabled>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="status" class="form-label required">Status</label>
                                <select id="status" name="status" class="form-select" required>
                                    @foreach (['Ongoing', 'Completed', 'Cancelled'] as $status)
                                        <option value="{{ $status }}" @selected(old('status', $gatepass->status ?: 'Ongoing') === $status)>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" class="form-control" rows="3" maxlength="500">{{ old('description', $gatepass->description) }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea id="remarks" name="remarks" class="form-control" rows="3" maxlength="1000">{{ old('remarks', $gatepass->remarks) }}</textarea>
                            </div>
                            <div class="col-12 d-flex flex-wrap justify-content-end gap-2 mt-3">
                                <a href="{{ route('inventory.gatepass.show', $gatepass->id) }}" class="btn btn-outline-secondary">Cancel</a>
                                <a href="{{ route('inventory.gatepass.print', $gatepass->id) }}" target="_blank" class="btn btn-outline-primary"><i class="bi bi-printer me-1"></i>Print</a>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save Changes</button>
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
