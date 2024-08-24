<div class="card mt-4" id="security-form">
    <div class="card-header pb-0 px-3">
        <h6 class="mb-0">{{ __('Mot de passe et Sécuité') }}</h6>
    </div>
    <div class="card-body pt-4 p-3">
        <form action="{{ route('update-password') }}" method="POST" role="form text-left">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="current_password"
                               class="form-control-label">{{ __('Mot de passe actuel') }}</label>
                        <input
                            class="form-control @error('current_password') border border-danger rounded-3 @enderror"
                            type="password" placeholder="{{ __('Entrez votre mot de passe actuel') }}"
                            id="current_password" name="current_password">
                        @error('current_password')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="new_password"
                               class="form-control-label">{{ __('Nouveau mot de passe') }}</label>
                        <input
                            class="form-control @error('new_password') border border-danger rounded-3 @enderror"
                            type="password" placeholder="{{ __('Entrez votre nouveau mot de passe') }}"
                            id="new_password" name="new_password">
                        @error('new_password')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="new_password_confirmation"
                               class="form-control-label">{{ __('Confirmation du mot de passe') }}</label>
                        <input
                            class="form-control @error('new_password_confirmation') border border-danger rounded-3 @enderror"
                            type="password" placeholder="{{ __('Confirmez votre mot de passe') }}"
                            id="new_password_confirmation" name="new_password_confirmation">
                        @error('new_password_confirmation')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit"
                        class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ __('Sauvegarder') }}</button>
            </div>
        </form>
    </div>
</div>
