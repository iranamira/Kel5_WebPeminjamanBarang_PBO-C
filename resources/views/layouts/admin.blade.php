<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard</title>
    @include('script.css')
</head>
<body>
    @php
/* Display elements */
$contentNavbar = true;
$containerNav = ($containerNav ?? 'container-xxl');
$isFlex = ($isFlex ?? false);

/* HTML Classes */
$navbarDetached = 'navbar-detached';

/* Content classes */
$container = ($container ?? 'container-xxl');

@endphp

<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">

    @include('layouts/sections/menu/verticalMenuAdmin')

    <!-- Layout page -->
    <div class="layout-page">
      <!-- BEGIN: Navbar-->
      @include('layouts/sections/navbar/navbarAdmin')
      <!-- END: Navbar-->

      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
        @if ($isFlex)
        <div class="{{$container}} d-flex align-items-stretch flex-grow-1 p-0">
          @else
          <div class="{{$container}} flex-grow-1 container-p-y">
            @endif

            @yield('content')

          </div>
          <!-- / Content -->
          <!-- / Footer -->
          <div class="content-backdrop fade"></div>
        </div>
        <!--/ Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
  </div>
  <!-- / Layout wrapper -->
</body>
@include('script.script')
@yield('script')
</html>