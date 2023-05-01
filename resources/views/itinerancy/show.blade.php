@extends('layouts.app')

@section('content')
    <div class="row mb-4 d-flex flex-row">
        <div class="col col-sm-12 margin-tb">
            <div class="row">
                <div class="col col-sm-8">
                    <h2 class="mb-0">{{ $itinerancy->name }}</h2>
                </div>
                <div class="col col-sm-4 d-flex justify-content-end">
                    <a class="btn btn-primary" href="{{ route('itinerancies.index') }}"> Back</a>
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

    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Discipline</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        @foreach ($evaluations as $key => $evaluation)
            <tr class="align-middle">
                <td>{{ $evaluation->id }}</td>
                <td>{{ $evaluation->discipline->name }}</td>
                <td>{{ $evaluation->date->format('F j, Y') }}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('evaluations.show', $evaluation->id) }}">View</a>
                    @can('evaluation-edit')
                        <a class="btn btn-primary" href="{{ route('evaluations.edit',$evaluation->id) }}">Edit</a>
                    @endcan
                    @can('evaluation-delete')
                        {!! Form::open(['method' => 'DELETE','route' => ['evaluations.destroy', $evaluation->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    @endcan
                </td>
            </tr>
        @endforeach
    </table>
@endsection
