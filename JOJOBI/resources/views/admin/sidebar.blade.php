<nav id="sidebar">
    <!-- Sidebar Header-->
    <!-- Sidebar Header-->
<div class="sidebar-header d-flex align-items-center">
    <div class="avatar"><img src="img/avatar-6.jpg" alt="..." class="img-fluid rounded-circle"></div>
    <div class="title">
        <h1 class="h5">Mark Stephen</h1>
        <p>Web Designer</p>
    </div>
</div>

@php
    function isActive($route) {
        return request()->routeIs($route) ? 'active' : '';
    }
@endphp

<!-- Sidebar Navigation Menus -->
<span class="heading">Main</span>
<ul class="list-unstyled sidebar-nav">
    <li class="{{ request()->is('index.html') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}"> <i class="icon-home"></i>Home </a>
    </li>
    <li class="{{ isActive('admin.category') }}">
        <a href="{{ route('admin.category') }}"> <i class="icon-grid"></i>Category </a>
    </li>
    <li class="{{ request()->is('exampledropdownDropdown*') ? 'active' : '' }}">
        <a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> 
            <i class="icon-windows"></i>Products 
        </a>
        <ul id="exampledropdownDropdown" class="collapse list-unstyled">
            <li><a href="{{ route('admin.product.add') }}">Add Products</a></li>
            <li><a href="{{ route('admin.product.view') }}">All Products</a></li>
        </ul>
    </li>
    <li class="{{ request()->is('exampledropdownDropdown*') ? 'active' : '' }}">
        <a href="#exampledropdownDropdownUsers" aria-expanded="false" data-toggle="collapse"> 
            <i class="icon-logout"></i>Users 
        </a>
        <ul id="exampledropdownDropdownUsers" class="collapse list-unstyled">
            <li><a href="{{ route('admin.user.view') }}">Users</a></li>
            <li><a href="{{ route('admin.admin.view') }}">Admins</a></li>
        </ul>
    </li>
</ul>

<span class="heading">Extras</span>
<ul class="list-unstyled sidebar-nav">
    <li class="{{ request()->is('demo') ? 'active' : '' }}">
        <a href="#"> <i class="icon-settings"></i>Demo </a>
    </li>
    <li class="{{ request()->is('demo') ? 'active' : '' }}">
        <a href="#"> <i class="icon-writing-whiteboard"></i>Demo </a>
    </li>
    <li class="{{ request()->is('demo') ? 'active' : '' }}">
        <a href="#"> <i class="icon-chart"></i>Demo </a>
    </li>
</ul>

</nav>