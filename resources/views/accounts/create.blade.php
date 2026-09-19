@extends('layouts.app')

@section('content')
<main id="main" class="main">
<div class="container-fluid py-5" style="background:#f8f9fa; min-height:100vh;">
    <div class="mx-auto" style="max-width:1200px;">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-dark text-white rounded-top-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">Add New Account</h5>
                <a href="{{ route('accounts.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">Back</a>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('accounts.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @include('accounts.form')

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">Save</button>
                        <a href="{{ route('accounts.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</main>
@endsection
