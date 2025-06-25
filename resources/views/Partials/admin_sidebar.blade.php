<!-- Sidebar -->
<div class="sidebar sidebar-style-2">           
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('assets/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            PhoneKu
                            <span class="user-level">Administrator</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="#profile">
                                    <span class="link-collapse">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#edit">
                                    <span class="link-collapse">Edit Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#settings">
                                    <span class="link-collapse">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Components</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                    <a href="{{ route('admin.products') }}" class="collapsed" aria-expanded="false">
                        <i class="fa-solid fa-cube"></i>
                        <p>Produk</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <a href="{{ route('admin.users') }}" class="collapsed" aria-expanded="false">
                        <i class="fa-solid fa-users"></i>
                        <p>Management Users</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.testimoni') ? 'active' : '' }}">
                    <a href="{{ route('admin.testimoni') }}" class="collapsed" aria-expanded="false">
                        <i class="fa-solid fa-star"></i>
                        <p>Manage Testimoni</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Customer Support</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.chat') ? 'active' : '' }}">
                    <a href="{{ route('admin.chat') }}" class="collapsed" aria-expanded="false">
                        <i class="fa-solid fa-comment"></i>
                        <p>Chat</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->