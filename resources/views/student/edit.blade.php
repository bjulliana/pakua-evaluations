@extends('layouts.app')

@section('content')
    <div class="row mb-4 d-flex flex-row">
        <div class="col col-sm-12 margin-tb">
            <div class="row">
                <div class="col col-sm-8">
                    <h2 class="mb-0">Edit Student</h2>
                </div>
                <div class="col col-sm-4 d-flex justify-content-end">
                    <a class="btn btn-secondary" href="{{ route('evaluations.show', $evaluation->id) }}"> Back</a>
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


    {!! Form::model($student, ['method' => 'PATCH','route' => ['students.update', $student->id]]) !!}
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label class="form-label" for="name">Student Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" required value="{{old('name', $student->name)}}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="instructor_id">Instructor Name <span class="text-danger">*</span></label>
                    <select id="instructor_id" name="instructor_id" class="form-select">
                        <option @if(!old('instructor_id', $student->instructor_id)) selected @endif value="">Select...</option>
                        @foreach($instructors as $instructor)
                            <option @if(old('instructor_id', (string) $student->instructor_id) === (string) $instructor->id) selected @endif value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="current_belt_id">Current Belt <span class="text-danger">*</span></label>
                    <select id="current_belt_id" name="current_belt_id" class="form-select">
                        <option @if(!old('current_belt_id', $student->current_belt_id)) selected @endif value="">Select...</option>
                        @foreach($belts as $belt)
                            <option @if (old('current_belt_id', (string) $student->current_belt_id) === (string) $belt->id) selected @endif value="{{ $belt->id }}">{{ $belt->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="has_stripes">Has Stripes? <span class="text-danger">*</span></label>
                    <select id="has_stripes" name="has_stripes" class="form-select">
                        <option @if(!old('has_stripes', $student->has_stripes)) selected @endif value="">Select...</option>
                        @foreach(range(0, 8) as $stripe)
                            <option @if (old('has_stripes', (string) $student->has_stripes) === (string) $stripe) selected @endif value="{{ $stripe }}">{{ $stripe }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="months_practice">How Many Months Practicing? <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="months_practice" value="{{ old('months_practice', $student->months_practice) }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="age">Student's Age <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="age" value="{{ old('age', $student->age) }}">
                </div>
                <div class="form-group">
                    <p class="form-label">Does this student require a Patch only, or Belt and Patch? <span class="text-danger">*</span></p>
                    @foreach($evaluationOptions as $evaluationOption)
                        <div class="form-check form-check-inline">
                            <input @if (old('evaluating_for', (string) $student->evaluating_for) === (string) $evaluationOption) checked @endif type="radio" id="{{ strtolower(str_replace(' ', '_', $evaluationOption)) }}" name="evaluating_for" value="{{ $evaluationOption }}">
                            <label for="{{ strtolower(str_replace(' ', '_', $evaluationOption)) }}">{{ $evaluationOption }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <p class="form-label">Is Evaluation Paid? <span class="text-danger">*</span></p>
                    <div class="form-check form-check-inline">
                        <input @if (old('is_paid', (string) $student->is_paid) === "1") checked @endif  type="radio" id="yes" name="is_paid" value="1">
                        <label for="yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input @if (old('is_paid', (string) $student->is_paid) === "0") checked @endif type="radio" id="no" name="is_paid" value="0">
                        <label for="no">No</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="receipt_number">Receipt No.</label>
                    <input type="text" class="form-control" name="receipt_number" value="{{ old('receipt_number', $student->receipt_number) }}">
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                @foreach(range(1, 6) as $n)
                    <div class="form-group">
                        <p class="form-label">Activity {{ $n }}</p>
                        @foreach(range(0, 4) as $i)
                            @php($name = 'activity_' . $n)
                            <div class="form-check form-check-inline">
                                <input @if(old('activity_' . $n, (string) $student[$name]) === (string) $i) checked @endif type="radio" id="activity_{{ $n }}_{{ $i }}" name="activity_{{ $n }}" value="{{ $i }}">
                                <label class="ml-1" for="activity_{{ $n }}_{{ $i }}">{{ $i }}</label>
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <div class="form-group">
                    <label class="form-label" for="received_belt_id">Received Belt</label>
                    <select name="received_belt_id" class="form-select">
                        <option @if(!old('received_belt_id', $student->received_belt_id)) selected @endif value="">Select...</option>
                        @foreach($belts as $belt)
                            <option @if(old('received_belt_id', (string) $student->received_belt_id) === (string) $belt->id) selected @endif value="{{ $belt->id }}">{{ $belt->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="received_stripes">Received Stripes?</label>
                    <select name="received_stripes" class="form-select">
                        <option @if(!old('received_stripes', $student->received_stripes)) selected @endif value="">Select...</option>
                        @foreach(range(0, 8) as $stripe)
                            <option @if(old('received_stripes', (string) $student->received_stripes) === (string) $stripe) selected @endif value="{{ $stripe }}">{{ $stripe }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="notes">Itinerant Notes</label>
                    <textarea class="form-control" name="notes">{{ old('notes', $student->notes) }}</textarea>
                </div>
            </div>
            <input type="hidden" class="form-control" name="evaluation_id" value="{{ $evaluation->id }}">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
