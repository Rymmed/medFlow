@props(['consultation_type'])
 @if($consultation_type === \App\Enums\ConsultationType::ONLINE)
     <span class="badge badge-sm badge-success">En ligne</span>
 @elseif( $consultation_type === \App\Enums\ConsultationType::HOME_SERVICE)
     <span class="badge badge-sm badge-info">Service à domicile</span>
 @else
     <span class="badge badge-sm badge-primary">En cabinet</span>
 @endif
