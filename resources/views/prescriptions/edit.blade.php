@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <x-prescription.create-form :prescription="$prescription"></x-prescription.create-form>
            </div>
            <div class="col-md-8">
                <x-prescription.prescription-table :lines="$prescription->prescriptionLines"></x-prescription.prescription-table>
            </div>
        </div>
    </div>

    <script>
        const prescriptionId = {{ $prescription->id }};

        document.getElementById('prescription-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('_method', 'PUT');

            fetch('{{ route('prescriptions.update', $prescription->id) }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showMessage('Ordonnance mise à jour avec succès', true);
                        document.getElementById('prescription-form').querySelector('button[type="submit"]').disabled = true;
                    } else {
                        showMessage('Echec dans la mise à jour de l\'ordonnance', false);
                    }
                });
        });

        document.getElementById('add-line-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const lineModal = document.getElementById('LineCreationModal');
            formData.append('prescription_id', prescriptionId);

            fetch('{{ route('prescription-lines.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const table = document.getElementById('prescription-lines-table').querySelector('tbody');
                        const newRow = table.insertRow();

                        newRow.insertCell(0).textContent = data.line.name;
                        newRow.insertCell(1).textContent = data.line.dose;
                        newRow.insertCell(2).textContent = data.line.duration;

                        document.getElementById('add-line-form').reset();
                        $('#LineCreationModal').modal('hide');
                    } else {
                        showMessage('Echec dans l\'ajout d\'une ligne', false);
                    }
                });
        });
    </script>
@endsection
