@props(['consultation_type'])
 @if($consultation_type === 'Online')
     <span class="badge badge-sm badge-success">En ligne</span>
 @elseif( $consultation_type === 'Home service')
     <span class="badge badge-sm badge-info">Service à domicile</span>
 @else
     <span class="badge badge-sm badge-primary">En cabinet</span>
 @endif
