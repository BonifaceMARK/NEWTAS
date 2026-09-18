@extends('layouts.app')

@section('content')
<main id="main" class="main">
<div class="container">
    <h1>Add New Account</h1>
    <form action="{{ route('accounts.store') }}" method="POST">
        @csrf
        @include('accounts.form')
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</main>

@endsection
