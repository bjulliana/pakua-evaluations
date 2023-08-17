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

    <div class="row my-4 d-flex flex-row">
        <div class="col col-sm-12 margin-tb">
            <div class="row">
                <div class="col col-sm-8">
                    <h3 class="mb-0">Itinerancies</h3>
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
                            <button type="button" class="delete-itinerancy-btn btn btn-danger" data-name="{{ $itinerancy->name }}" data-value="{{ route('itinerancies.destroy', $itinerancy->id) }}">
                                Delete
                            </button>
                        @endcan
                        <a class="btn btn-warning" href="{{ route('itinerancies.export', $itinerancy->id) }}">Export</a>
                    </td>
                </tr>
            @endforeach
        </table>

        {{-- Delete Modal --}}
        <div class="modal fade" tabindex="-1" id="delete-itinerancy-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fs-5">Are you sure you want to delete <span class="fw-bold" id="itinerancy-name"></span> Itinerancy?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        {!! Form::open(['id' => 'delete-itinerancy', 'method' => 'DELETE','route' => ['itinerancies.destroy', $itinerancy->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


    {!! $data->render() !!}
@endsection
