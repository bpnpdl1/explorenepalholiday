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

                <li class="menu-title"><span>Operations</span></li>
                @php
                    $isInquirySection = request()->routeIs('admin.inquiries.*', 'admin.site-inquiries.*');
                    $isWebsiteInquirySection = request()->query('source') === 'website' || request()->routeIs('admin.site-inquiries.*');
                    $isPackageInquirySection = request()->query('source') === 'package'
                        || request()->routeIs('admin.inquiries.show', 'admin.inquiries.update-status');
                @endphp
                <li class="nav-item">
                    <a class="nav-link menu-link {{ $isInquirySection ? 'active' : 'collapsed' }}" href="#sidebarInquiries" data-bs-toggle="collapse" role="button" aria-expanded="{{ $isInquirySection ? 'true' : 'false' }}" aria-controls="sidebarInquiries">
                        <i class="ri-question-answer-line"></i><span>Inquiries</span><span class="menu-arrow"></span>
                    </a>
                    <div class="collapse menu-dropdown {{ $isInquirySection ? 'show' : '' }}" id="sidebarInquiries">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ $isWebsiteInquirySection ? 'active' : 'collapsed' }}" href="#sidebarWebsiteInquiries" data-bs-toggle="collapse" role="button" aria-expanded="{{ $isWebsiteInquirySection ? 'true' : 'false' }}" aria-controls="sidebarWebsiteInquiries">Site inquiries<span class="menu-arrow"></span></a>
                                <div class="collapse menu-dropdown {{ $isWebsiteInquirySection ? 'show' : '' }}" id="sidebarWebsiteInquiries">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.inquiries.index') && $isWebsiteInquirySection && ! request()->query('status') ? 'active' : '' }}" href="{{ route('admin.inquiries.index', ['source' => 'website']) }}">All</a></li>
                                        @foreach (['new' => 'New', 'contacted' => 'Contacted', 'cancelled' => 'Cancelled'] as $statusValue => $statusLabel)
                                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.inquiries.index') && $isWebsiteInquirySection && request()->query('status') === $statusValue ? 'active' : '' }}" href="{{ route('admin.inquiries.index', ['source' => 'website', 'status' => $statusValue]) }}">{{ $statusLabel }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $isPackageInquirySection ? 'active' : 'collapsed' }}" href="#sidebarPackageInquiries" data-bs-toggle="collapse" role="button" aria-expanded="{{ $isPackageInquirySection ? 'true' : 'false' }}" aria-controls="sidebarPackageInquiries">Package inquiries<span class="menu-arrow"></span></a>
                                <div class="collapse menu-dropdown {{ $isPackageInquirySection ? 'show' : '' }}" id="sidebarPackageInquiries">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.inquiries.index') && $isPackageInquirySection && ! request()->query('status') ? 'active' : '' }}" href="{{ route('admin.inquiries.index', ['source' => 'package']) }}">All</a></li>
                                        @foreach (['new' => 'New', 'contacted' => 'Contacted', 'cancelled' => 'Cancelled'] as $statusValue => $statusLabel)
                                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.inquiries.index') && $isPackageInquirySection && request()->query('status') === $statusValue ? 'active' : '' }}" href="{{ route('admin.inquiries.index', ['source' => 'package', 'status' => $statusValue]) }}">{{ $statusLabel }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.newsletter-subscribers.*') ? 'active' : '' }}" href="{{ route('admin.newsletter-subscribers.index') }}">
                        <i class="ri-mail-send-line"></i><span>Newsletter subscribers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.bookings.*') ? 'active' : 'collapsed' }}" href="#sidebarBookings" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->routeIs('admin.bookings.*') ? 'true' : 'false' }}" aria-controls="sidebarBookings">
                        <i class="ri-calendar-check-line"></i><span>Bookings</span><span class="menu-arrow"></span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('admin.bookings.*') ? 'show' : '' }}" id="sidebarBookings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.bookings.index') && ! request()->query('status') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}">All bookings</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->query('status') === 'new' && request()->routeIs('admin.bookings.*') ? 'active' : '' }}" href="{{ route('admin.bookings.index', ['status' => 'new']) }}">New</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->query('status') === 'processing' && request()->routeIs('admin.bookings.*') ? 'active' : '' }}" href="{{ route('admin.bookings.index', ['status' => 'processing']) }}">Processing</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->query('status') === 'confirmed' && request()->routeIs('admin.bookings.*') ? 'active' : '' }}" href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}">Confirmed</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->query('status') === 'canceled' && request()->routeIs('admin.bookings.*') ? 'active' : '' }}" href="{{ route('admin.bookings.index', ['status' => 'canceled']) }}">Canceled</a></li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title"><span>Package management</span></li>
                <li class="nav-item"><a class="nav-link menu-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}" href="{{ route('admin.packages.index') }}"><i class="ri-map-2-line"></i><span>Packages</span></a></li>
                <li class="nav-item"><a class="nav-link menu-link {{ request()->routeIs('admin.package-departures.*') ? 'active' : '' }}" href="{{ route('admin.package-departures.index') }}"><i class="ri-calendar-event-line"></i><span>Departures</span></a></li>
                <li class="nav-item"><a class="nav-link menu-link {{ request()->routeIs('admin.package-reviews.*') ? 'active' : '' }}" href="{{ route('admin.package-reviews.index') }}"><i class="ri-chat-quote-line"></i><span>Package reviews</span></a></li>

                <li class="menu-title"><span>Website content &amp; settings</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.master.*', 'admin.categories.*', 'admin.subcategories.*', 'admin.destinations.*', 'admin.faqs.*', 'admin.guest-reviews.*', 'admin.team-members.*', 'admin.why-travel-reasons.*', 'admin.about-page.*', 'admin.approach-page.*', 'admin.site-settings.*') ? 'active' : 'collapsed' }}" href="#sidebarContent" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->routeIs('admin.master.*', 'admin.categories.*', 'admin.subcategories.*', 'admin.destinations.*', 'admin.faqs.*', 'admin.guest-reviews.*', 'admin.team-members.*', 'admin.why-travel-reasons.*', 'admin.about-page.*', 'admin.approach-page.*', 'admin.site-settings.*') ? 'true' : 'false' }}" aria-controls="sidebarContent">
                        <i class="ri-pages-line"></i><span>Content &amp; settings</span><span class="menu-arrow"></span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('admin.master.*', 'admin.categories.*', 'admin.subcategories.*', 'admin.destinations.*', 'admin.faqs.*', 'admin.guest-reviews.*', 'admin.team-members.*', 'admin.why-travel-reasons.*', 'admin.about-page.*', 'admin.approach-page.*', 'admin.site-settings.*') ? 'show' : '' }}" id="sidebarContent">
                        <ul class="nav nav-sm flex-column">
                            <li class="menu-title"><span>Travel structure</span></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.destinations.*') ? 'active' : '' }}" href="{{ route('admin.destinations.index') }}">Destinations</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Categories</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}" href="{{ route('admin.subcategories.index') }}">Subcategories</a></li>
                            <li class="menu-title"><span>Site content</span></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}" href="{{ route('admin.faqs.index') }}">FAQs</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.guest-reviews.*') ? 'active' : '' }}" href="{{ route('admin.guest-reviews.index') }}">Guest reviews</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.team-members.*') ? 'active' : '' }}" href="{{ route('admin.team-members.index') }}">Team members</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.why-travel-reasons.*') ? 'active' : '' }}" href="{{ route('admin.why-travel-reasons.index') }}">Why Choose Us</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.about-page.*') ? 'active' : '' }}" href="{{ route('admin.about-page.edit') }}">About Us page</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.approach-page.*') ? 'active' : '' }}" href="{{ route('admin.approach-page.edit') }}">Our Approach page</a></li>
                            <li class="menu-title"><span>Configuration</span></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.site-settings.*') ? 'active' : '' }}" href="{{ route('admin.site-settings.edit') }}">Site settings</a></li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title"><span>Access</span></li>
                <li class="nav-item"><a class="nav-link menu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="ri-shield-user-line"></i><span>Users</span></a></li>
            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>
