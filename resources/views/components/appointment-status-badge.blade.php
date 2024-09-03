@props(['status'])
@if($status === \App\Enums\AppointmentStatus::PENDING)
<span class="badge-pro badge-sm badge-primary">{{$status}}</span>
@elseif( $status === \App\Enums\AppointmentStatus::PENDING_RESCHEDULE)
    <span class="badge-pro badge-sm badge-primary">{{$status}}</span>
@elseif( $status === \App\Enums\AppointmentStatus::CONFIRMED)
<span class="badge-pro badge-sm badge-success">{{$status}}</span>
@elseif( $status === \App\Enums\AppointmentStatus::REFUSED)
    <span class="badge-pro badge-sm badge-danger">{{$status}}</span>
@elseif( $status === \App\Enums\AppointmentStatus::CANCELLED)
    <span class="badge-pro badge-sm badge-secondary">{{$status}}</span>
@elseif( $status === \App\Enums\AppointmentStatus::COMPLETED)
    <span class="badge-pro badge-sm badge-info">{{$status}}</span>
@elseif( $status === \App\Enums\AppointmentStatus::STARTED)
    <span class="badge-pro badge-sm badge-warning">{{$status}}</span>
@endif
