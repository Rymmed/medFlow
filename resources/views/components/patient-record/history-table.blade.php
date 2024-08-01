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
