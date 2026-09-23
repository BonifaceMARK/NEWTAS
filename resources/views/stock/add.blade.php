@extends('layouts.app')

@section('title', 'Add Stock Item')

@section('content')
 
<style>
    .form-group-icon {
        position: relative;
    }

    .form-group-icon .form-icon {
        position: absolute;
        left: 12px;
        top: 38px;
        color: #6c757d;
        font-size: 16px;
        pointer-events: none;
    }

    .form-control,
    .form-select {
        padding-left: 38px !important;
        border: 1px solid #e0e0e0 !important;
        border-radius: 6px;
        transition: all 0.3s ease;
        background-color: #f9f9f9;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd !important;
        background-color: #fff;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .1);
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-label i {
        color: #0d6efd;
        font-size: 14px;
    }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,.08);
    }

    .card-body {
        padding: 32px;
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
    }

    .form-section-subtitle {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 24px;
    }

    .form-divider {
        margin: 24px 0;
        border-top: 1px solid #e0e0e0;
    }

    .form-section-header {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0f0f0;
    }

    .btn-group-custom {
        display: flex;
        gap: 12px;
        margin-top: 32px;
    }

    .btn {
        border-radius: 6px;
        font-weight: 600;
        padding: 10px 25px;
    }
</style>

<main id="main" class="main">

    <section class="section">

        <div class="card">

            <div class="card-body">

                <div class="section-title">
                    <i class="bi bi-boxes"></i>
                    Add Stock Item
                </div>

                <p class="form-section-subtitle">
                    Create a new stock inventory item.
                </p>

                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
<form action="{{ route('stock.store') }}"
method="POST"
enctype="multipart/form-data"
class="row g-3">
                    @csrf

                    <div class="row g-3">

                        {{-- ITEM INFORMATION --}}
                        <div class="col-12">
                            <div class="form-section-header">
                                <i class="bi bi-box-seam text-primary"></i>
                                Item Information
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-icon">

                                <label class="form-label">
                                    <i class="bi bi-box"></i>
                                    Item Name
                                </label>

                                <span class="form-icon">
                                    <i class="bi bi-box"></i>
                                </span>

                                <input type="text"
                                       class="form-control"
                                       name="item_name"
                                       value="{{ old('item_name') }}"
                                       placeholder="Enter Item Name"
                                       required>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group-icon">

                                <label class="form-label">
                                    <i class="bi bi-bookmarks"></i>
                                    Category
                                </label>

                                <span class="form-icon">
                                    <i class="bi bi-bookmarks"></i>
                                </span>

                                <select name="category" class="form-select">

                                    <option value="">Select Category</option>

                                    @foreach ($options['category'] ?? [] as $option)

                                        <option value="{{ $option->option_value }}"
                                            @selected(old('category') == $option->option_value)>
                                            {{ $option->option_value }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group-icon">

                                <label class="form-label">
                                    <i class="bi bi-award"></i>
                                    Brand
                                </label>

                                <span class="form-icon">
                                    <i class="bi bi-award"></i>
                                </span>

                                <select name="brand" class="form-select">

                                    <option value="">Select Brand</option>

                                    @foreach ($options['brand'] ?? [] as $option)

                                        <option value="{{ $option->option_value }}"
                                            @selected(old('brand') == $option->option_value)>
                                            {{ $option->option_value }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>
                        </div>

                        {{-- STOCK DETAILS --}}

                        <div class="col-12">
                            <div class="form-divider"></div>

                            <div class="form-section-header">
                                <i class="bi bi-stack text-primary"></i>
                                Stock Information
                            </div>
                        </div>

                        <div class="col-md-3">

                            <div class="form-group-icon">

                                <label class="form-label">
                                    <i class="bi bi-123"></i>
                                    Quantity
                                </label>

                                <span class="form-icon">
                                    <i class="bi bi-123"></i>
                                </span>

                                <input type="number"
                                       name="quantity"
                                       min="0"
                                       value="{{ old('quantity', 0) }}"
                                       class="form-control"
                                       required>

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group-icon">

                                <label class="form-label">
                                    <i class="bi bi-rulers"></i>
                                    Unit
                                </label>

                                <span class="form-icon">
                                    <i class="bi bi-rulers"></i>
                                </span>

                                <select name="unit" class="form-select">

                                    <option value="pcs">PCS</option>
                                    <option value="box">BOX</option>
                                    <option value="pack">PACK</option>
                                    <option value="ream">REAM</option>
                                    <option value="meter">METER</option>
                                    <option value="roll">ROLL</option>
                                    <option value="set">SET</option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group-icon">

                                <label class="form-label">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Reorder Level
                                </label>

                                <span class="form-icon">
                                    <i class="bi bi-exclamation-triangle"></i>
                                </span>

                                <input type="number"
                                       name="reorder_level"
                                       min="0"
                                       value="{{ old('reorder_level',5) }}"
                                       class="form-control">

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group-icon">

                                <label class="form-label">
                                    <i class="bi bi-geo-alt"></i>
                                    Location
                                </label>

                                <span class="form-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </span>

                                <select name="location" class="form-select">

                                    <option value="">
                                        Select Location
                                    </option>

                                    @foreach ($options['location'] ?? [] as $option)

                                        <option value="{{ $option->option_value }}"
                                            @selected(old('location') == $option->option_value)>
                                            {{ $option->option_value }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                        {{-- ADDITIONAL INFORMATION --}}

                        <div class="col-12">

                            <div class="form-divider"></div>

                            <div class="form-section-header">
                                <i class="bi bi-info-circle text-primary"></i>
                                Additional Information
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group-icon">

                                <label class="form-label">
                                    <i class="bi bi-cpu"></i>
                                    Model
                                </label>

                                <span class="form-icon">
                                    <i class="bi bi-cpu"></i>
                                </span>

                                <input type="text"
                                       name="model"
                                       class="form-control"
                                       value="{{ old('model') }}"
                                       placeholder="Enter Model">

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group-icon">

                                <label class="form-label">
                                    <i class="bi bi-paperclip"></i>
                                    Attachments
                                </label>

                                <span class="form-icon">
                                    <i class="bi bi-paperclip"></i>
                                </span>

                                <input type="file"
                                       name="file_attach[]"
                                       class="form-control"
                                       multiple>

                            </div>

                        </div>

                        <div class="col-12">

                            <div class="form-group-icon">

                                <label class="form-label">
                                    <i class="bi bi-chat-left-text"></i>
                                    Remarks
                                </label>

                                <span class="form-icon">
                                    <i class="bi bi-chat-left-text"></i>
                                </span>

                                <textarea name="remarks"
                                          rows="4"
                                          class="form-control"
                                          placeholder="Enter remarks">{{ old('remarks') }}</textarea>

                            </div>

                        </div>

                        {{-- BUTTONS --}}

                        <div class="col-12">

                            <div class="btn-group-custom">

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i>
                                    Save Stock Item
                                </button>

                                <a href="{{ route('stock.index') }}"
                                   class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i>
                                    Cancel
                                </a>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </section>

</main>

@endsection