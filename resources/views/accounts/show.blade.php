@extends('layouts.app')

@section('content')
<main id="main" class="main">
<div class="container">
    <h1>Account Details</h1>
    <ul class="list-group">
        <li class="list-group-item"><strong>NAS Username:</strong> {{ $account->nas_username }}</li>
        <li class="list-group-item"><strong>AD Username:</strong> {{ $account->ad_username }}</li>
        <li class="list-group-item"><strong>SIP Extension:</strong> {{ $account->sip_extension }}</li>
        <li class="list-group-item"><strong>Agent #:</strong> {{ $account->agent_number }}</li>
        <li class="list-group-item"><strong>Campaign:</strong> {{ $account->campaign }}</li>
        <li class="list-group-item"><strong>Status:</strong> {{ $account->status }}</li>
        <li class="list-group-item"><strong>Remarks:</strong> {{ $account->remarks }}</li>
    </ul>
    <a href="{{ route('accounts.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
</main>
@endsection
