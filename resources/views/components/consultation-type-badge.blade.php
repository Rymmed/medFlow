@props(['consultation_type'])
 @if($consultation_type === \App\Enums\ConsultationType::ONLINE)
     <span class="badge-pro badge-sm badge-success">{{\App\Enums\ConsultationType::ONLINE}}</span>
 @elseif( $consultation_type === \App\Enums\ConsultationType::HOME_SERVICE)
     <span class="badge-pro badge-sm badge-info">{{ \App\Enums\ConsultationType::HOME_SERVICE }}</span>
 @else
     <span class="badge-pro badge-sm badge-primary">{{ \App\Enums\ConsultationType::IN_PERSON }}</span>
 @endif
