@props(['histories'])

<div class="table-responsive p-0">
    <table class="table align-items-center mb-0">
        @if($histories->isNotEmpty())
        <thead>
        <tr>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Titre
            </th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Description
            </th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Action
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($histories as $history)
            <tr>
                <td class="text-start">
                    <p class="text-xs font-weight-bold mb-0">{{ $history->title }}</p>
                </td>
                <td class="text-start">
                    <p class="text-xs font-weight-bold mb-0">{{ $history->description }}</p>
                </td>
                <td class="text-center">
                    <a class="text-xs font-weight-bold mb-0 edit-history-button" type="button" data-id="{{ $history->id }}"
                       data-title="{{ $history->title }}" data-description="{{ $history->description }}"
                       data-type="{{ $history->type }}" data-subtype="{{ $history->subtype }}" data-bs-toggle="modal"
                       data-bs-target="#editHistoryModal">
                        <i class="fa fa-edit text-secondary"></i>
                    </a>
{{--                    <a class="text-xs font-weight-bold mb-0 edit-history-button" type="button" data-id="{{ $history->id }}"--}}
{{--                       data-bs-toggle="modal"--}}
{{--                       data-bs-target="#deleteHistoryModal">--}}
{{--                        <i class="fa fa-trash text-secondary"></i>--}}
{{--                    </a>--}}
                    <form id="destroy-{{ $history->id }}" action="{{ route('medicalHistory.destroy', $history->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <a type="button" class="text-xs font-weight-bold mb-0 edit-history-button" data-bs-toggle="modal" data-bs-target="#confirmationModal-{{ $history->id }}"
                           data-bs-original-title="Supprimer">
                            <i class="fa fa-trash text-secondary"></i>
                        </a>
                    </form>

                    <!-- Confirmation Modal -->
                    <div class="modal fade" id="confirmationModal-{{ $history->id }}" tabindex="-1" aria-labelledby="confirmationModalLabel-{{ $history->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmationModalLabel-{{ $history->id }}">Confirmer la suppression</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Êtes-vous sûr de vouloir supprimer cet antécédent?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn bg-gradient-danger" id="confirmDelete-{{ $history->id }}" data-vaccination-id="{{ $history->id }}">Supprimer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
        @else
            <div class="p-3 mb-3">
                <p>Pas d'antécédents</p>
            </div>
        @endif
    </table>
</div>
