<!doctype html>
<html lang="en">
  @include('partial.head')
  <body >
    <div class="page">
      <!-- Sidebar -->
      @if($users->role == 1)
        @include('partial.admin-sidebar')
      @else
        @include('partial.sidebar')
      @endif
      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Technician, {{ $pretitle ?? 'Pusat Database' }}
                </div>
                <h2 class="page-title">
                  {{ $title ?? Menu }}
                </h2>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            @yield('content')
          </div>
        </div>
      </div>
    </div>
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js?1684106062" defer></script>
    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @yield('script')
  </body>
</html>