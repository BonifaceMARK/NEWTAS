{{-- filepath: c:\xampp\htdocs\ASI-INVENTORY\resources\views\layouts\sidebar.blade.php --}}

<style>
    :root {
        --asi-navy: #123b78;
        --asi-blue: #1769aa;
        --asi-soft-blue: #eef5fc;
        --asi-border: #e6edf5;
        --asi-muted: #718096;
    }

    #sidebar.asi-sidebar {
        top: 68px;
        width: 252px;
        padding: 18px 14px;
        background: #fff;
        border-right: 1px solid var(--asi-border);
        box-shadow: 4px 0 18px rgba(18, 59, 120, .04);
    }

    .asi-sidebar .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 4px 10px 18px;
        margin-bottom: 8px;
        border-bottom: 1px solid var(--asi-border);
    }

    .asi-sidebar .sidebar-brand img {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        object-fit: cover;
    }

    .asi-sidebar .sidebar-brand strong {
        color: var(--asi-navy);
        font-size: 15px;
        letter-spacing: -.2px;
    }

    .asi-sidebar .sidebar-label {
        padding: 15px 10px 7px;
        color: var(--asi-muted);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .asi-sidebar .sidebar-nav .nav-item { margin-bottom: 4px; }

    .asi-sidebar .nav-link,
    .asi-sidebar .nav-content a {
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: .2s ease;
    }

    .asi-sidebar .nav-link {
        min-height: 42px;
        padding: 10px 12px;
        color: #334155;
        background: transparent;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
    }

    .asi-sidebar .nav-link i:first-child {
        width: 22px;
        margin-right: 9px;
        color: var(--asi-muted);
        font-size: 16px;
        text-align: center;
    }

    .asi-sidebar .nav-link .chevron {
        margin-left: auto;
        color: #9aa8b8;
        font-size: 12px;
        transition: transform .2s ease;
    }

    .asi-sidebar .nav-link:not(.collapsed),
    .asi-sidebar .nav-link:hover,
    .asi-sidebar .nav-link.active {
        color: var(--asi-navy);
        background: var(--asi-soft-blue);
    }

    .asi-sidebar .nav-link:not(.collapsed) i:first-child,
    .asi-sidebar .nav-link:hover i:first-child,
    .asi-sidebar .nav-link.active i:first-child { color: var(--asi-blue); }

    .asi-sidebar .nav-link:not(.collapsed) .chevron {
        color: var(--asi-blue);
        transform: rotate(180deg);
    }

    .asi-sidebar .nav-content {
        padding: 4px 0 5px 31px;
        margin: 0;
        list-style: none;
    }

    .asi-sidebar .nav-content a {
        gap: 8px;
        padding: 8px 10px;
        color: var(--asi-muted);
        border-left: 1px solid var(--asi-border);
        font-size: 12px;
        font-weight: 500;
    }

    .asi-sidebar .nav-content a i { color: #a9b6c5; font-size: 12px; }

    .asi-sidebar .nav-content a:hover,
    .asi-sidebar .nav-content a.active {
        color: var(--asi-blue);
        border-left-color: var(--asi-blue);
        background: #f8fbff;
    }

    @media (min-width: 1200px) {
        #main, #footer { margin-left: 252px; }
        .toggle-sidebar #main, .toggle-sidebar #footer { margin-left: 0; }
    }

    @media (max-width: 1199px) {
        #sidebar.asi-sidebar { left: -252px; }
        .toggle-sidebar #sidebar.asi-sidebar { left: 0; }
    }
</style>

<aside id="sidebar" class="sidebar asi-sidebar">
   

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="sidebar-label">Workspace</li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('inventory.dashboard') ? 'active' : '' }}"
               href="{{ route('inventory.dashboard') }}">
                <i class="bi bi-grid-1x2"></i><span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
               href="{{ route('dashboard') }}">
                <i class="bi bi-people"></i><span>User Management</span>
            </a>
        </li>

        <li class="sidebar-label">Operations</li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('inventory.*') && !request()->routeIs('inventory.gatepass*') ? '' : 'collapsed' }}"
               data-bs-toggle="collapse" href="#inventory-nav" role="button"
               aria-expanded="{{ request()->routeIs('inventory.*') && !request()->routeIs('inventory.gatepass*') ? 'true' : 'false' }}">
                <i class="bi bi-box-seam"></i><span>Inventory</span><i class="bi bi-chevron-down chevron"></i>
            </a>
            <ul id="inventory-nav" class="nav-content collapse {{ request()->routeIs('inventory.*') && !request()->routeIs('inventory.gatepass*') ? 'show' : '' }}">
                <li><a class="{{ request()->routeIs('inventory.create') ? 'active' : '' }}" href="{{ route('inventory.create') }}"><i class="bi bi-plus-lg"></i>Add Item</a></li>
                <li><a class="{{ request()->routeIs('inventory.list') ? 'active' : '' }}" href="{{ route('inventory.list') }}"><i class="bi bi-list"></i>Item List</a></li>
                <li><a class="{{ request()->routeIs('inventory.values') ? 'active' : '' }}" href="{{ route('inventory.values') }}"><i class="bi bi-sliders"></i>Manage Options</a></li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('inventory.gatepass*', 'gatepasses.*') ? '' : 'collapsed' }}"
               data-bs-toggle="collapse" href="#gatepass-nav" role="button"
               aria-expanded="{{ request()->routeIs('inventory.gatepass*', 'gatepasses.*') ? 'true' : 'false' }}">
                <i class="bi bi-file-earmark-text"></i><span>Gatepass</span><i class="bi bi-chevron-down chevron"></i>
            </a>
            <ul id="gatepass-nav" class="nav-content collapse {{ request()->routeIs('inventory.gatepass*', 'gatepasses.*') ? 'show' : '' }}">
                <li><a class="{{ request()->routeIs('inventory.gatepass.create') ? 'active' : '' }}" href="{{ route('inventory.gatepass.create') }}"><i class="bi bi-plus-lg"></i>Create Gatepass</a></li>
                <li>
                    <a class="{{ request()->routeIs('inventory.gatepass.list', 'gatepasses.index') ? 'active' : '' }}"
                       href="{{ route('inventory.gatepass.list') }}">
                        <i class="bi bi-list-ul"></i>Gatepass List
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('asset.transfer.*', 'asset-transfers.*') ? '' : 'collapsed' }}"
               data-bs-toggle="collapse" href="#transfer-nav" role="button"
               aria-expanded="{{ request()->routeIs('asset.transfer.*', 'asset-transfers.*') ? 'true' : 'false' }}">
                <i class="bi bi-arrow-left-right"></i><span>Asset Transfer</span><i class="bi bi-chevron-down chevron"></i>
            </a>
            <ul id="transfer-nav" class="nav-content collapse {{ request()->routeIs('asset.transfer.*', 'asset-transfers.*') ? 'show' : '' }}">
                <li><a class="{{ request()->routeIs('asset.transfer.create') ? 'active' : '' }}" href="{{ route('asset.transfer.create') }}"><i class="bi bi-plus-lg"></i>Create Transfer</a></li>
                <li><a class="{{ request()->routeIs('asset.transfer.index', 'asset-transfers.index') ? 'active' : '' }}" href="{{ route('asset.transfer.index') }}"><i class="bi bi-list-ul"></i>Transfer List</a></li>
            </ul>
        </li>
    </ul>
</aside>
