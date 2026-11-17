<x-admin-layouts::auth :title="__('Forgot password')">
    <main class="auth-page-wrapper pt-5">
        <div class="auth-one-bg-position auth-one-bg" id="admin-auth-background">
            <div class="bg-overlay"></div>
            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1440 120" aria-hidden="true">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none text-white">
                                <i class="ri-mountain-line fs-24"></i>
                                <span class="fs-18 fw-semibold">{{ config('app.name', 'Explore Nepal Holidays') }}</span>
                            </a>
                            <p class="mt-3 fs-15 fw-medium mb-0">{{ __('Administrator portal') }}</p>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-body p-4 p-sm-5">
                                <div class="text-center mt-2">
                                    <div class="avatar-lg mx-auto mb-4">
                                        <div class="avatar-title bg-primary-subtle text-primary display-5 rounded-circle">
                                            <i class="ri-lock-password-line" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <h5 class="text-primary">{{ __('Forgot password?') }}</h5>
                                    <p class="text-muted mb-0">{{ __('Enter your email and we will send you a link to reset your password.') }}</p>
                                </div>

                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show mt-4" role="status">
                                        {{ session('status') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger mt-4" role="alert">{{ $errors->first() }}</div>
                                @endif

                                <div class="p-2 mt-3">
                                    <form method="POST" action="{{ route('password.email') }}" class="needs-validation" novalidate>
                                        @csrf

                                        <div class="mb-4">
                                            <label for="email" class="form-label">{{ __('Email address') }}</label>
                                            <input
                                                id="email"
                                                name="email"
                                                type="email"
                                                value="{{ old('email') }}"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="email@example.com"
                                                autocomplete="email"
                                                required
                                                autofocus
                                            >
                                            <div class="invalid-feedback">
                                                @error('email'){{ $message }}@else{{ __('Please enter a valid email address.') }}@enderror
                                            </div>
                                        </div>

                                        <div class="text-center mt-4">
                                            <button class="btn btn-success w-100" type="submit">{{ __('Send reset link') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <p class="mb-0 text-muted">
                                {{ __('Wait, I remember my password.') }}
                                <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline">{{ __('Back to sign in') }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center text-muted">
                            <p class="mb-0">&copy; {{ now()->year }} {{ config('app.name', 'Explore Nepal Holidays') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </main>
</x-admin-layouts::auth>
