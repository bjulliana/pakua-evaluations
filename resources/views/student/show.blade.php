@extends('layouts.app')

@section('content')
    <div class="row mb-4 d-flex flex-row">
        <div class="col col-sm-12 margin-tb">
            <div class="row">
                <div class="col col-sm-8">
                    <h2 class="mb-0">{{ $evaluation->discipline->name }} - {{ $evaluation->date->format('F j, Y') }}</h2>
                </div>
                <div class="col col-sm-4 d-flex justify-content-end">
                    <a class="btn btn-primary" href="{{ route('itinerancies.show', $evaluation->itinerancy_id) }}"> Back</a>
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

    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        @foreach ($students as $key => $student)
            <tr class="align-middle">
                <td>{{ $student->id }}</td>
                <td>{{ $student->name }}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('students.show', $student->id) }}">View</a>
                    @can('students-edit')
                        <a class="btn btn-primary" href="{{ route('students.edit',$student->id) }}">Edit</a>
                    @endcan
                    @can('students-delete')
                        {!! Form::open(['method' => 'DELETE','route' => ['students.destroy', $student->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    @endcan
                </td>
            </tr>
        @endforeach
    </table>
@endsection
