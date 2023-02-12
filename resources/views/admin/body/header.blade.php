<header id="page-topbar">
<div class="navbar-header">
    <div class="d-flex">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <a href="index.html" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="logo-sm" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="logo-dark" height="20">
                </span>
            </a>

            <a href="index.html" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="logo-sm-light" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="logo-light" height="20">
                </span>
            </a>
        </div>

        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
            <i class="ri-menu-2-line align-middle"></i>
        </button>
            
        <button type="button" id="btn_csn_services" class="btn font-size-20 header-item waves-effect">
            CSN Services
        </button>

        <button type="button" id="btn_customer" class="btn font-size-20 header-item waves-effect">
            Customers
        </button>

        <button type="button" id="btn_file" class="btn font-size-20 header-item waves-effect">
            Files
        </button>

        <button type="button" class="btn font-size-20 header-item waves-effect">
            Movements
        </button>

    </div>

    <div class="d-flex">
        @php
            $id = Auth::user()->id;
            $adminData = App\Models\User::find($id);
        @endphp
        <div class="dropdown d-inline-block user-dropdown">
            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle header-profile-user" src="{{ (!empty($adminData->profile_image))? url('upload/admin_images/'.$adminData->profile_image)
                    :url('upload/no_image.jpeg')}}"
                    alt="Header Avatar">
                <span class="d-none d-xl-inline-block ms-1">{{ $adminData->name }}</span>
                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <a class="dropdown-item" href="{{ route('admin.profile')}}"><i class="ri-user-line align-middle me-1"></i> Profile</a>
                <a class="dropdown-item" href="{{ route('change.password')}}"><i class="ri-wallet-2-line align-middle me-1"></i>Change Password</a>
                <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
            </div>
        </div>

    </div>
</div>
</header>


<script>
document.getElementById("btn_customer").addEventListener("click", function(event) {
  event.preventDefault();
  window.location.href = '/customer/data';
});

document.getElementById("btn_file").addEventListener("click", function(event) {
  event.preventDefault();
  window.location.href = '/file/data';
});
</script>