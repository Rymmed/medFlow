@props(['role', 'user'])

<div class="card" id="profile-form">
    <div class="card-header pb-0 px-3">
        <h6 class="mb-0">{{ __('Profil') }}</h6>
    </div>
    <div class="card-body pt-4 p-3">
        <form action="{{ route('update-profile') }}" method="POST" role="form text-left">
            @csrf
            @method('PUT')
            @if($errors->any())
                <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">
                            {{$errors->first()}}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
            @if(session('success'))
                <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success"
                     role="alert">
                            <span class="alert-text text-white">
                            {{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
            <div class="row">
                <!-- Prénom -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="firstName" class="form-control-label">{{ __('Prénom') }}</label>
                        <div class="@error('user.firstName')border border-danger rounded-3 @enderror">
                            <input class="form-control" value="{{ auth()->user()->firstName}}" type="text"
                                   placeholder="{{ __('Entrez votre prénom') }}" id="firstName"
                                   name="firstName">
                            @error('firstName')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Nom -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="lastName" class="form-control-label">{{ __('Nom') }}</label>
                        <div class="@error('user.lastName')border border-danger rounded-3 @enderror">
                            <input class="form-control" value="{{ auth()->user()->lastName}}" type="text"
                                   placeholder="{{ __('Entrez votre nom') }}" id="lastName" name="lastName">
                            @error('lastName')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Email -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email" class="form-control-label">{{ __('Email') }}</label>
                        <div class="@error('email')border border-danger rounded-3 @enderror">
                            <input class="form-control" value="{{ auth()->user()->email }}" type="email"
                                   placeholder="{{ __('Entrez votre adresse email') }}" id="email"
                                   name="email">
                            @error('email')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Date de naissance -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="dob" class="form-control-label">{{ __('Date de naissance') }}</label>
                        <div class="@error('dob')border border-danger rounded-3 @enderror">
                            <input class="form-control" value="{{ auth()->user()->dob }}" type="date"
                                   id="dob" name="dob">
                            @error('dob')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Numéro de téléphone -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="phone_number"
                               class="form-control-label">{{ __('Numéro de téléphone') }}</label>
                        <div class="@error('user.phone_number')border border-danger rounded-3 @enderror">
                            <input class="form-control" type="text"
                                   placeholder="{{ __('Entrez votre numéro de téléphone') }}"
                                   id="phone_number" name="phone_number"
                                   value="{{ auth()->user()->phone_number }}">
                            @error('phone_number')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                @if(auth()->user()->role === 'patient')
                    <!-- Numéro de CIN -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cin_number"
                                   class="form-control-label">{{ __('Numéro de CIN') }}</label>
                            <div class="@error('user.cin_number')border border-danger rounded-3 @enderror">
                                <input class="form-control" type="text"
                                       placeholder="{{ __('Entrez votre numéro d\'identité nationnale') }}"
                                       id="cin_number" name="cin_number"
                                       value="{{ auth()->user()->cin_number }}">
                                @error('cin_number')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Numéro d'assurance -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="insurance_number"
                                   class="form-control-label">{{ __('Numéro d\'assurance') }}</label>
                            <div
                                class="@error('user.insurance_number')border border-danger rounded-3 @enderror">
                                <input class="form-control" type="text"
                                       placeholder="{{ __('Entrez votre numéro d\'assurance') }}"
                                       id="insurance_number" name="insurance_number"
                                       value="{{ auth()->user()->insurance_number }}">
                                @error('insurance_number')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit"
                        class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Sauvegarder' }}</button>
            </div>
        </form>
    </div>
</div>
