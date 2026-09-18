@extends('layouts.app')

@section('content')
<main id="main" class="main">
<div class="mb-3">
    <label>NAS Username</label>
    <input type="text" name="nas_username" class="form-control" value="{{ old('nas_username', $account->nas_username ?? '') }}">
</div>

<div class="mb-3">
    <label>NAS Password</label>
    <input type="text" name="nas_password" class="form-control" value="{{ old('nas_password', $account->nas_password ?? '') }}">
</div>

<div class="mb-3">
    <label>AD Username</label>
    <input type="text" name="ad_username" class="form-control" value="{{ old('ad_username', $account->ad_username ?? '') }}">
</div>

<div class="mb-3">
    <label>AD Password</label>
    <input type="text" name="ad_password" class="form-control" value="{{ old('ad_password', $account->ad_password ?? '') }}">
</div>

<div class="mb-3">
    <label>AD Domain</label>
    <input type="text" name="ad_domain" class="form-control" value="{{ old('ad_domain', $account->ad_domain ?? '') }}">
</div>

<div class="mb-3">
    <label>AD Email</label>
    <input type="email" name="ad_email" class="form-control" value="{{ old('ad_email', $account->ad_email ?? '') }}">
</div>

<div class="mb-3">
    <label>SIP Extension</label>
    <input type="text" name="sip_extension" class="form-control" value="{{ old('sip_extension', $account->sip_extension ?? '') }}">
</div>

<div class="mb-3">
    <label>SIP Password</label>
    <input type="text" name="sip_password" class="form-control" value="{{ old('sip_password', $account->sip_password ?? '') }}">
</div>

<div class="mb-3">
    <label>Agent Number</label>
    <input type="text" name="agent_number" class="form-control" value="{{ old('agent_number', $account->agent_number ?? '') }}">
</div>

<div class="mb-3">
    <label>SIP Server IP</label>
    <input type="text" name="sip_server_ip" class="form-control" value="{{ old('sip_server_ip', $account->sip_server_ip ?? '') }}">
</div>

<div class="mb-3">
    <label>Campaign</label>
    <input type="text" name="campaign" class="form-control" value="{{ old('campaign', $account->campaign ?? '') }}">
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        @foreach(['Active','Inactive','Disabled','Pending'] as $status)
            <option value="{{ $status }}" {{ old('status', $account->status ?? '') == $status ? 'selected' : '' }}>
                {{ $status }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Remarks</label>
    <textarea name="remarks" class="form-control">{{ old('remarks', $account->remarks ?? '') }}</textarea>
</div>
</main>
@endsection