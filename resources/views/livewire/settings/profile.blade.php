<section>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">{{ __('Profile') }}</h4>
                    <p class="text-muted mb-0 mt-1">{{ __('Manage your account details') }}</p>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Admin') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Profile') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-xxl-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-1">{{ __('Personal information') }}</h5>
                    <p class="text-muted mb-0">{{ __('Update your name and email address') }}</p>
                </div>

                <div class="card-body">
                    <form wire:submit="updateProfileInformation" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="profile-name" class="form-label">{{ __('Name') }}</label>
                                <input
                                    id="profile-name"
                                    type="text"
                                    wire:model="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    autocomplete="name"
                                    required
                                    autofocus
                                >
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="profile-email" class="form-label">{{ __('Email address') }}</label>
                                <input
                                    id="profile-email"
                                    type="email"
                                    wire:model="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    autocomplete="email"
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            @if ($this->hasUnverifiedEmail)
                                <div class="col-12">
                                    <div class="alert alert-warning mb-0" role="status">
                                        <i class="ri-error-warning-line me-1 align-middle"></i>
                                        {{ __('Your email address is unverified.') }}
                                        <button type="button" class="btn btn-link p-0 align-baseline" wire:click.prevent="resendVerificationNotification">
                                            {{ __('Resend verification email') }}
                                        </button>
                                    </div>
                                </div>
                            @endif

                            <div class="col-12 d-flex justify-content-end border-top pt-3 mt-2">
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="updateProfileInformation">
                                    <span wire:loading.remove wire:target="updateProfileInformation">
                                        <i class="ri-save-line align-bottom me-1"></i>{{ __('Save changes') }}
                                    </span>
                                    <span wire:loading wire:target="updateProfileInformation">
                                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>{{ __('Saving...') }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>

                    @if ($this->showDeleteUser)
                        <div class="border-top mt-4 pt-4">
                            <livewire:settings.delete-user-form />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
