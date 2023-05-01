@extends('layouts.app')

@section('content')
    <div class="row mb-4 d-flex flex-row">
        <div class="col col-sm-12 margin-tb">
            <div class="row">
                <div class="col col-sm-8">
                    <h2 class="mb-0">Create Evaluation</h2>
                </div>
                <div class="col col-sm-4 d-flex justify-content-end">
                    <a class="btn btn-primary" href="{{ route('itinerancies.show', $itinerancy_id) }}"> Back</a>
                </div>
            </div>
        </div>
    </div>


    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {!! Form::open(array('route' => 'evaluations.store','method'=>'POST')) !!}
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="discipline_id">Discipline</label>
                    <select name="discipline_id" class="form-select">
                        <option selected>Select...</option>
                        @foreach($disciplines as $discipline)
                            <option value="{{ $discipline->id }}">{{ $discipline->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="date">Date</label>
                    <input id="date-input" type="date" class="form-control" name="date">
                </div>
                <input type="hidden" class="form-control" name="itinerancy_id" value="{{ $itinerancy_id }}">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
