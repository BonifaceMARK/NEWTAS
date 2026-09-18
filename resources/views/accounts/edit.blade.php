@extends('layouts.app')

@section('content')
<main id="main" class="main">
<div class="container">
    <h1>Edit Account</h1>
    <form action="{{ route('accounts.update', $account->id) }}" method="POST">
        @csrf @method('PUT')
        @include('accounts.form', ['account' => $account])
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</main>
@endsection
