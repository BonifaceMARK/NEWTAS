@include('layouts.title')
<body>
<style>
    .users-page {
        max-width: 1440px;
        margin: 0 auto;
    }
    .users-hero {
        background: linear-gradient(120deg, #102a43 0%, #1f4e79 100%);
        border-radius: 12px;
        color: #fff;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }
    .users-hero::after {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border: 1px solid rgba(255,255,255,.18);
        border-radius: 50%;
        right: -70px;
        top: -90px;
    }
    .metric-card {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        background: #fff;
        padding: 1rem 1.1rem;
        height: 100%;
    }
    .metric-label { color: #6c757d; font-size: .75rem; text-transform: uppercase; letter-spacing: .06em; }
    .metric-value { color: #102a43; font-size: 1.65rem; font-weight: 700; }
    .users-table thead th { background: #f8fafc; color: #52606d; font-size: .72rem; letter-spacing: .06em; text-transform: uppercase; white-space: nowrap; }
    .users-table tbody tr { transition: background-color .15s ease; }
    .users-table tbody tr:hover { background: #f7fbff; }
    .user-avatar { align-items: center; background: #d9eaf7; border-radius: 50%; color: #1f4e79; display: inline-flex; font-weight: 700; height: 38px; justify-content: center; margin-right: .65rem; width: 38px; }
    .password { color: #52606d; letter-spacing: .12em; }
    .action-group { white-space: nowrap; }
    @media (max-width: 767px) { .users-hero { padding: 1.35rem; } .users-hero .btn { width: 100%; } }
</style>
  <!-- Include Header -->
  @include('layouts.header')

  <!-- Include Sidebar -->
  @include('layouts.sidebar')

  <main id="main" class="main">
  
    <div class="container-fluid users-page">
        <div class="users-hero mb-4">
            <div class="position-relative" style="z-index: 1;">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div><p class="text-uppercase small mb-2 opacity-75">Administration</p><h1 class="h2 mb-2">User management</h1><p class="mb-0 opacity-75">Manage access, roles, and account visibility from one place.</p></div>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="bi bi-person-plus me-1"></i>Add user</button>
                </div>
            </div>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-4"><div class="metric-card"><div class="metric-label">Total users</div><div class="metric-value">{{ $users->count() }}</div></div></div>
            <div class="col-12 col-sm-4"><div class="metric-card"><div class="metric-label">Active now</div><div class="metric-value text-success">{{ $users->where('isactive', 1)->count() }}</div></div></div>
            <div class="col-12 col-sm-4"><div class="metric-card"><div class="metric-label">Administrators</div><div class="metric-value">{{ $users->where('role', 9)->count() }}</div></div></div>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 p-3 border-bottom">
                    <div><h2 class="h5 mb-1">All accounts</h2><small class="text-muted">Use the search field to quickly find a user.</small></div>
                    <div class="input-group" style="max-width: 300px;"><span class="input-group-text bg-white"><i class="bi bi-search"></i></span><input id="userSearch" type="search" class="form-control" placeholder="Search users..."></div>
                </div>
                <div class="table-responsive">
            <table class="table users-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Availability</th>
                        <th class="text-end">Actions</th>
                    </tr> 
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="user-row">
                        <td><span class="user-avatar">{{ strtoupper(substr($user->fullname, 0, 1)) }}</span><strong>{{ $user->fullname }}</strong></td>
                        <td>{{ $user->username }}</td>
                        <td><a href="mailto:{{ $user->email }}" class="text-decoration-none">{{ $user->email }}</a></td>
                        <td><span class="password" data-password="{{ $user->decrypted_password }}">••••••••</span></td>
                        <td>
                            @if ($user->role == 9)<span class="badge rounded-pill bg-primary-subtle text-primary-emphasis">Administrator</span>
                            @elseif($user->role == 2)
                            <span class="badge rounded-pill bg-info-subtle text-info-emphasis">Encoder</span>
                            @else
                            <span class="badge rounded-pill bg-light text-dark">Employee</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->isactive == 1)<span class="badge rounded-pill bg-success-subtle text-success-emphasis"><i class="bi bi-circle-fill me-1" style="font-size: .45rem;"></i>Online</span>
                            @else
                            <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis"><i class="bi bi-circle-fill me-1" style="font-size: .45rem;"></i>Offline</span>
                            @endif
                        </td>
                        <td class="text-end action-group">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Edit user"><i class="bi bi-pencil"></i><span class="visually-hidden">Edit</span></a>
                            <button class="toggle-password btn btn-sm btn-outline-secondary" data-visible="false" title="Show password"><i class="bi bi-eye"></i><span class="visually-hidden">Show password</span></button>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete user" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i><span class="visually-hidden">Delete</span></button>
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

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        @csrf
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" required>
                            <div class="invalid-tooltip">
                                Please enter a valid full name.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                            <div class="invalid-tooltip">
                                Please enter a valid username.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="invalid-tooltip">
                                Please enter a valid email address.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="invalid-tooltip">
                                Please enter a valid password (at least 8 characters).
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option selected="selected" disabled="disabled">Select Role</option>
                                <option value="0">Employee</option>
                                <option value="2">Encoder</option>
                                <option value="9">Administrator</option>
                            </select>
                            <div class="invalid-tooltip">
                                Please select a role.
                            </div>
                        </div>
                        <button type="button" id="addUserBtn" class="btn btn-primary">Add User</button>
                    </form>
                                 
                </div>
            </div>
        </div>
    </div>
    
</main>
<script>
    $(document).ready(function() {
        $('#userSearch').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            $('.user-row').each(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchTerm) !== -1);
            });
        });

        $("#addUserBtn").click(function(event) {
            event.preventDefault();

            // Validation for required fields
            if ($("#fullname").val() === '' || $("#username").val() === '' || $("#email").val() === '' || $("#password").val() === '' || $("#role").val() === '') {
                if ($("#fullname").val() === '') {
                    $("#fullname").addClass("is-invalid");
                    $("#fullname").next(".invalid-tooltip").text("Please enter a valid full name.");
                }
                if ($("#username").val() === '') {
                    $("#username").addClass("is-invalid");
                    $("#username").next(".invalid-tooltip").text("Please enter a valid username.");
                }
                if ($("#email").val() === '') {
                    $("#email").addClass("is-invalid");
                    $("#email").next(".invalid-tooltip").text("Please enter a valid email address.");
                }
                if ($("#password").val() === '') {
                    $("#password").addClass("is-invalid");
                    $("#password").next(".invalid-tooltip").text("Please enter a valid password (at least 8 characters).");
                }
                if ($("#role").val() === '') {
                    $("#role").addClass("is-invalid");
                    $("#role").next(".invalid-tooltip").text("Please select a role.");
                }
                return false;
            }

            var formData = {
                fullname: $("#fullname").val(),
                username: $("#username").val(),
                email: $("#email").val(),
                password: $("#password").val(),
                role: $("#role").val(),
                _token: $('input[name="_token"]').val()
            };

            $.ajax({
                url: "{{route('store.user')}}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#addUserModal').modal('hide');
                    alert('User added successfully!');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Show the error message from the server
                    var errorMessage = xhr.responseJSON.message;
                    alert('Error: ' + errorMessage);
                }
            });
        });

        // Clear validation classes and messages on focus
        $("#fullname, #username, #email, #password, #role").focus(function() {
            $(this).removeClass("is-invalid").next(".invalid-tooltip").text("");
        });
    });
</script>
<script>
$(document).ready(function() {
    $(".password").each(function() {
        var passwordSpan = $(this);
        var password = passwordSpan.data("password");
        var asterisks = "*".repeat(password.length);
        passwordSpan.text(asterisks);
    });

    $(".toggle-password").click(function() {
        var passwordSpan = $(this).closest("tr").find(".password");
        var visible = $(this).data("visible");
        

        if (visible === "true") {
            var asterisks = "*".repeat(passwordSpan.data("password").length);
            passwordSpan.text(asterisks);
            $(this).text("Show Password");
            $(this).data("visible", "false");
        } else {
            var password = passwordSpan.data("password");
            passwordSpan.text(password);
            $(this).text("Hide Password");
            $(this).data("visible", "true");
        }
    });
});
</script>







  <!-- Include Footer -->
  @include('layouts.footer')
</body>

</html>