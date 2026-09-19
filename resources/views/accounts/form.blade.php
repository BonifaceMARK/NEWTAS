@extends('layouts.app')

@section('content')
<main id="main" class="main">
<div class="container-fluid" style="background:#f8f9fa; min-height:100vh; font-size:12px;">
    <div class="mx-auto" style="max-width:1200px;">
        <div class="card border-0 shadow-sm rounded-4" style="font-size:12px;">
            <div class="card-header bg-dark text-white rounded-top-4 d-flex justify-content-between align-items-center" style="font-size:12px;">
                <h5 class="mb-0 fw-semibold" style="font-size:12px;">
                    <i class="bi bi-person-plus-fill me-2"></i>
                    {{ isset($account) ? 'Edit Account' : 'Add New Account' }}
                </h5>
                <a href="{{ route('accounts.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3" style="font-size:12px;">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back
                </a>
            </div>

            <div class="card-body p-4" style="font-size:12px;">
                <form action="{{ isset($account) ? route('accounts.update', $account->id) : route('accounts.store') }}" 
                      method="POST" style="font-size:12px;">
                    @csrf
                    @if(isset($account))
                        @method('PUT')
                    @endif

                    <table class="table table-borderless align-middle" style="font-size:12px;">
                        <tbody>
                            <!-- Row 1 -->
                            <tr>
                                <td>
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-person-fill me-2 text-secondary"></i> Full Name
                                    </label>
                                    <input type="text" name="fullname" class="form-control" style="font-size:12px;"
                                           value="{{ old('fullname', $account->fullname ?? '') }}">
                                </td>
                                <td>
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-briefcase-fill me-2 text-secondary"></i> Position
                                    </label>
                                    <input type="text" name="position" class="form-control" style="font-size:12px;"
                                           value="{{ old('position', $account->position ?? '') }}">
                                </td>
                                <td>
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-bar-chart-fill me-2 text-secondary"></i> Level
                                    </label>
                                    <input type="text" name="level" class="form-control" style="font-size:12px;"
                                           value="{{ old('level', $account->level ?? '') }}">
                                </td>
                                <td>
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-people-fill me-2 text-secondary"></i> Team
                                    </label>
                                    <input type="text" name="team" class="form-control" style="font-size:12px;"
                                           value="{{ old('team', $account->team ?? '') }}">
                                </td>
                            </tr>

                            <!-- Row 2 -->
                            <tr>
                                <td>
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-hdd-network me-2 text-secondary"></i> NAS Username
                                    </label>
                                    <input type="text" name="nas_username" class="form-control" style="font-size:12px;"
                                           value="{{ old('nas_username', $account->nas_username ?? '') }}">
                                </td>
                                <td>
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-lock-fill me-2 text-secondary"></i> NAS Password
                                    </label>
                                    <input type="text" name="nas_password" class="form-control" style="font-size:12px;"
                                           value="{{ old('nas_password', $account->nas_password ?? '') }}">
                                </td>
                                <td>
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-person-badge-fill me-2 text-secondary"></i> AD Username
                                    </label>
                                    <input type="text" name="ad_username" class="form-control" style="font-size:12px;"
                                           value="{{ old('ad_username', $account->ad_username ?? '') }}">
                                </td>
                                <td>
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-shield-lock-fill me-2 text-secondary"></i> AD Password
                                    </label>
                                    <input type="text" name="ad_password" class="form-control" style="font-size:12px;"
                                           value="{{ old('ad_password', $account->ad_password ?? '') }}">
                                </td>
                            </tr>

                            <!-- Row 3 -->
                            <tr>
                                <td>
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-globe me-2 text-secondary"></i> AD Domain
                                    </label>
                                    <input type="text" name="ad_domain" class="form-control" style="font-size:12px;"
                                           value="{{ old('ad_domain', $account->ad_domain ?? '') }}">
                                </td>
                                <td>
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-envelope-fill me-2 text-secondary"></i> AD Email
                                    </label>
                                    <input type="email" name="ad_email" class="form-control" style="font-size:12px;"
                                           value="{{ old('ad_email', $account->ad_email ?? '') }}">
                                </td>
                                <td>
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-telephone-fill me-2 text-secondary"></i> SIP Extension
                                    </label>
                                    <input type="text" name="sip_extension" class="form-control" style="font-size:12px;"
                                           value="{{ old('sip_extension', $account->sip_extension ?? '') }}">
                                </td>
                                <td>
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-key-fill me-2 text-secondary"></i> SIP Password
                                    </label>
                                    <input type="text" name="sip_password" class="form-control" style="font-size:12px;"
                                           value="{{ old('sip_password', $account->sip_password ?? '') }}">
                                </td>
                            </tr>

                            <!-- Row 4 -->
                            <tr>
                                <td>
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-person-vcard-fill me-2 text-secondary"></i> Agent Number
                                    </label>
                                    <input type="text" name="agent_number" class="form-control" style="font-size:12px;"
                                           value="{{ old('agent_number', $account->agent_number ?? '') }}">
                                </td>
                                <td>
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-server me-2 text-secondary"></i> SIP Server IP
                                    </label>
                                    <input type="text" name="sip_server_ip" class="form-control" style="font-size:12px;"
                                           value="{{ old('sip_server_ip', $account->sip_server_ip ?? '') }}">
                                </td>
                                <td>
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-building-fill me-2 text-secondary"></i> Campaign
                                    </label>
                                    <select name="campaign" class="form-select" style="font-size:12px;">
                                        <option value="">Choose Campaign</option>
                                        @foreach(['AIA 3','BPI INB','BPI PA','MB PA','MB PL','SSU - IT'] as $camp)
                                            <option value="{{ $camp }}" {{ old('campaign', $account->campaign ?? '') == $camp ? 'selected' : '' }}>
                                                {{ $camp }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-check-circle-fill me-2 text-secondary"></i> Status
                                    </label>
                                    <select name="status" class="form-select" style="font-size:12px;">
                                        @foreach(['Active','Inactive','Disabled','Pending'] as $status)
                                            <option value="{{ $status }}" {{ old('status', $account->status ?? '') == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                           <!-- Row 5 -->
                            <tr>
                                <td colspan="4">
                                    <label class="form-label fw-semibold" style="font-size:12px;">
                                        <i class="bi bi-chat-left-text-fill me-2 text-secondary"></i> Remarks
                                    </label>
                                    <textarea name="remarks" class="form-control" style="font-size:12px;" rows="3">{{ old('remarks', $account->remarks ?? '') }}</textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Footer -->
                    <div class="card-footer bg-light rounded-bottom-4 text-end mt-4">
                        <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm" style="font-size:12px;">
                            <i class="bi bi-save2 me-2"></i> Save
                        </button>
                        <a href="{{ route('accounts.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm" style="font-size:12px;">
                            <i class="bi bi-x-circle me-2"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</main>
@endsection