@extends('layouts.app')

@section('content')
    <main id="main" class="main">
<div class="container-fluid py-5" style="background:#f9f9f9; min-height:100vh;">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h1 class="fw-bold text-dark mb-3 mb-md-0">Accounts Inventory</h1>
        <!-- Trigger Button -->
<button type="button" class="btn btn-dark rounded-pill px-4 py-2 shadow-sm"
        data-bs-toggle="modal" data-bs-target="#importModal">
    Import Bulk Data
</button>



        <a href="{{ route('accounts.create') }}" 
           class="btn btn-dark px-4 py-2 rounded-pill shadow-sm">
           + Add New Account
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>NAS Username</th>
                            <th>AD Username</th>
                            <th>SIP Extension</th>
                            <th>Agent #</th>
                            <th>Campaign</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $account)
                        <tr>
                            <td>{{ $account->id }}</td>
                            <td>{{ $account->nas_username }}</td>
                            <td>{{ $account->ad_username }}</td>
                            <td>{{ $account->sip_extension }}</td>
                            <td>{{ $account->agent_number }}</td>
                            <td>{{ $account->campaign }}</td>
                            <td>
                                <span class="badge rounded-pill 
                                    {{ $account->status === 'Active' ? 'bg-success' : 
                                       ($account->status === 'Pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                    {{ $account->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('accounts.show', $account->id) }}" 
                                   class="btn btn-outline-dark btn-sm rounded-pill px-3">View</a>
                                <a href="{{ route('accounts.edit', $account->id) }}" 
                                   class="btn btn-outline-secondary btn-sm rounded-pill px-3">Edit</a>
                                <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                        class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                        onclick="return confirm('Delete this account?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
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
    <div class="modal-content border-0 shadow-lg rounded-4">
      
      <!-- Header -->
      <div class="modal-header bg-dark text-white rounded-top-4">
        <h5 class="modal-title fw-semibold" id="importModalLabel">
          <i class="bi bi-file-earmark-excel-fill me-2 text-success"></i> Bulk Import Accounts
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body p-4" style="background:#f9f9f9;">
        <p class="mb-3 text-muted">
          Upload an Excel file (.xlsx or .csv) with the following headers: 
          <strong>NAME, POSITION, LEVEL, TEAM, REMARKS, NAS, PASSWORD</strong>.
        </p>

    <form action="{{ route('accounts.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="campaign" class="form-label fw-semibold">Select Campaign</label>
        <select name="campaign" id="campaign" class="form-select" required>
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
        <input type="file" name="file" class="form-control" required>
        <button class="btn btn-success px-4" type="submit">Import</button>
    </div>
</form>


        <div class="alert alert-info rounded-3 mt-3">
          <i class="bi bi-info-circle me-2"></i>
          Make sure your Excel file matches the required column names exactly.
        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer bg-light rounded-bottom-4">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
</main>
@endsection
