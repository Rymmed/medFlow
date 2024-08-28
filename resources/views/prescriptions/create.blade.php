@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <x-prescription.create-form></x-prescription.create-form>
            </div>
            <div class="col-md-8">
                <x-prescription.prescription-table></x-prescription.prescription-table>
            </div>
        </div>

    </div>

    <script>
        let prescriptionId = null;

        document.getElementById('prescription-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('{{ route('prescription.store', ['report_id' => $report->id]) }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        prescriptionId = data.prescription_id;
                        showMessage('Ordonnance Créée avec succès', true);
                        // alert('Prescription created successfully!');
                        // Disable the prescription form after creation
                        document.getElementById('prescription-form').querySelector('button[type="submit"]').disabled = true;
                    } else {
                        alert('Error creating prescription');
                        showMessage('Echec dans la création de l\'ordonnance', false);
                    }
                });
        });

        document.getElementById('add-line-form').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!prescriptionId) {
                showMessage('Vous devez créer l\'ordonnance avant', false);
                // alert('You need to create a prescription first.');
                return;
            }

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

                        // Clear form fields
                        document.getElementById('add-line-form').reset();
                        $('lineModal').modal('hide');
                    } else {
                        alert('Error adding prescription line');
                        $('add-line-form').modal('hide');
                        showMessage('Echec dans l\'ajout d\'une ligne', false);
                    }
                });
        });
    </script>
@endsection
