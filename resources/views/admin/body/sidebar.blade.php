<div class="vertical-menu">

<div data-simplebar class="h-100">

    @php
        $user_type = Auth::user()->user_type;
    @endphp
    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu list-unstyled" id="side-menu">
            <li class="menu-title">Menu</li>

            <li>
                <a href="{{ route('dashboard')}}" class="waves-effect">
                    <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end">3</span>
                    <span>Dashboard</span>
                </a>
            </li>

            
            <li>
                <a href=" {{ route('customer.data') }}" class=" waves-effect">
                    <i class="mdi mdi-18px mdi-account"></i>
                    <span>Customers</span>
                </a>
            </li>
            

            <li>
                <a href=" {{ route('file.data') }}" class=" waves-effect">
                    <i class="mdi mdi-18px mdi-account"></i>
                    <span>Files</span>
                </a>
            </li>

            <li>
                <a href="{{ route('dashboard')}}" class=" waves-effect">
                    <i class="mdi mdi-18px mdi-account"></i>
                    <span>Movements</span>
                </a>
            </li>

            @if($user_type == 'admin')
            <li>
                <a href=" {{ route('client.table') }}" class=" waves-effect">
                    <i class="mdi mdi-18px mdi-account"></i>
                    <span>Users</span>
                </a>
            </li>

            <li>
                <a href=" {{ route('create.category') }}" class=" waves-effect">
                    <i class="mdi mdi-18px mdi-account"></i>
                    <span>Category Setup</span>
                </a>
            </li>

            <li>
                <a href=" {{ route('create.settings') }}" class=" waves-effect">
                    <i class="mdi mdi-18px mdi-account"></i>
                    <span>Settings</span>
                </a>
            </li>
            @endif
    </div>
    <!-- Sidebar -->
</div>
</div>