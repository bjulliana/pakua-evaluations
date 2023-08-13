@extends('layouts.app')

@section('content')
    <div class="row mb-4 d-flex flex-row">
        <div class="col col-sm-12 margin-tb">
            <div class="row">
                <div class="col-sm-12 col-md-7 col-lg-8">
                    <h2 class="mb-0">{{ $evaluation->discipline->name }} - {{ $evaluation->date->format('F j, Y') }}</h2>
                </div>
                <div class="col-sm-12 col-md-5 col-lg-4 d-md-flex justify-content-end align-items-center">
                    @can('student-create')
                        <a class="btn btn-success mr-2" href="{{ url('students/create', [ "evaluation_id" => $evaluation->id, 'from_itinerancy_view' => "true" ]) }}"> Create New Student</a>
                    @endcan
                    <a class="btn btn-secondary" href="{{ route('itinerancies.show', $evaluation->itinerancy_id) }}"> Back</a>
                </div>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="m-0">{{ $message }}</p>
        </div>
    @endif

    {!! Form::open(['route' => 'itinerant_view_update', 'method'=>'POST', 'id' => 'itinerant-form']) !!}
        <div class="accordion accordion-flush" id="students-accordion">
            @foreach ($students as $key => $student)
                <div class="accordion-item" data-student="{{ $student->id }}">
                    <h2 class="accordion-header" id="heading-student-{{ $student->id }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-student-{{ $student->id }}" aria-expanded="true" aria-controls="#collapse-student-{{ $student->id }}">
                            <div class="title-row">
                                <span class="row-drag-icon"><i class="bi bi-arrows-move"></i></span>
                                <span class="row-id"><strong class="d-none d-md-inline"># </strong>{{ $student->order }}</span>
                                <span class="row-name"><strong class="d-none d-md-inline">Student: </strong>{{ $student->name }}</span>
                                <span class="row-belt d-flex align-items-center"><strong class="d-none d-md-inline mr-1">Current Belt: </strong><span class="badge bg-{{ $student->currentBelt?->badgeClass() }}">{{ $student->currentBelt?->name }}</span></span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse-student-{{ $student->id }}" class="accordion-collapse collapse show" aria-labelledby="heading-student-{{ $student->id }}" data-bs-parent="#accordionExample">
                        <div class="accordion-body pb-5">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                @if ($student->photo)
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <img class="student-photo student-photo__lg" src="{{ asset('storage/public/images/' . $student->photo) }}"/>
                                        </div>
                                        <div class="col-sm-12 col-md-8">
                                            <p><strong>Instructor: </strong> {{ $student->instructor?->name }}</p>
                                            <p><strong>Evaluating For: </strong> {{ $student->evaluating_for }}</p>
                                            <p><strong>Current Stripes: </strong> {{ $student->has_stripes }}</p>
                                        </div>
                                    </div>
                                @else
                                    <p><strong>Instructor: </strong> {{ $student->instructor?->name }}</p>
                                    <p><strong>Evaluating For: </strong> {{ $student->evaluating_for }}</p>
                                    <p><strong>Current Stripes: </strong> {{ $student->has_stripes }}</p>
                                @endif
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    @if($student->age) <p><strong>Age: </strong> {{ $student->age }}</p> @endif
                                    <p><strong>Time on Current Belt: </strong> {{ $student->months_practice }}</p>
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
                                                    <input type="radio" @if(old('activity_' . $n, (string) $student[$name]) === (string) $i) checked @endif id="students[{{ $student->id }}][activity_{{ $n }}_{{ $i }}]" name="students[{{ $student->id }}][activity_{{ $n }}]" value="{{ $i }}">
                                                    <label class="ml-1" for="students[{{ $student->id }}][activity_{{ $n }}_{{ $i }}]"><img width="20" src="{{ asset('images/' . $i . '.png') }}"></label>
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
                                                <option @if(!old('students[' . $student->id . '][received_belt_id]', $student->received_belt_id)) selected @endif value="">Select...</option>
                                                @foreach($belts as $belt)
                                                    @if ($belt->id !== 1)
                                                        <option @if(old('students[' . $student->id . '][received_belt_id]', (string) $student->received_belt_id) === (string) $belt->id) selected @endif value="{{ $belt->id }}">{{ $belt->name }}</option>
                                                    @endif
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="students[{{ $student->id }}][received_stripes]">Received Stripes?</label>
                                            <select name="students[{{ $student->id }}][received_stripes]" id=students[{{ $student->id }}][received_stripes]" class="form-select">
                                                <option @if(!old('students[' . $student->id . '][received_stripes]', $student->received_stripes)) selected @endif value="">Select...</option>
                                                @foreach(range(0, 8) as $stripe)
                                                    <option @if(old('students[' . $student->id . '][received_stripes]', (string) $student->received_stripes) === (string) $stripe) selected @endif value="{{ $stripe }}">{{ $stripe }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="students[{{ $student->id }}][notes]">Itinerant Notes</label>
                                    <textarea class="form-control" id="students[{{ $student->id }}][notes]" name="students[{{ $student->id }}][notes]">{{ old('notes', $student->notes) }}</textarea>
                                </div>
                                <input type="hidden" id="students[{{ $student->id }}][id]" name="students[{{ $student->id }}][id]" value="{{ $student->id }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <input type="hidden" id="evaluation_id" name="evaluation_id" value="{{ $evaluation->id }}">
            <input type="hidden" id="itinerancy_id" name="itinerancy_id" value="{{ $evaluation->itinerancy_id }}">

            <div class="d-flex justify-content-center">
                <div class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body"></div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>


            <div class="fixed-footer text-end">
                <div class="container">
                    <button type="submit" name="submit" value="1" class="btn btn-primary ml-2">Save</button>
                    <button type="submit" name="submit" value="0" class="btn btn-success ml-2">Save & Exit</button>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
