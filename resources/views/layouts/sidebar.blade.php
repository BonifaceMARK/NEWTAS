<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link dashboard collapsed" href="#">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->
    
    <li class="nav-item">
      <a class="nav-link chat collapsed" data-bs-target="#tables-nav" href="{{ route('dashboard') }}">
        <i class="bi bi-person-arms-up"></i><span>User Management</span>
      </a>
    </li>

   <li class="nav-item">
  <a class="nav-link chat collapsed dropdown-toggle" href="#" id="inventoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="bi bi-box-seam"></i><span>Inventory</span>
  </a>
  <ul class="dropdown-menu" aria-labelledby="inventoryDropdown">
    <li><a class="dropdown-item" href="{{ route('inventory.create') }}"><i class="bi bi-plus-lg"></i> Add Item</a></li>
    <li><a class="dropdown-item" href="{{ route('inventory.list') }}"><i class="bi bi-list"></i> Item List</a></li>
    <li><a class="dropdown-item" href="{{ route('inventory.values') }}"><i class="bi bi-gear-fill"></i> Manage Options</a></li>
    <li><hr class="dropdown-divider"></li>
  </ul>
</li>

    <li class="nav-item">
      <a class="nav-link chat collapsed" href="{{ route('inventory.gatepass.create') }}"><i class="bi bi-file-earmark-text-fill"></i> Gatepass</a>
    </li>


    @if (Auth::user()->role == 9)
    
    @endif
  </ul>
</aside><!-- End Sidebar -->
