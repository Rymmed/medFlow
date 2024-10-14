@props(['prescription', 'report'])

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>{{ isset($prescription) ? 'Modifier l\'ordonnance' : 'Créer l\'ordonnance d\'abord' }}</h5>
                </div>
                <div class="card-body px-2 pt-0 pb-2">
                    <div id="message-container" class="mt-3 alert alert-dismissible fade show" role="alert" style="display: none;">
                        <span class="alert-text text-white"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                    </div>

                    <form id="prescription-form">
                        @csrf
                        <div class="form-group">
                            <label for="treatment">Traitement</label>
                            <input type="text" class="form-control" id="treatment" name="treatment" value="{{ $prescription->treatment ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description">{{ $prescription->description ?? '' }}</textarea>
                        </div>
                        <button type="submit" class="btn bg-gradient-success text-white">{{ isset($prescription) ? 'Mettre à jour' : 'Créer' }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <x-prescription.prescription-table :lines="$prescription->prescriptionLines ?? []"></x-prescription.prescription-table>
        </div>
    </div>
</div>

<script>
    let prescriptionId = @json($prescription->id ?? null);

    document.getElementById('prescription-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        if (prescriptionId) {
            formData.append('_method', 'PUT');
        }

        fetch(prescriptionId
                ? `{{ url('prescriptions') }}/${prescriptionId}/update`
                : `{{ route('prescription.store', ['report_id' => $report->id ?? '']) }}`,
            {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (!prescriptionId) {
                        prescriptionId = data.prescription_id;
                    }
                    showMessage(prescriptionId
                        ? 'Ordonnance mise à jour avec succès'
                        : 'Ordonnance créée avec succès', true);
                    document.getElementById('prescription-form').querySelector('button[type="submit"]').disabled = true;
                } else {
                    showMessage(prescriptionId
                        ? 'Échec dans la mise à jour de l\'ordonnance'
                        : 'Échec dans la création de l\'ordonnance', false);
                }
            });
    });

</script>
