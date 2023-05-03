@extends('layouts.app')

@section('content')
    <div class="row mb-4 d-flex flex-row">
        <div class="col col-sm-12 margin-tb">
            <div class="row">
                <div class="col col-sm-8">
                    <h2 class="mb-0">Create Student</h2>
                </div>
                <div class="col col-sm-4 d-flex justify-content-end">
                    <a class="btn btn-secondary" href="{{ $referrer }}"> Back</a>
                </div>
                <h3 class="h5 mt-2">{{ $evaluation->discipline->name }} - {{ $evaluation->date->format('F j, Y') }}</h3>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="m-0">{{ $message }}</p>
        </div>
    @endif

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


    {!! Form::open(array('route' => 'students.store','method'=>'POST')) !!}
        <div class="row">
            <div class="col-sm-12 @if($canAddResults) col-md-6 @endif">
                <div class="form-group">
                    <label class="form-label" for="name">Student Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="instructor_id">Instructor Name <span class="text-danger">*</span></label>
                    <select id="instructor_id" name="instructor_id" class="form-select">
                        <option selected value="">Select...</option>
                        @foreach($instructors as $instructor)
                            <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="current_belt_id">Current Belt <span class="text-danger">*</span></label>
                    <select id="current_belt_id" name="current_belt_id" class="form-select">
                        <option selected value="">Select...</option>
                        @foreach($belts as $belt)
                            <option value="{{ $belt->id }}">{{ $belt->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="has_stripes">Has Stripes? <span class="text-danger">*</span></label>
                    <select id="has_stripes" name="has_stripes" class="form-select">
                        <option selected value="">Select...</option>
                        @foreach(range(0, 8) as $stripe)
                            <option value="{{ $stripe }}">{{ $stripe }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="months_practice">How Many Months Practicing? <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="months_practice">
                </div>
                <div class="form-group">
                    <label class="form-label" for="age">Student's Age <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="age">
                </div>
                <div class="form-group">
                    <p class="form-label">Does this student require a Patch only, or Belt and Patch? <span class="text-danger">*</span></p>
                    @foreach($evaluationOptions as $evaluationOption)
                        <div class="form-check form-check-inline">
                            <input type="radio" id="{{ strtolower(str_replace(' ', '_', $evaluationOption)) }}" name="evaluating_for" value="{{ $evaluationOption }}">
                            <label for="{{ strtolower(str_replace(' ', '_', $evaluationOption)) }}">{{ $evaluationOption }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <p class="form-label">Is Evaluation Paid? <span class="text-danger">*</span></p>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="yes" name="is_paid" value="1">
                        <label for="yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="no" name="is_paid" value="0">
                        <label for="no">No</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="receipt_number">Receipt No.</label>
                    <input type="text" class="form-control" name="receipt_number">
                </div>
            </div>

            @if ($canAddResults)
                <div class="col-sm-12 col-md-6">
                    @foreach(range(1, 6) as $n)
                        <div class="form-group">
                            <p class="form-label">Activity {{ $n }}</p>
                            @foreach(range(0, 4) as $i)
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="activity_{{ $n }}_{{ $i }}" name="activity_{{ $n }}" value="{{ $i }}">
                                    <label class="ml-1" for="activity_{{ $n }}_{{ $i }}">{{ $i }}</label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <div class="form-group">
                        <label class="form-label" for="received_belt_id">Received Belt</label>
                        <select name="received_belt_id" class="form-select">
                            <option selected value="">Select...</option>
                            @foreach($belts as $belt)
                                <option value="{{ $belt->id }}">{{ $belt->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="received_stripes">Received Stripes?</label>
                        <select name="received_stripes" class="form-select">
                            <option selected value="">Select...</option>
                            @foreach(range(0, 8) as $stripe)
                                <option value="{{ $stripe }}">{{ $stripe }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="notes">Itinerant Notes</label>
                        <textarea class="form-control" name="notes"></textarea>
                    </div>
                </div>
            @endif
            <input type="hidden" class="form-control" name="evaluation_id" value="{{ $evaluation->id }}">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 text-end">
                <a class="btn btn-secondary mr-2" href="{{ $referrer }}"> Back</a>
                <button type="submit" class="btn btn-primary">Save & Create Another</button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
