<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.title')
    @include('layouts.header')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
        }
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 240px;
            background-color: #fff;
            border-right: 1px solid #e5e5e5;
            padding: 20px;
        }
        .content {
            flex: 1;
            padding: 40px;
        }
        h1, h2, h3 {
            font-weight: 600;
            color: #111;
        }
        .btn {
            border-radius: 6px;
            font-size: 14px;
        }
        footer {
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #777;
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
