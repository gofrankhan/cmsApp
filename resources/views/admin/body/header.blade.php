
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function() {
    $('#btn_customer').click(function() {
        window.location.href = '/customer/data';
    });
});
</script>

<header id="page-topbar" data-layout="horizontal">
<div class="navbar-header">
    <div class="d-flex">
        @php
            $user_type = Auth::user()->user_type;
        @endphp
        <button type="button" style="width:30px" id="btn_csn_services" class="btn font-size-20 header-item waves-effect">
           
        </button>
            
        <button type="button" id="btn_bashboard" class="btn font-size-20 header-item waves-effect">
            PC Point
        </button>
        @if($user_type != 'lawyer')
        <button type="button" id="btn_customer" class="btn font-size-20 header-item waves-effect">
            Customers
        </button>
        @endif
        <button type="button" id="btn_file" class="btn font-size-20 header-item waves-effect">
            Files
        </button>

        <button type="button" id="btn_movement" class="btn font-size-20 header-item waves-effect">
            Movements
        </button>

    </div>

    <div class="d-flex">
        @if($user_type == 'admin')
        <div class="dropdown d-inline-block user-dropdown">
            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="d-none d-xl-inline-block ms-1">More</span>
                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <a class="dropdown-item" href="{{ route('client.table') }}"><i class="ri-user-line align-middle me-1"></i>Config Users</a>
                <a class="dropdown-item" href="{{ route('reset.password')}}"><i class=" ri-key-line align-middle me-1"></i>Reset Password</a>
                <a class="dropdown-item" href="{{ route('create.category') }}"><i class="mdi mdi-18px mdi-table-cog align-middle me-1"></i>Set Category</a>
                <a class="dropdown-item" href="{{ route('create.settings') }}"><i class="mdi mdi-18px mdi-cog-transfer-outline align-middle me-1"></i>Settings</a>
            </div>
        </div>
        @endif
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
document.getElementById("btn_bashboard").addEventListener("click", function(event) {
  event.preventDefault();
  window.location.href = '/dashboard';
});

// document.getElementById("btn_customer").addEventListener("click", function(event) {
//   event.preventDefault();
//   window.location.href = '/customer/data';
// });

document.getElementById("btn_file").addEventListener("click", function(event) {
  event.preventDefault();
  window.location.href = '/file/data/user';
});

document.getElementById("btn_movement").addEventListener("click", function(event) {
  event.preventDefault();
  window.location.href = '/movement/data';
});
</script>
