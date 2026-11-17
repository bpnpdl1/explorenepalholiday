<x-admin-layouts::auth :title="__('Admin sign in')">
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
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">{{ __('Welcome back') }}</h5>
                                    <p class="text-muted">{{ __('Sign in to continue to the admin dashboard.') }}</p>
                                </div>

                                @if (session('status'))
                                    <div class="alert alert-success" role="status">{{ session('status') }}</div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
                                @endif

                                <div class="p-2 mt-4">
                                    <form method="POST" action="{{ route('login.store') }}" class="needs-validation" novalidate>
                                        @csrf

                                        <div class="mb-3">
                                            <label for="email" class="form-label">{{ __('Email address') }}</label>
                                            <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="email@example.com" autocomplete="username" required autofocus>
                                            <div class="invalid-feedback">
                                                @error('email'){{ $message }}@else{{ __('Please enter a valid email address.') }}@enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="float-end">
                                                @if (Route::has('password.request'))
                                                    <a href="{{ route('password.request') }}" class="text-muted">{{ __('Forgot password?') }}</a>
                                                @endif
                                            </div>
                                            <label for="password" class="form-label">{{ __('Password') }}</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input id="password" name="password" type="password" class="form-control pe-5 password-input @error('password') is-invalid @enderror" placeholder="{{ __('Enter password') }}" autocomplete="current-password" required>
                                                <div class="invalid-feedback">
                                                    @error('password'){{ $message }}@else{{ __('Please enter your password.') }}@enderror
                                                </div>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="admin-password-addon" aria-label="{{ __('Show password') }}">
                                                    <i class="ri-eye-fill align-middle"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input id="remember" name="remember" type="checkbox" value="1" class="form-check-input" @checked(old('remember'))>
                                            <label for="remember" class="form-check-label">{{ __('Remember me') }}</label>
                                        </div>

                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-success w-100">{{ __('Sign in') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const password = document.querySelector('#password');
                const passwordAddon = document.querySelector('#admin-password-addon');

                if (!password || !passwordAddon) return;

                passwordAddon.addEventListener('click', () => {
                    const isVisible = password.type === 'text';
                    password.type = isVisible ? 'password' : 'text';
                    passwordAddon.setAttribute('aria-label', isVisible ? @js(__('Show password')) : @js(__('Hide password')));
                    passwordAddon.querySelector('i').classList.toggle('ri-eye-fill', isVisible);
                    passwordAddon.querySelector('i').classList.toggle('ri-eye-off-fill', !isVisible);
                });
            });
        </script>
    @endpush
</x-admin-layouts::auth>
