@php($isCurrentUser = auth()->id() === $user->id)

<form action="{{ $action }}" method="POST" class="needs-validation" novalidate>
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Account details</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full name <span class="text-danger">*</span></label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" maxlength="255" required autofocus autocomplete="name" aria-describedby="name-feedback">
                        @error('name')<div class="invalid-feedback" id="name-feedback">{{ $message }}</div>@else<div class="invalid-feedback" id="name-feedback">Enter a name.</div>@enderror
                    </div>
                    <div>
                        <label for="email" class="form-label">Email address <span class="text-danger">*</span></label>
                        @if ($isCurrentUser)
                            <input id="email" type="email" value="{{ $user->email }}" class="form-control" readonly>
                            <input type="hidden" name="email" value="{{ $user->email }}">
                        @else
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" maxlength="255" required autocomplete="email" aria-describedby="email-feedback">
                            @if ($method !== 'POST')<div class="form-text">Changing the email address resets its verification status.</div>@endif
                        @endif
                        @error('email')<div class="invalid-feedback" id="email-feedback">{{ $message }}</div>@else<div class="invalid-feedback" id="email-feedback">Enter a valid email address.</div>@enderror
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ $method === 'POST' ? 'Set password' : 'Change password' }}</h5>
                </div>
                <div class="card-body">
                    @if ($method !== 'POST')
                        <p class="text-muted">Leave both password fields blank to keep the current password.</p>
                    @endif
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">{{ $method === 'POST' ? 'Password' : 'New password' }} @if ($method === 'POST')<span class="text-danger">*</span>@endif</label>
                            <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" data-password-field="password" data-password-required="{{ $method === 'POST' ? 'true' : 'false' }}" @required($method === 'POST') aria-describedby="password-feedback">
                            @error('password')<div class="invalid-feedback" id="password-feedback">{{ $message }}</div>@else<div class="invalid-feedback" id="password-feedback">{{ $method === 'POST' ? 'Enter a password.' : 'Enter a new password to change it.' }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm password @if ($method === 'POST')<span class="text-danger">*</span>@endif</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" data-password-field="confirmation" data-password-required="{{ $method === 'POST' ? 'true' : 'false' }}" @required($method === 'POST') aria-describedby="password-confirmation-feedback">
                            <div class="invalid-feedback" id="password-confirmation-feedback">Enter the same password in both fields.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Access and status</h5></div>
                <div class="card-body">
                    @if ($isCurrentUser)
                        <input type="hidden" name="is_admin" value="1">
                        <div class="alert alert-info">You are editing your own account. Administrator access cannot be changed here.</div>
                    @else
                        <div class="mb-3">
                            <label for="is_admin" class="form-label">Account type</label>
                            <select id="is_admin" name="is_admin" class="form-select @error('is_admin') is-invalid @enderror" required aria-describedby="is-admin-feedback">
                                <option value="0" @selected((string) old('is_admin', (int) $user->is_admin) === '0')>Traveler</option>
                                <option value="1" @selected((string) old('is_admin', (int) $user->is_admin) === '1')>Administrator</option>
                            </select>
                            @error('is_admin')<div class="invalid-feedback" id="is-admin-feedback">{{ $message }}</div>@else<div class="invalid-feedback" id="is-admin-feedback">Select an account type.</div>@enderror
                            <div class="form-text">Administrators can access the entire admin area.</div>
                        </div>
                    @endif

                    <div>
                        @if ($isCurrentUser)
                            <input type="hidden" name="email_verified" value="{{ (int) ($user->email_verified_at !== null) }}">
                            <label class="form-label">Email status</label>
                            <div><span class="badge bg-{{ $user->email_verified_at ? 'success' : 'secondary' }}-subtle text-{{ $user->email_verified_at ? 'success' : 'secondary' }}">{{ $user->email_verified_at ? 'Verified' : 'Unverified' }}</span></div>
                            <div class="form-text">Ask another administrator to change your verification status.</div>
                        @else
                        <label for="email_verified" class="form-label">Email status</label>
                        <select id="email_verified" name="email_verified" class="form-select @error('email_verified') is-invalid @enderror" required aria-describedby="email-verified-feedback">
                            <option value="0" @selected((string) old('email_verified', (int) ($user->email_verified_at !== null)) === '0')>Unverified</option>
                            <option value="1" @selected((string) old('email_verified', (int) ($user->email_verified_at !== null)) === '1')>Verified</option>
                        </select>
                        @error('email_verified')<div class="invalid-feedback" id="email-verified-feedback">{{ $message }}</div>@else<div class="invalid-feedback" id="email-verified-feedback">Select an email status.</div>@enderror
                        <div class="form-text">Use verified only after confirming this account's email address.</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-4">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i>{{ $submitLabel }}</button>
            </div>
        </div>
    </div>
</form>
