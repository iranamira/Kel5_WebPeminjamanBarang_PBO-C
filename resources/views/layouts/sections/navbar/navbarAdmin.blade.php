
<!-- Navbar -->
<nav class="navbar navbar-expand-xl container-fluid align-items-center bg-navbar-theme py-4 shadow" id="layout-navbar">

    <!--  Brand demo (display only for navbar-full and hide on below xl) -->
    {{-- @if(isset($navbarFull))
    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
      <a href="{{url('/')}}" class="app-brand-link gap-2">
        <span class="app-brand-logo demo">
          Website
        </span>
        <span class="app-brand-text demo menu-text fw-semibold ms-1">Test</span>
      </a>
      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
      </a>
    </div>
    @endif --}}


      <div class="navbar-nav flex-row align-items-center ms-auto mr-5">

        <!-- User -->
          <div class="flex items-center">
            <div class="mr-5 items-start">
                <span>
                  {{ session('admin')->username }}
              </span>
            </div>
            <i class="fa-solid fa-circle-user text-4xl"></i>
        </div>
      
        <!--/ User -->
      </div>
  

    @if(!isset($navbarDetached))
  </div>
  @endif
</nav>
<!-- / Navbar -->
