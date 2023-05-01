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
                <strong>Discipline</strong>
                <select name="discipline" class="form-select">
                    <option @if ($evaluation->discipline === "Archery") selected @endif value="Archery">Archery</option>
                    <option @if ($evaluation->discipline === "Acrobatics") selected @endif value="Acrobatics">Acrobatics</option>
                    <option @if ($evaluation->discipline === "Edged Weapons") selected @endif value="Edged Weapons">Edged Weapons</option>
                    <option @if ($evaluation->discipline === "Martial Art") selected @endif value="Martial Art">Martial Art</option>
                    <option @if ($evaluation->discipline === "Pa Kua Chi") selected @endif value="Pa Kua Chi">Pa Kua Chi</option>
                    <option @if ($evaluation->discipline === "Pa Kua Rhythm") selected @endif value="Pa Kua Rhythm">Pa Kua Rhythm</option>
                    <option @if ($evaluation->discipline === "Tai Chi") selected @endif value="Tai Chi">Tai Chi</option>
                    <option @if ($evaluation->discipline === "Sintony") selected @endif value="Sintony">Sintony</option>
                </select>
            </div>
            <div class="form-group mt-3">
                <strong>Date</strong>
                {!! Form::text('date', $evaluation->date->format('Y-m-d'), array('placeholder' => 'Date','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-left mt-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
