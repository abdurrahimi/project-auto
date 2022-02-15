 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : 'collapsed' }}" href="{{url('/admin/dashboard')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/user-list/*') ? 'active' : 'collapsed' }}" data-bs-target="#user-management" data-bs-toggle="collapse" href="#" aria-expanded="false">
          <i class="ri-user-line"></i><span>User Management</span><i class="ri-arrow-right-s-line arrow-down ms-auto"></i>
        </a>
        <ul id="user-management" class="nav-content collapsed collapse {{ Request::is('admin/user-list/*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav" style="">
          <li>
            <a href="{{url('/admin/user-list/admin')}}" class="{{ Request::is('admin/user-list/admin') ? 'active' : '' }}">
              <span>Admin List</span>
            </a>
          </li>
          <li>
            <a href="{{url('/admin/user-list/user')}}" class="{{ Request::is('admin/user-list/user') ? 'active' : '' }}">
              <span>User List</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/brand') ? 'active' : 'collapsed' }}" href="{{url('/admin/brand')}}">
          <i class="bi bi-grid"></i>
          <span>Car Brand</span>
        </a>
      </li>
      
    </ul>

  </aside><!-- End Sidebar-->