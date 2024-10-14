@props(['title'])

<div class="card-header pb-0">
    <div class="d-flex flex-row justify-content-between">
        <div>
            <h5 class="mb-0">{{ $title }}</h5>
        </div>
        <button class="btn bg-gradient-primary btn-md mb-0 glow-button" type="button"
                data-bs-toggle="modal"
                data-bs-target="#exampleModalMessage">
            <i class="far fa-calendar-plus me-1"></i> Nouveau Rendez-Vous
        </button>


        <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="exampleModalLabel">{{ __('Trouver un médecin') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close">
                                                    <span class="text-dark" aria-hidden="true"><i
                                                            class="fa fa-close"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" action="{{ route('search_doctors') }}"
                              method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <select id="speciality" name="speciality[]"
                                        class="form-control"
                                        aria-label="speciality" multiple>
                                    @foreach(config('specialities') as $speciality)
                                        <option
                                            value="{{ $speciality }}">{{ $speciality }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="form-group mb-3 col-6">
                                    <input type="text" id="city" name="city"
                                           class="form-control" aria-label="city"
                                           placeholder="Ville">
                                </div>
                                <div class="form-group mb-3 col-6">
                                    <input type="text" id="country" name="country"
                                           class="form-control" aria-label="country"
                                           placeholder="Pays">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit"
                                        class="btn bg-gradient-primary">{{ __('Rechercher') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

