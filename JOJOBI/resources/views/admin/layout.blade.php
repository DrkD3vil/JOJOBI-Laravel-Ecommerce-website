<!DOCTYPE html>
<html>

<head>
  @include('admin.headcss')
</head>

<body>
  <header class="header">
    @include('admin.navbar')
  </header>
  <div class="d-flex align-items-stretch">
    <!-- Sidebar Navigation-->
    @include ('admin.sidebar')
    <!-- Sidebar Navigation end-->
    <div class="page-content">
      <div class="page-header">
        <div class="container-fluid">
          @yield('content')
        </div>
      </div>
    </div>
    @include('admin.scripts')
</body>

</html>