@props(['examResults', 'medicalRecord'])
<div class="card">
    <div class="card-header pb-0">
        <div class="d-flex flex-row justify-content-between">
            <div>
                <h5 class="mb-0">Bilans Médicaux</h5>
            </div>
        </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                <tr>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Type de bilan
                    </th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Date
                    </th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Document
                    </th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Résultat
                    </th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($examResults as $examResult)
                    <tr>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0 text-capitalize">{{ ($examResult->type) }}</p>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($examResult->date)->format('d M, Y') }}</p>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0"><a
                                    href="{{ route('download.doc', $examResult->doc) }}"
                                    class="text-primary btn-sm mt-2" target="_blank">
                                    <i class="fas fa-download me-1"></i>
                                </a></p>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">
                                {{ ($examResult->result)? : '' }}
                            </p>
                        </td>
                        <td class="text-center">

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
