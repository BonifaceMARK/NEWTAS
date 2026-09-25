@extends('layouts.app')

@section('title', 'Bulk Create Workstations')

@section('content')

    <main id="main" class="main">

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="row mb-3">
       
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="d-flex justify-content-between align-items-center mb-3">
    <label for="floor_id" class="mb-0">
        Floor
    </label>

    <a href="{{ route('floors.create') }}"
       class="btn btnrcle"></i>
        Add Floor
    </a>
</div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Generate Workstations</h3>
        </div>

     <form action="{{ route('workstations.bulkStore') }}" method="POST">
    @csrf

            <div class="card-body">

                {{-- Floor --}}
                <div class="form-group mb-3">
                    <label for="floor_id">Floor</label>

                    <select name="floor_id"
                            id="floor_id"
                            class="form-control"
                            required>
                        <option value="">-- Select Floor --</option>

                        @foreach($floors as $floor)
                            <option value="{{ $floor->id }}">
                                {{ $floor->floor_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Prefix --}}
                <div class="form-group mb-3">
                    <label for="prefix">
                        Workstation Prefix
                    </label>

                    <input type="text"
                           name="prefix"
                           id="prefix"
                           class="form-control"
                           placeholder="Example: WS-2F"
                           value="{{ old('prefix') }}"
                           required>
                </div>

                {{-- Quantity --}}
                <div class="form-group mb-3">
                    <label for="quantity">
                        Number of Workstations
                    </label>

                    <input type="number"
                           name="quantity"
                           id="quantity"
                           class="form-control"
                           min="1"
                           max="500"
                           value="{{ old('quantity', 82) }}"
                           required>
                </div>

                <div class="alert alert-info">
                    <strong>Example Output:</strong><br>
                    WS-2F-001<br>
                    WS-2F-002<br>
                    WS-2F-003<br>
                    ... up to the specified quantity
                </div>

            </div>

          <div class="card-footer">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i>
        Generate Workstations
    </button>

    <a href="{{ route('workstations.index') }}" class="btn btn-secondary">
        Cancel
    </a>
</div>
        </form>
    </div>

</div>
</main>
@endsection