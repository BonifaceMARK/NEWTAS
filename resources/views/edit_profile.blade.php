@include('layouts.title')

<body>
  <!-- Include Header -->
  @include('layouts.header')

  <!-- Include Sidebar -->
  @include('layouts.sidebar')

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <main id="main" class="main">
    <div class="container">
      <h1>Edit User Profile</h1>
      <form method="POST" action="{{ route('profile.update', ['id' => $user->id]) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname', $user->fullname) }}">
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
        </div>

        @if(Auth::user()->role >= 9)
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role">
                <option value="9" {{ $user->role == 9 ? 'selected' : '' }}>Administrator</option>
                <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Encoder</option>
                <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Employee View</option>
            </select>
        </div>
        @endif

        <!-- Reset Password Section -->
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="javascript:history.back()" class="btn btn-secondary">Return</a>
      </form>
    </div>
  </main>

  <!-- Include Footer -->
  @include('layouts.footer')
</body>
</html>
