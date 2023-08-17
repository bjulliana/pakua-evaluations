@extends('layouts.app')

@section('content')
    <div class="row mb-4 d-flex flex-row">
        <div class="col col-sm-12 margin-tb">
            <div class="row">
                <div class="col col-sm-8">
                    <h2 class="mb-0">{{ $itinerancy->name }}</h2>
                </div>
                <div class="col col-sm-4 d-flex justify-content-end">
                    <a class="btn btn-secondary" href="{{ route('itinerancies.index') }}"> Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-4 d-flex flex-row">
        <div class="col col-sm-12 margin-tb">
            <div class="row">
                <div class="col col-sm-8">
                    <h3 class="mb-0">Evaluations</h3>
                </div>
                <div class="col col-sm-4 d-flex justify-content-end">
                    @can('evaluation-create')
                        <a class="btn btn-success" href="{{ url('evaluations/create', [ "itinerancy_id" => $itinerancy->id ]) }}"> Create New Evaluation</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="m-0">{{ $message }}</p>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Discipline</th>
                    <th>Date</th>
                    <th style="text-align: center">Actions</th>
                </tr>
            </thead>
            @foreach ($evaluations as $key => $evaluation)
                <tr class="align-middle">
                    <td>{{ $evaluation->id }}</td>
                    <td>{{ $evaluation->discipline->name }}</td>
                    <td>{{ $evaluation->date->format('F j, Y') }}</td>
                    <td align="right">
                        @if (is_countable($evaluation->students) && count($evaluation->students) > 0)
                            @role(['Admin', 'Itinerant'])
                                <a class="btn btn-success" href="{{ route('results', $evaluation->id) }}">Results</a>
                            @endrole
                        @endif
                        @if (is_countable($evaluation->students) && count($evaluation->students) > 0)
                            @role(['Admin', 'Itinerant'])
                                <a class="btn btn-primary" href="{{ route('itinerant_view', $evaluation->id) }}">Itinerant View</a>
                            @endrole
                        @endif
                        <a class="btn btn-info" href="{{ route('evaluations.show', $evaluation->id) }}">View Students</a>
                        @can('evaluation-edit')
                            <a class="btn btn-primary" href="{{ route('evaluations.edit',$evaluation->id) }}">Edit</a>
                        @endcan
                        @can('evaluation-delete')
                            <button type="button" class="delete-evaluation-btn btn btn-danger" data-name="{{ $evaluation->discipline->name }}" data-value="{{ route('evaluations.destroy', $evaluation->id) }}">
                                Delete
                            </button>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>

        {{-- Delete Modal --}}
        <div class="modal fade" tabindex="-1" id="delete-evaluation-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fs-5">Are you sure you want to delete <span class="fw-bold" id="evaluation-name"></span> Evaluation?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        {!! Form::open(['id' => 'delete-evaluation', 'method' => 'DELETE','route' => ['evaluations.destroy', $itinerancy->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
