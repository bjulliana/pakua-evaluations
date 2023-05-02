@extends('layouts.app')


@section('content')
    <div class="row mb-4 d-flex flex-row">
        <div class="col col-sm-12 margin-tb">
            <div class="row">
                <div class="col col-sm-8">
                    <h2 class="mb-0">Edit Evaluation</h2>
                </div>
                <div class="col col-sm-4 d-flex justify-content-end">
                    <a class="btn btn-primary" href="{{ route('itinerancies.show', $evaluation->itinerancy_id) }}"> Back</a>
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


    {!! Form::model($evaluation, ['method' => 'PATCH','route' => ['evaluations.update', $evaluation->id]]) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-label" for="discipline">Discipline</label>
                <select name="discipline" class="form-select">
                    @foreach($disciplines as $discipline)
                        <option value="{{ $discipline->id }}" @if($discipline->id === $evaluation->discipline_id) selected @endif>{{ $discipline->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mt-3">
                <label class="form-label" for="date-input">Date</label>
                <input id="date-input" type="date" class="form-control" name="date" value="{{ $evaluation->date->format('Y-m-d') }}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-left mt-3 text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
