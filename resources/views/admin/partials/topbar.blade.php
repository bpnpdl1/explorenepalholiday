<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex align-items-center">
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                        <span class="logo-sm"><i class="ri-mountain-line fs-24 text-primary"></i></span>
                        <span class="logo-lg fw-bold text-primary">Explore Nepal</span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon" aria-label="Toggle navigation">
                    <span class="hamburger-icon"><span></span><span></span><span></span></span>
                </button>

            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Notifications">
                        <i class="ri-notification-3-line fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0">
                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <h6 class="m-0 fs-16 fw-semibold text-white">Notifications</h6>
                            </div>
                        </div>
                        <div class="p-3 text-muted">The notification center is not configured yet.</div>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <span class="avatar-xs rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center fw-semibold">
                                {{ auth()->user()->initials() }}
                            </span>
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth()->user()->name }}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">Administrator</span>
                            </span>
                            <i class="ri-arrow-down-s-line ms-1"></i>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <h6 class="dropdown-header">Welcome, {{ auth()->user()->name }}</h6>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="ri-user-settings-line text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Account settings</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item" type="submit">
                                <i class="ri-logout-box-r-line text-muted fs-16 align-middle me-1"></i>
                                <span class="align-middle">Log out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
