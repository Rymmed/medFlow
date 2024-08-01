@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 table-responsive p-0">
                <h5>Prescriptions pour le rapport de consultation :</h5>
                <table class="table align-items-center mb-0">
                    <thead>
                    <tr>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Traitement
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Description
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date
                            de Création
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($prescriptions as $prescription)
                        <tr>
                            <td class="text-center"><p
                                    class="text-xs font-weight-bold mb-0">{{ $prescription->treatment }}</p></td>
                            <td class="text-center"><p
                                    class="text-xs font-weight-bold mb-0">{{ $prescription->description }}</p></td>
                            <td class="text-center"><p
                                    class="text-xs font-weight-bold mb-0">{{ $prescription->created_at }}</p></td>
                            <td class="text-center">
                                <a href="{{ route('prescriptions.edit', $prescription->id) }}" class="btn btn-warning">Modifier</a>
                                <form action="{{ route('prescriptions.destroy', $prescription->id) }}" method="POST"
                                      style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
