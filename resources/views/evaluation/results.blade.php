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
                    <h3 class="mb-0">Results</h3>
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
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Current Belt</th>
                    <th>New Belt</th>
                    <th>Stripes</th>
                </tr>
            </thead>
            @foreach ($students as $key => $student)
                <tr class="align-middle">
                    <td>@if ($student->studentData->photo) <img class="student-photo" src="{{ asset('storage/public/images/' . $student->studentData->photo) }}"/> @else - @endif</td>
                    <td>{{ $student->studentData->name }}</td>
                    <td><span class="badge bg-{{ $student->currentBelt?->badgeClass() }}">{{ $student->currentBelt?->name }}</span></td>
                    <td><span class="badge bg-{{ $student->receivedBelt?->badgeClass() }}">{{ $student->receivedBelt?->name }}</span></td>
                    <td>{{ $student->received_stripes }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
