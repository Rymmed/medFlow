@props(['medicalRecord'])

<div class="row">
    <div class="col-lg-3 col-md-6 d-flex">
        <div class="card text-white bg-gradient-warning mb-3 w-100 h-auto">
            <div class="card-body text-center p-2">
                <h3 class="card-title text-white mb-3 mt-2"><i class="fa-solid fa-temperature-low"></i></h3>
                <p class="card-text display-6 font-weight-bold mb-3">
                    {{ $medicalRecord->temperature }} <span class="fs-6">°C</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 d-flex">
        <div class="card text-white bg-gradient-primary mb-3 w-100 h-auto">
            <div class="card-body text-center p-2">
                <h3 class="card-title text-white mb-3 mt-2"><i class="fa-solid fa-heart-pulse"></i></h3>
                <p class="card-text display-6 font-weight-bold mb-3" >
                    {{ $medicalRecord->heart_rate }} <span class="fs-6">bpm</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 d-flex">
        <div class="card text-white bg-gradient-info mb-3 w-100 h-auto">
            <div class="card-body text-center p-2">
                <h3 class="card-title text-white mb-3 mt-2"><i class="fas fa-solid fa-gauge-simple-high"></i></h3>
                <p class="card-text display-6 font-weight-bold mb-3" >
                    {{ $medicalRecord->blood_pressure }} <span class="fs-6">cmHg</span>
                </p>
            </div>
        </div>
    </div>

{{--    <div class="col-lg-2 col-md-4 me-2 d-flex align-items-stretch">--}}
{{--        <div class="card text-white bg-gradient-blue mb-3 w-100 h-auto">--}}
{{--            <div class="card-body text-center p-2">--}}
{{--                <h3 class="card-title text-white mb-1 mt-2"><i class="fa-solid fa-head-side-cough"></i></h3>--}}
{{--                <p class="card-text font-weight-bold" style="font-size: 2rem;">--}}
{{--                    {{ $medicalRecord->respiratory_rate }} <span class="fs-6">rpm</span>--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="col-lg-3 col-md-6 d-flex">
        <div class="card text-white bg-gradient-success mb-3 w-100 h-auto">
            <div class="card-body text-center p-2">
                <h3 class="card-title text-white mb-3 mt-2"><i class="fa-solid fa-lungs"></i></h3>
                <p class="card-text display-6 font-weight-bold mb-3" >
                    {{ $medicalRecord->oxygen_saturation }} <span class="fs-6">%</span>
                </p>
            </div>
        </div>
    </div>
</div>
