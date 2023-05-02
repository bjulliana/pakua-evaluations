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
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="m-0">{{ $message }}</p>
        </div>
    @endif

    {!! Form::open(array('route' => 'itinerant_view_update','method'=>'POST')) !!}
        <div class="accordion accordion-flush" id="students-accordion">
            @foreach ($students as $key => $student)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-student-{{ $student->id }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-student-{{ $student->id }}" aria-expanded="true" aria-controls="#collapse-student-{{ $student->id }}">
                            <div class="title-row">
                                <span class="row-id"><strong>ID: </strong>{{ $student->id }}</span>
                                <span class="row-name"><strong>Student: </strong>{{ $student->name }}</span>
                                <span class="row-age"><strong>Age: </strong>{{ $student->age }}</span>
                                <span class="row-belt"><strong>Current Belt: </strong><span class="badge bg-{{ $student->currentBelt->badgeClass() }}">{{ $student->currentBelt->name }}</span></span>
                                <span class="row-age"><strong>Current Stripes: </strong>{{ $student->has_stripes }}</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse-student-{{ $student->id }}" class="accordion-collapse collapse show" aria-labelledby="heading-student-{{ $student->id }}" data-bs-parent="#accordionExample">
                        <div class="accordion-body pb-5">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <p><strong>Instructor: </strong> {{ $student->instructor->name }}</p>
                                    <p><strong>Evaluating For: </strong> {{ $student->evaluating_for }}</p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <p><strong>Time Practicing: </strong> {{ $student->months_practice }} Months</p>
                                    <p><strong>Evaluation Paid: </strong> {{ ($student->has_paid) ? 'Yes' : 'No' }}</p>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    @foreach(range(1, 6) as $n)
                                        <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <p class="form-label">Activity {{ $n }}</p>
                                            @foreach(range(0, 4) as $i)
                                                <div class="form-check form-check-inline">
                                                    @php($name = 'activity_' . $n)
                                                    <input type="radio" @if($student[$name] === $i) checked @endif id="students[{{ $student->id }}][activity_{{ $n }}_{{ $i }}]" name="students[{{ $student->id }}][activity_{{ $n }}]" value="{{ $i }}">
                                                    <label class="ml-1" for="students[{{ $student->id }}][activity_{{ $n }}_{{ $i }}]">{{ $i }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row mt-4">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="students[{{ $student->id }}][received_belt_id]">Received Belt</label>
                                            <select id="students[{{ $student->id }}][received_belt_id]" name="students[{{ $student->id }}][received_belt_id]" class="form-select">
                                                <option selected value="">Select...</option>
                                                @foreach($belts as $belt)
                                                    <option @if($student->received_belt_id === $belt->id) selected @endif value="{{ $belt->id }}">{{ $belt->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="students[{{ $student->id }}][received_stripes]">Received Stripes?</label>
                                            <select name="students[{{ $student->id }}][received_stripes]" id=students[{{ $student->id }}][received_stripes]" class="form-select">
                                                <option selected value="">Select...</option>
                                                @foreach(range(0, 8) as $stripe)
                                                    <option @if($student->received_stripes === $stripe) selected @endif value="{{ $stripe }}">{{ $stripe }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="students[{{ $student->id }}][notes]">Itinerant Notes</label>
                                    <textarea class="form-control" id="students[{{ $student->id }}][notes]" name="students[{{ $student->id }}][notes]">{{ $student->notes }}</textarea>
                                </div>
                                <input type="hidden" id="students[{{ $student->id }}][id]" name="students[{{ $student->id }}][id]" value="{{ $student->id }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <input type="hidden" id="evaluation_id" name="evaluation_id" value="{{ $evaluation->id }}">
            <div class="fixed-footer text-end">
                <div class="container">
                    <a class="btn btn-secondary" href="{{ route('itinerancies.show', $evaluation->itinerancy_id) }}"> Back</a>
                    <button type="submit" class="btn btn-primary ml-2">Save</button>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
