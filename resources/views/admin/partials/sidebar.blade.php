<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm"><img src="{{ asset('site/assets/logo-mark.png') }}" alt=""></span>
            <span class="logo-lg"><img class="admin-sidebar-wordmark admin-sidebar-wordmark--dark" src="{{ asset('site/assets/logo-footer-small.png') }}" alt="Explore Nepal Holidays" width="64" height="64"></span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
            <span class="logo-sm"><img src="{{ asset('site/assets/logo-mark.png') }}" alt=""></span>
            <span class="logo-lg"><img class="admin-sidebar-wordmark" src="{{ asset('site/assets/footer-logo.png') }}" alt="Explore Nepal Holidays" width="180"></span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover" aria-label="Toggle compact sidebar hover mode">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="ri-dashboard-2-line"></i><span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title"><span>Manage your site</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}" href="{{ route('admin.packages.index') }}">
                        <i class="ri-map-2-line"></i><span>Packages</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.package-departures.*') ? 'active' : '' }}" href="{{ route('admin.package-departures.index') }}">
                        <i class="ri-calendar-event-line"></i><span>Departures</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.package-reviews.*') ? 'active' : '' }}" href="{{ route('admin.package-reviews.index') }}">
                        <i class="ri-chat-quote-line"></i><span>Package reviews</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link menu-link {{ request()->routeIs('admin.bookings.*') ? 'active' : 'collapsed' }}"
                        href="#sidebarBookings"
                        data-bs-toggle="collapse"
                        role="button"
                        aria-expanded="{{ request()->routeIs('admin.bookings.*') ? 'true' : 'false' }}"
                        aria-controls="sidebarBookings"
                    >
                        <i class="ri-calendar-check-line"></i><span>Bookings</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('admin.bookings.*') ? 'show' : '' }}" id="sidebarBookings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.bookings.index') && ! request()->query('stage') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}">All bookings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->query('stage') === 'new-inquiry' ? 'active' : '' }}" href="{{ route('admin.bookings.index', ['stage' => 'new-inquiry']) }}">New inquiries</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->query('stage') === 'pending-review' ? 'active' : '' }}" href="{{ route('admin.bookings.index', ['stage' => 'pending-review']) }}">Pending review</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->query('stage') === 'awaiting-payment' ? 'active' : '' }}" href="{{ route('admin.bookings.index', ['stage' => 'awaiting-payment']) }}">Awaiting payment</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->query('stage') === 'confirmed' ? 'active' : '' }}" href="{{ route('admin.bookings.index', ['stage' => 'confirmed']) }}">Confirmed</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->query('stage') === 'completed' ? 'active' : '' }}" href="{{ route('admin.bookings.index', ['stage' => 'completed']) }}">Completed</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->query('stage') === 'cancelled' ? 'active' : '' }}" href="{{ route('admin.bookings.index', ['stage' => 'cancelled']) }}">Cancelled</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link menu-link {{ request()->routeIs('admin.master.*', 'admin.categories.*', 'admin.subcategories.*', 'admin.destinations.*', 'admin.faqs.*', 'admin.guest-reviews.*', 'admin.team-members.*', 'admin.why-travel-reasons.*', 'admin.site-settings.*', 'admin.seo.*') ? 'active' : 'collapsed' }}"
                        href="#sidebarMaster"
                        data-bs-toggle="collapse"
                        role="button"
                        aria-expanded="{{ request()->routeIs('admin.master.*', 'admin.categories.*', 'admin.subcategories.*', 'admin.destinations.*', 'admin.faqs.*', 'admin.guest-reviews.*', 'admin.team-members.*', 'admin.why-travel-reasons.*', 'admin.site-settings.*', 'admin.seo.*') ? 'true' : 'false' }}"
                        aria-controls="sidebarMaster"
                    >
                        <i class="ri-database-2-line"></i><span>Master</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('admin.master.*', 'admin.categories.*', 'admin.subcategories.*', 'admin.destinations.*', 'admin.faqs.*', 'admin.guest-reviews.*', 'admin.team-members.*', 'admin.why-travel-reasons.*', 'admin.site-settings.*', 'admin.seo.*') ? 'show' : '' }}" id="sidebarMaster">
                        <ul class="nav nav-sm flex-column">
                            <li class="menu-title"><span>Travel content</span></li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.destinations.*') ? 'active' : '' }}" href="{{ route('admin.destinations.index') }}">Destinations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}" href="{{ route('admin.faqs.index') }}">FAQs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.guest-reviews.*') ? 'active' : '' }}" href="{{ route('admin.guest-reviews.index') }}">Guest reviews</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.team-members.*') ? 'active' : '' }}" href="{{ route('admin.team-members.index') }}">Team members</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.why-travel-reasons.*') ? 'active' : '' }}" href="{{ route('admin.why-travel-reasons.index') }}">Why travel with us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Categories</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}" href="{{ route('admin.subcategories.index') }}">Subcategories</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="javascript:void(0)" aria-disabled="true">Activities <span class="badge bg-secondary-subtle text-secondary ms-auto">Soon</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="javascript:void(0)" aria-disabled="true">Inclusions &amp; exclusions <span class="badge bg-secondary-subtle text-secondary ms-auto">Soon</span></a>
                            </li>
                            <li class="menu-title"><span>Configuration</span></li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.site-settings.*') ? 'active' : '' }}" href="{{ route('admin.site-settings.edit') }}">Site settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="javascript:void(0)" aria-disabled="true">Booking settings <span class="badge bg-secondary-subtle text-secondary ms-auto">Soon</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.seo.*') ? 'active' : '' }}" href="{{ route('admin.seo.index') }}">SEO &amp; metadata</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link menu-link {{ request()->routeIs('admin.users.*') ? 'active' : 'collapsed' }}"
                        href="#sidebarPrivilege"
                        data-bs-toggle="collapse"
                        role="button"
                        aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}"
                        aria-controls="sidebarPrivilege"
                    >
                        <i class="ri-shield-user-line"></i><span>Privilege</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('admin.users.*') ? 'show' : '' }}" id="sidebarPrivilege">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Users</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link menu-link {{ request()->routeIs('admin.inquiries.*') ? 'active' : 'collapsed' }}"
                        href="#sidebarInquiries"
                        data-bs-toggle="collapse"
                        role="button"
                        aria-expanded="{{ request()->routeIs('admin.inquiries.*') ? 'true' : 'false' }}"
                        aria-controls="sidebarInquiries"
                    >
                        <i class="ri-question-answer-line"></i><span>Inquiries</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('admin.inquiries.*') ? 'show' : '' }}" id="sidebarInquiries">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.inquiries.index') && ! request()->query('stage') ? 'active' : '' }}" href="{{ route('admin.inquiries.index') }}">All inquiries</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->query('stage') === 'new' && request()->routeIs('admin.inquiries.*') ? 'active' : '' }}" href="{{ route('admin.inquiries.index', ['stage' => 'new']) }}">New</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->query('stage') === 'in-progress' && request()->routeIs('admin.inquiries.*') ? 'active' : '' }}" href="{{ route('admin.inquiries.index', ['stage' => 'in-progress']) }}">In progress</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->query('stage') === 'awaiting-traveler' && request()->routeIs('admin.inquiries.*') ? 'active' : '' }}" href="{{ route('admin.inquiries.index', ['stage' => 'awaiting-traveler']) }}">Awaiting traveler</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->query('stage') === 'converted' && request()->routeIs('admin.inquiries.*') ? 'active' : '' }}" href="{{ route('admin.inquiries.index', ['stage' => 'converted']) }}">Converted to booking</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->query('stage') === 'closed' && request()->routeIs('admin.inquiries.*') ? 'active' : '' }}" href="{{ route('admin.inquiries.index', ['stage' => 'closed']) }}">Closed</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>
