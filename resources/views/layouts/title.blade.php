<!DOCTYPE html>
<html lang="en">

<head>
  
  <meta charset="utf-8">
  
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title', config('app.name'))</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/css/carcar.css') }}" rel="stylesheet">
  <link href="{{asset('assets/img/asi_logo.jpg')}}" rel="icon">
  <link href="{{asset('assets/img/asi_logo.jpg')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="{{ asset('assets/css/googlecss.css') }}" rel="preconnect">
  <link rel="stylesheet" href="{{ asset('assets/css/bstrap-datepicker.css') }}">
  <!-- Vendor CSS Files -->

  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
<!-- Include jQuery -->
<script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>
<!-- Include Bootstrap CSS -->
<link href="{{ asset('assets/css/bstrap.css') }}" rel="stylesheet">
<script src="{{ asset('assets/js/apexcharts-6.10.0.js') }}"></script>
<script src="{{ asset('assets/js/bstrap-datepicker.js') }}"></script>
<!-- jQuery UI (Make sure to include jQuery as well) -->
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
{{-- <script data-pace-options='{ "ajax": false, "selectors": [ "img" ]}' src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
   <!-- Include necessary CSS and JS libraries -->
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>