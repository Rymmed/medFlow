@props(['status'])

@if ($status === 0)
    <span class="badge badge-sm bg-gradient-secondary">Désactivé</span>
@else
    <span class="badge badge-sm bg-gradient-success">Activé</span>
@endif
