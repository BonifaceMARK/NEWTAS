<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.title')
    @include('layouts.header')

   <style>
.excel-table {
    font-size: 12px;
    border-collapse: collapse;
}

.excel-table thead th {
    background: #217346;
    color: #fff;
    border: 1px solid #d9d9d9;
    padding: 6px 8px;
    font-weight: 600;
}

.excel-table tbody td {
    border: 1px solid #d9d9d9;
    padding: 4px 8px;
    vertical-align: middle;
    background: #fff;
}

.excel-table tbody tr:nth-child(even) td {
    background: #f8f8f8;
}

.excel-table tbody tr:hover td {
    background: #e2f0d9;
}
</style>
</head>
<body>
    <div class="wrapper">
        <aside class="sidebar">
            @include('layouts.sidebar')
        </aside>

        <main class="content">
            @yield('content')
        </main>
    </div>

    @include('layouts.footer')
</body>
</html>
