@extends('layouts.app')

@section('content')
<main id="main" class="main">
<div class="container py-5">
    <h1>Reset Password</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('auth.resetPassword', ['id' => $user->id]) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-success">Reset Password</button>
        <a href="{{ route('login') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</main>
@endsection
