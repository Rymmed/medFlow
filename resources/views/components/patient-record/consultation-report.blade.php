@props(['consultationReports'])
<div class="card">
    <div class="card-header pb-0">
        <div class="d-flex flex-row justify-content-between">
            <div>
                <h5 class="mb-0">Rapports de consultation</h5>
            </div>
            <a href="{{ route('consultationReports.index', Auth::id()) }}" class="text-info text-sm mb-0 animate-link">
                Afficher Plus <i class="fas fa-angles-right me-1 text-xs"></i>
            </a>
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
                        Date de création
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
                        <td class="align-middle text-center text-sm">
                            @if(Auth::user()->role === 'doctor')
                                <div class="dropdown">
                                    <i class="fas fa-ellipsis-v" data-bs-toggle="dropdown" aria-expanded="false"
                                       style="cursor: pointer;"></i>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item"
                                               href="{{ route('consultationReport.show', ['consultationReport' => $consultationReport->id]) }}">Afficher</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                               href="{{ route('consultationReport.edit', ['consultationReport' => $consultationReport->id]) }}">Éditer</a>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <p class="text-xs font-weight-bold mb-0"><a
                                        href="{{ route('consultationReport.show', ['consultationReport' => $consultationReport->id]) }}">Voir</a>
                                </p>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
