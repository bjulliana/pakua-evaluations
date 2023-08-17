@extends('layouts.app')

@section('content')
    <div class="row mb-4 d-flex flex-row">
        <div class="col col-sm-12 margin-tb">
            <div class="row">
                <div class="col col-sm-8">
                    <h2 class="mb-0">{{ $evaluation->discipline->name }} - {{ $evaluation->date->format('F j, Y') }}</h2>
                </div>
                <div class="col col-sm-4 d-flex justify-content-end">
                    <a class="btn btn-secondary" href="{{ route('itinerancies.show', $evaluation->itinerancy_id) }}"> Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-4 d-flex flex-row">
        <div class="col col-sm-12 margin-tb">
            <div class="row">
                <div class="col col-sm-8">
                    <h3 class="mb-0">Students</h3>
                </div>
                <div class="col col-sm-4 d-flex justify-content-end">
                    @can('student-create')
                        <a class="btn btn-success" href="{{ url('students/create', [ "evaluation_id" => $evaluation->id ]) }}"> Create New Student</a>
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
                <tr class="align-middle">
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Current Belt</th>
                    <th>Action</th>
                </tr>
            </thead>
            @foreach ($students as $key => $student)
                <tr class="align-middle">
                    <td>{{ $student->id }}</td>
                    <td>@if ($student->photo) <img class="student-photo" src="{{ asset('storage/public/images/' . $student->photo) }}"/> @else - @endif</td>
                    <td>{{ $student->name }}</td>
                    <td><span class="badge bg-{{ $student->currentBelt?->badgeClass() }}">{{ $student->currentBelt?->name }}</span></td>
                    <td align="right">
                        @can('student-edit')
                            <a class="btn btn-primary" href="{{ route('students.edit',$student->id) }}">Edit</a>
                        @endcan
                        @can('student-delete')
                            <button type="button" class="delete-student-btn btn btn-danger" data-name="{{ $student->name }}" data-value="{{ route('students.destroy', $student->id) }}">
                                Delete
                            </button>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>

        {{-- Delete Modal --}}
        <div class="modal fade" tabindex="-1" id="delete-student-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fs-5">Are you sure you want to delete student <span class="fw-bold" id="student-name"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        {!! Form::open(['id' => 'delete-student', 'method' => 'DELETE','style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
