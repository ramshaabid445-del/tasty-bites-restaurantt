<header class="pc-header">
    <div class="header-wrapper">
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide"><i class="ti ti-menu-2"></i></a>
                </li>
            </ul>
        </div>
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button">
                        {{-- Dynamic Avatar Logic added below --}}
                        <img src="{{ Auth::user()->avatar ? asset('uploads/avatars/'.Auth::user()->avatar) : asset('backend/assets/images/user/avatar-1.jpg') }}" 
                             alt="user-image" 
                             class="user-avtar" 
                             style="width: 35px; height: 35px; object-fit: cover;">
                        <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center">
                            {{-- Dropdown inner avatar --}}
                            <img src="{{ Auth::user()->avatar ? asset('uploads/avatars/'.Auth::user()->avatar) : asset('backend/assets/images/user/avatar-1.jpg') }}" 
                                 class="rounded-circle me-2" 
                                 style="width: 40px; height: 40px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0">{{ Auth::user()->name ?? 'Admin' }}</h6>
                                <small class="text-muted">{{ Auth::user()->email ?? 'admin@restaurant.com' }}</small>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item"><i class="ti ti-user"></i> Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="ti ti-power"></i> Logout</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>