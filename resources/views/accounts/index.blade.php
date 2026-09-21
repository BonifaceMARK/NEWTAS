@extends('layouts.app')

@section('content')
<main id="main" class="main-fluid">
<div class="container-fluid" style="background:#f9f9f9; min-height:100vh; font-size:12px;">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
    <!-- Left side: Title -->
    <h1 class="fw-bold text-dark mb-3 mb-md-0" style="font-size:12px;">Accounts Inventory</h1>

    <!-- Right side: Actions -->
    <div class="d-flex gap-2">
        <!-- Trigger Import Modal -->
        <button type="button" class="btn btn-dark rounded-pill px-4 py-2 shadow-sm" style="font-size:12px;"
                data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="bi bi-upload me-2"></i> Import Bulk Data
        </button>

        <!-- Add New Account -->
        <a href="{{ route('accounts.create') }}" 
           class="btn btn-dark px-4 py-2 rounded-pill shadow-sm" style="font-size:12px;">
           <i class="bi bi-plus-circle me-2"></i> Add New Account
        </a>
    </div>
</div>

    <!-- Success/Error Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert" style="font-size:12px;">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert" style="font-size:12px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter Form -->
    <form method="GET" action="{{ route('accounts.index') }}" class="mb-3 d-flex flex-wrap align-items-center gap-3" style="font-size:12px;">
        <div>
            <label for="limit" class="me-2 fw-semibold" style="font-size:12px;">Show:</label>
            <select name="limit" id="limit" class="form-select w-auto" style="font-size:12px;" onchange="this.form.submit()">
                <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
                <option value="50" {{ $limit == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ $limit == 100 ? 'selected' : '' }}>100</option>
                <option value="all" {{ $limit === 'all' ? 'selected' : '' }}>All</option>
            </select>
        </div>

        <div>
            <label for="campaign" class="me-2 fw-semibold" style="font-size:12px;">Campaign:</label>
            <select name="campaign" id="campaign" class="form-select w-auto" style="font-size:12px;" onchange="this.form.submit()">
                <option value="">All Campaigns</option>
                <option value="AIA 3" {{ request('campaign') == 'AIA 3' ? 'selected' : '' }}>AIA 3</option>
                <option value="BPI INB" {{ request('campaign') == 'BPI INB' ? 'selected' : '' }}>BPI INB</option>
                <option value="BPI PA" {{ request('campaign') == 'BPI PA' ? 'selected' : '' }}>BPI PA</option>
                <option value="MB PA" {{ request('campaign') == 'MB PA' ? 'selected' : '' }}>MB PA</option>
                <option value="MB PL" {{ request('campaign') == 'MB PL' ? 'selected' : '' }}>MB PL</option>
                <option value="SSU - IT" {{ request('campaign') == 'SSU - IT' ? 'selected' : '' }}>SSU - IT</option>
            </select>
        </div>
    </form>

    <!-- Accounts Table -->
    <div class="card border-0 shadow-sm rounded-4" style="font-size:12px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size:12px;">
                   <thead class="table-light">
    <tr>
        <th><i class="bi bi-person-fill me-2 text-secondary"></i> Full Name</th>
        <th><i class="bi bi-people-fill me-2 text-secondary"></i> Team</th>
        <th><i class="bi bi-telephone-fill me-2 text-secondary"></i> SIP Extension</th>
        <th><i class="bi bi-person-vcard-fill me-2 text-secondary"></i> Agent #</th>
        <th><i class="bi bi-building-fill me-2 text-secondary"></i> Campaign</th>
        <th><i class="bi bi-check-circle-fill me-2 text-secondary"></i> Status</th>
        <th class="text-center"><i class="bi bi-gear-fill me-2 text-secondary"></i> Actions</th>
    </tr>
</thead>

                    <tbody>
                        @forelse($accounts as $account)
                        <tr>
                            <td>{{ $account->fullname }}</td>
                            <td>{{ $account->team }}</td>
                            <td>{{ $account->sip_extension }}</td>
                            <td>{{ $account->agent_number }}</td>
                            <td>{{ $account->campaign }}</td>
                            <td>
                              <span class="badge rounded-pill 
    {{ $account->status === 'Active' ? 'bg-success' : 
       ($account->status === 'Pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
    @if($account->status === 'Active')
        <i class="bi bi-check-circle-fill me-1"></i>
    @elseif($account->status === 'Pending')
        <i class="bi bi-hourglass-split me-1"></i>
    @else
        <i class="bi bi-x-circle-fill me-1"></i>
    @endif
    {{ $account->status }}
</span>

                            </td>
                            <td class="text-center">
                                <a href="{{ route('accounts.show', $account->id) }}" 
                                   class="btn btn-outline-dark btn-sm rounded-pill px-3" style="font-size:12px;">
                                   <i class="bi bi-eye me-1"></i> View
                                </a>
                                <a href="{{ route('accounts.edit', $account->id) }}" 
                                   class="btn btn-outline-secondary btn-sm rounded-pill px-3" style="font-size:12px;">
                                   <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>
                                <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                        class="btn btn-outline-danger btn-sm rounded-pill px-3" style="font-size:12px;"
                                        onclick="return confirm('Delete this account?')">
                                        <i class="bi bi-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted" style="font-size:12px;">No accounts found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</main>
<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4" style="font-size:12px;">
      
      <!-- Header -->
      <div class="modal-header bg-dark text-white rounded-top-4">
        <h5 class="modal-title fw-semibold" id="importModalLabel" style="font-size:12px;">
          <i class="bi bi-file-earmark-excel-fill me-2 text-success"></i> Bulk Import Accounts
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body p-4" style="background:#f9f9f9; font-size:12px;">
        <p class="mb-3 text-muted" style="font-size:12px;">
          Upload an Excel file (.xlsx or .csv) with the following headers: 
          <strong>FULLNAME, POSITION, LEVEL, TEAM, REMARKS, NAS, PASSWORD</strong>.
        </p>

        <form action="{{ route('accounts.import') }}" method="POST" enctype="multipart/form-data" style="font-size:12px;">
            @csrf
            <div class="mb-3">
                <label for="campaign" class="form-label fw-semibold" style="font-size:12px;">
                    <i class="bi bi-building-fill me-2 text-secondary"></i> Select Campaign
                </label>
                <select name="campaign" id="campaign" class="form-select" style="font-size:12px;" required>
                    <option value="">Choose Campaign</option>
                    <option value="AIA 3">AIA 3</option>
                    <option value="BPI INB">BPI INB</option>
                    <option value="BPI PA">BPI PA</option>
                    <option value="MB PA">MB PA</option>
                    <option value="MB PL">MB PL</option>
                    <option value="SSU - IT">SSU - IT</option>
                </select>
            </div>

            <div class="input-group mb-3">
                <input type="file" name="file" class="form-control" style="font-size:12px;" required>
                <button class="btn btn-success px-4" type="submit" style="font-size:12px;">
                    <i class="bi bi-cloud-arrow-up me-2"></i> Import
                </button>
            </div>
        </form>

        <div class="alert alert-info rounded-3 mt-3" style="font-size:12px;">
          <i class="bi bi-info-circle me-2"></i>
          Make sure your Excel file matches the required column names exactly.
        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer bg-light rounded-bottom-4">
        <button type="button" class="btn btn-secondary rounded-pill px-4" style="font-size:12px;" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-2"></i> Cancel
        </button>
      </div>
    </div>
  </div>
</div>

@endsection
