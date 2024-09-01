@props(['doctor_info'])

<div class="card" id="availability-form" style="display: none;">
    <div class="card-header pb-0 px-3">
        <h6 class="mb-0">{{ __('Disponibilité') }}</h6>
    </div>
    <div class="card-body pt-4 p-3">
        <form action="{{ route('doctor_infos.update', ['doctor_info' => auth()->user()->id]) }}"
              method="POST" role="form" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if($errors->any())
                <div class="mt-3 alert alert-primary alert-dismissible fade show" role="alert">
                    <span class="alert-text text-white">{{ $errors->first() }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </button>
                </div>
            @endif

            @if(session('success'))
                <div class="m-3 alert alert-success alert-dismissible fade show" id="success-message"
                     role="alert">
                    <span class="alert-text text-white">{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="speciality" class="form-control-label">{{ __('Specialité') }}</label>
                        <div class="@error('speciality') border border-danger rounded-3 @enderror">
                            <select class="form-select" name="speciality" id="speciality">
                                <option value="{{ $doctor_info->speciality }}" selected>{{ $doctor_info->speciality }}</option>
                                @foreach(config('specialities') as $speciality)
                                    <option value="{{ $speciality }}">{{ $speciality }}</option>
                                @endforeach
                            </select>
                            @error('speciality')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="professional_card"
                               class="form-control-label">{{ __('Carte professionelle') }}</label>
                        <div class="@error('professional_card') border border-danger rounded-3 @enderror">
                            <input class="form-control" type="file" id="professional_card" name="professional_card"
                                   value="{{ $doctor_info->professional_card }}">
                            @error('professional_card')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="office_phone_number"
                               class="form-control-label">{{ __('N° téléphone du cabinet') }}</label>
                        <div class="@error('office_phone_number') border border-danger rounded-3 @enderror">
                            <input class="form-control" type="tel" id="office_phone_number" name="office_phone_number"
                                   value="{{ $doctor_info->office_phone_number }}">
                            @error('office_phone_number')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="start_time" class="form-control-label">{{ __('Heure d\'ouverture') }}</label>
                        <div class="@error('start_time') border border-danger rounded-3 @enderror">
                            <input class="form-control" type="time" id="start_time" name="start_time"
                                   value="{{ $doctor_info->start_time }}">
                            @error('start_time')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="end_time" class="form-control-label">{{ __('Heure de fermeture') }}</label>
                        <div class="@error('end_time') border border-danger rounded-3 @enderror">
                            <input class="form-control" type="time" id="end_time" name="end_time"
                                   value="{{ $doctor_info->end_time }}">
                            @error('end_time')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="days_of_week" class="form-control-label">{{ __('Jours de travail') }}</label>
                        <div class="@error('days_of_week') border border-danger rounded-3 @enderror">
                            <select class="form-control" id="days_of_week" name="days_of_week[]"
                                    aria-label="days_of_week" multiple>
                                @foreach(['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $index => $day)
                                    <option
                                        value="{{ $index }}" {{ $doctor_info->days_of_week && in_array($index, json_decode($doctor_info->days_of_week)) ? 'selected' : '' }}>{{ $day }}</option>
                                @endforeach
                            </select>
                            @error('days_of_week')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="consultation_duration"
                               class="form-control-label">{{ __('Durée de la consultation (minutes)') }}</label>
                        <div
                            class="@error('consultation_duration')border border-danger rounded-3 @enderror">
                            <input class="js-example-basic-multiple form-control" type="number"
                                   id="consultation_duration" name="consultation_duration"
                                   value="{{ $doctor_info->consultation_duration }}">
                            @error('consultation_duration')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="consultation_types"
                               class="form-control-label">{{ __('Types de consultation') }}</label>
                        <div class="@error('consultation_types') border border-danger rounded-3 @enderror">
                            <select class="form-control" id="consultation_types" name="consultation_types[]"
                                    aria-label="consultation_types" multiple>
                                @foreach(\App\Enums\ConsultationType::getValues() as $type )
                                    <option
                                        value="{{ $type }}" {{ $doctor_info->consultation_types && in_array($type, json_decode($doctor_info->consultation_types)) ? 'selected' : '' }} >{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('consultation_types')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="online_fees"
                               class="form-control-label">{{ __('Frais de consultation en ligne') }}</label>
                        <div class="@error('online_fees') border border-danger rounded-3 @enderror">
                            <input class="form-control" type="text" id="online_fees" name="online_fees"
                                   value="{{ $doctor_info->online_fees }}">
                            @error('online_fees')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="in_person_fees"
                               class="form-control-label">{{ __('Frais de consultation en cabinet') }}</label>
                        <div class="@error('in_person_fees') border border-danger rounded-3 @enderror">
                            <input class="form-control" type="text" id="in_person_fees" name="in_person_fees"
                                   value="{{ $doctor_info->in_person_fees }}">
                            @error('in_person_fees')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="home_service_fees"
                               class="form-control-label">{{ __('Frais de consultation à domicile') }}</label>
                        <div class="@error('home_service_fees') border border-danger rounded-3 @enderror">
                            <input class="form-control" type="text" id="home_service_fees" name="home_service_fees"
                                   value="{{ $doctor_info->home_service_fees }}">
                            @error('home_service_fees')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>


            </div>

            <div class="d-flex justify-content-end">
                <button type="submit"
                        class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Sauvegarder' }}</button>
            </div>
        </form>
    </div>
</div>

