@extends('layouts.app')

@section('title', 'Create Floor')

@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>Create Floor</h1>
</div>

<section class="section">

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                Add New Floor
            </h5>
        </div>
<form action="{{ route('floor.store') }}" method="POST">
    @csrf

            <div class="card-body">

               <div class="row g-3 mb-3">
    <div class="col-md-4">
        <label for="floor_no" class="form-label">Floor Number</label>
        <input type="text"
               id="floor_no"
               name="floor_no"
               class="form-control"
               required>
    </div>

    <div class="col-md-4">
        <label for="floor_name" class="form-label">Floor Name</label>
        <input type="text"
               id="floor_name"
               name="floor_name"
               class="form-control"
               required>
    </div>

    <div class="col-md-4">
        <label for="max_workstations" class="form-label">Max Workstations</label>
        <input type="number"
               id="max_workstations"
               name="max_workstations"
               class="form-control"
               min="0">
    </div>
</div>

               

               

                <div class="mb-3">
                    <label>Remarks</label>
                    <textarea name="remarks"
                              class="form-control"
                              rows="3"></textarea>
                </div>

            </div>

            <div class="card-footer">
                <button type="submit"
                        class="btn btn-primary">
                    Save Floor
                </button>

                  
            </div>

        </form>

    </div>

</section>

</main>

@endsection