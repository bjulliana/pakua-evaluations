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
                    <th>Name</th>
                    <th>Current Belt</th>
                    <th>Action</th>
                </tr>
            </thead>
            @foreach ($students as $key => $student)
                <tr class="align-middle">
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td><span class="badge bg-{{ $student->currentBelt->badgeClass() }}">{{ $student->currentBelt->name }}</span></td>
                    <td align="right">
                        @can('student-edit')
                            <a class="btn btn-primary" href="{{ route('students.edit',$student->id) }}">Edit</a>
                        @endcan
                        @can('student-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['students.destroy', $student->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
