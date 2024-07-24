@props(['consultationReports', 'patient'])
<!-- Afficher les liens de pagination -->
<div class="d-flex justify-content-center mt-3">
    {{ $consultationReports->links() }}
</div>
<div class="card-header pb-0">
    <div class="d-flex flex-row justify-content-between">
        <div>
            <h5 class="mb-0">Rapports de consultation</h5>
        </div>
    </div>
</div>
<div class="card-body px-0 pt-0 pb-2">
    <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
            <thead>
            <tr>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Type de visit
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Date
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Date de modification
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Médecin
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Type de consultation
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($consultationReports as $consultationReport)
                <tr>
                    <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0 text-capitalize">{{ ($consultationReport->visit_type) }}</p>
                    </td>
                    <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($consultationReport->created_at)->format('d M, Y') }}</p>
                    </td>
                    <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($consultationReport->updated_at)->format('d M, Y') }}</p>
                    </td>
                    <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">
                            {!! auth()->user()->id === $consultationReport->doctor_id
                            ? 'Moi'
                            : 'Dr. ' . $consultationReport->doctor->lastName . ' ' . $consultationReport->doctor->firstName
                        !!}
                    </td>
                    <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">
                            <x-consultation-type-badge
                                :consultation_type="$consultationReport->appointment->consultation_type"></x-consultation-type-badge>
                        </p>
                    </td>
                    {{--                    <td class="align-middle text-center text-sm">--}}
                    {{--                        <p class="text-xs font-weight-bold mb-0"><a--}}
                    {{--                                href="{{ route('consultationReport.show', ['consultationReport' => $consultationReport->id]) }}">Voir--}}
                    {{--                                le rapport</a></p>--}}
                    {{--                    </td>--}}
                    <td class="text-center text-sm">
                        @if(Auth::user()->role === 'doctor')
                            <div class="dropdown">
                                <a href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false"
                                   style="cursor: pointer;">
                                    <span>
                                    <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-start">
                                    <li><a class="dropdown-item border-radius-md"
                                           href="{{ route('consultationReport.show', ['consultationReport' => $consultationReport->id]) }}">Afficher</a>
                                    </li>
                                    @if(auth()->user()->id === $consultationReport->doctor_id)
                                        <li><a class="dropdown-item border-radius-md"
                                               href="{{ route('consultationReport.edit', ['consultationReport' => $consultationReport->id]) }}">Éditer</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @else
                            <p class="text-xs font-weight-bold mb-0"><a
                                    href="{{ route('consultationReport.show', ['consultationReport' => $consultationReport->id]) }}">Voir
                                    le rapport</a></p>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
