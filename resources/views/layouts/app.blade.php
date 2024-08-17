<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{env('APP_NAME')}} - Dashbaord</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="icon" href="{{asset('assets/img/auth/small-logo.png')}}"> --}}
  <link rel="icon" type="image/png" href="assets/images/auth/small-logo.png" sizes="16x16">

    <!-- remix icon font css  -->
    <link rel="stylesheet" href="{{asset('assets/css/remixicon.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- BootStrap css -->
    <link rel="stylesheet" href="{{asset('assets/css/lib/bootstrap.min.css')}}">
    <!-- Apex Chart css -->
    <link rel="stylesheet" href="{{asset('assets/css/lib/apexcharts.css')}}">
    <!-- Data Table css -->
    <link rel="stylesheet" href="{{asset('assets/css/lib/dataTables.min.cs')}}s">
    <!-- Text Editor css -->
    <link rel="stylesheet" href="{{asset('assets/css/lib/editor-katex.min.css')}}">
    <link rel="stylesheet" href="{{asset("assets/css/lib/editor.atom-one-dark.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/css/lib/editor.quill.snow.css")}}">
    <!-- Date picker css -->
    <link rel="stylesheet" href="{{asset("assets/css/lib/flatpickr.min.css")}}">
    <!-- Calendar css -->
    <link rel="stylesheet" href="{{asset("assets/css/lib/full-calendar.css")}}">
    <!-- Vector Map css -->
    <link rel="stylesheet" href="{{asset("assets/css/lib/jquery-jvectormap-2.0.5.css")}}">
    <!-- Popup css -->
    <link rel="stylesheet" href="{{asset("assets/css/lib/magnific-popup.css")}}">
    <!-- Slick Slider css -->
    <link rel="stylesheet" href="{{asset("assets/css/lib/slick.css")}}">
    <!-- main css -->
    <link rel="stylesheet" href="{{asset("assets/css/style.css")}}">
  </head>
    <body>
  <aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
      <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
      <a href="{{url('/')}}" class="sidebar-logo">
        <img src="{{asset('assets/images/auth/logo.png')}}" alt="site logo" class="light-logo">
        <img src="{{asset('assets/images/auth/logo.png')}}" alt="site logo" class="dark-logo">
        <img src="{{asset('assets/images/auth/small-logo.png')}}" alt="site logo" class="logo-icon">
      </a>
    </div>
    <div class="sidebar-menu-area">
      <ul class="sidebar-menu" id="sidebar-menu">
        <li class="">
          <a href="{{url('/')}}">
            <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
            <span>Dashboard</span>
          </a>

        </li>


@if (Auth::user()->role==0 || Auth::user()->role ==1)

 <li class="sidebar-menu-group-title">User Management</li>

        <li>
          <a href="{{ url('register')}}">
            <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
            <span>Add User</span>
          </a>
        </li>
        <li>
            <a href="{{ route('user.list')}}">
              <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
              <span>User List</span>
            </a>
          </li>
        </li><li>
            <a href="{{ route('email.add')}}">
              <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
              <span>Emails</span>
            </a>
          </li>
        </li>
    @endif
        <li class="sidebar-menu-group-title">Order Management</li>
        {{-- solar:document-text-outline --}}
        <li>
            <a href="{{ route('order.form')}}">
              <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
              <span>Add Order</span>
            </a>
          </li>
          <li>
              <a href="{{route('order.list')}}">
                <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
                <span>Order List</span>
              </a>
            </li>
          </li>
          <li>
            <a href="{{route('order.confirm.list')}}">
              <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
              <span>Completed Orders</span>
            </a>
          </li>
        </li>


      </ul>
    </div>
  </aside>

  <main class="dashboard-main">
    <div class="navbar-header">
    <div class="row align-items-center justify-content-between">
      <div class="col-auto">
        <div class="d-flex flex-wrap align-items-center gap-4">
          <button type="button" class="sidebar-toggle">
            <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
            <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
          </button>
          <button type="button" class="sidebar-mobile-toggle">
            <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
          </button>

        </div>
      </div>
      <div class="col-auto">
        <div class="d-flex flex-wrap align-items-center gap-3">
          <button type="button" data-theme-toggle class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button>
          <div class="dropdown d-none d-sm-inline-block">
          </div><!-- Language dropdown end -->



          <div class="dropdown">
            <button class="d-flex justify-content-center align-items-center rounded-circle" type="button" data-bs-toggle="dropdown">
              <img src="{{asset('assets/images/auth/small-logo.png')}}" alt="image" class="w-40-px h-40-px object-fit-cover rounded-circle">
            </button>
            <div class="dropdown-menu to-top dropdown-menu-sm">
              <div class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                <div>
                  <h6 class="text-lg text-primary-light fw-semibold mb-2">{{Auth::User()->name}}</h6>
                  <span class="text-secondary-light fw-medium text-sm">
                    @php
                        if(Auth::User()->role ==0){
                        echo 'Super Admin';
                        }elseif (Auth::User()->role ==1) {
                            echo 'Admin';
                        }else{
                            echo 'Client';
                        }
                    @endphp


                  </span>
                </div>
                <button type="button" class="hover-text-danger">
                  <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon>
                </button>
              </div>
              <li>
                <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3" href={{route('profile.edit')}}>
                <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon>  My Profile</a>
              </li>
              <li>
                <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3"  href="{{ route('logout')}}"  onclick="event.preventDefault();
                document.getElementById('logout-form').submit();" class="btn btn-danger">

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon>  Log Out
                </a>
            </li>

            </div>
          </div><!-- Profile dropdown end -->
        </div>
      </div>
    </div>
  </div>

    <div class="dashboard-main-body">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">{{$header}}</h6>
  </div>

  <div class="my-5">
    {{$slot}}
  </div>


    </div>

    <footer class="d-footer">
    <div class="row align-items-center justify-content-between">
      <div class="col-auto">
        <p class="mb-0">© 2024 ClydePixel. All Rights Reserved.</p>
      </div>
      <div class="col-auto">
        <p class="mb-0">Made by <a href="https://github.com/Abir784" class="text-primary-200">Abir</a></p>
      </div>
    </div>
  </footer>
  </main>

    <!-- jQuery library js -->
    <script src="{{asset('assets/js/lib/jquery-3.7.1.min.js')}}"></script>
    <!-- Bootstrap js -->
    <script src="{{asset('assets/js/lib/bootstrap.bundle.min.js')}}"></script>
    <!-- Apex Chart js -->
    <script src="{{asset('assets/js/lib/apexcharts.min.js')}}"></script>
    <!-- Data Table js -->
    <script src="{{asset('assets/js/lib/dataTables.min.js')}}"></script>
    <!-- Iconify Font js -->
    <script src="{{asset('assets/js/lib/iconify-icon.min.js')}}"></script>
    <!-- jQuery UI js -->
    <script src="{{asset('assets/js/lib/jquery-ui.min.js')}}"></script>
    <!-- Vector Map js -->
    <script src="{{asset('assets/js/lib/jquery-jvectormap-2.0.5.min.js')}}"></script>
    <script src="{{asset('assets/js/lib/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- Popup js -->
    <script src="{{asset('assets/js/lib/magnifc-popup.min.js')}}"></script>
    <!-- Slick Slider js -->
    <script src="{{asset('assets/js/lib/slick.min.js')}}"></script>
    <!-- main js -->
    <script src="{{asset('assets/js/app.js')}}"></script>
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    {{$script}}

  </body>
  </html>
