@extends('layouts.app')


@section('content')
    <div class="row mb-4 d-flex flex-row">
        <div class="col col-sm-12 margin-tb">
            <div class="row">
                <div class="col col-sm-8">
                    <h2 class="mb-0">Itinerancy Management</h2>
                </div>
                <div class="col col-sm-4 d-flex justify-content-end">
                    @can('itinerancy-create')
                        <a class="btn btn-success" href="{{ route('itinerancies.create') }}"> Create New Itinerancy</a>
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
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        @foreach ($data as $key => $itinerancy)
            <tr class="align-middle">
                <td>{{ $itinerancy->id }}</td>
                <td>{{ $itinerancy->name }}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('itinerancies.show', $itinerancy->id) }}">View</a>
                    @can('itinerancy-edit')
                        <a class="btn btn-primary" href="{{ route('itinerancies.edit',$itinerancy->id) }}">Edit</a>
                    @endcan
                    @can('itinerancy-delete')
                        {!! Form::open(['method' => 'DELETE','route' => ['itinerancies.destroy', $itinerancy->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    @endcan
                </td>
            </tr>
        @endforeach
    </table>


    {!! $data->render() !!}
@endsection
