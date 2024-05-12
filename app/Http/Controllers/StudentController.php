<?php

namespace App\Http\Controllers;

use App\Models\Belt;
use App\Models\Evaluation;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\Role;
use App\Models\StudentData;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class StudentController extends Controller {
    protected $_user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('permission:student-list', ['only' => ['index', 'store']]);
        $this->middleware('permission:student-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:student-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:student-delete', ['only' => ['destroy']]);
        $this->middleware('permission:itinerancy-list', ['only' => ['itinerant_view/update', 'update_order', 'itinerant_view']]);
        $this->middleware('permission:itinerancy-edit', ['only' => ['itinerant_view/update', 'update_order', 'itinerant_view']]);
    }

    public function attributes(): array {
        return [
            'name'            => 'Name',
            'instructor_id'   => 'Instructor',
            'current_belt_id' => 'Current Belt',
            'has_stripes'     => 'Stripes',
            'months_practice' => 'Months of Practice',
            'age'             => 'Age',
            'is_paid'         => 'Paid Status'
        ];
    }

    public function messages(): array {
        return [
            'evaluating_for.required' => 'It is necessary to select if the student requires belt, patch or both'
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        return redirect()->route('itinerancies.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function itinerantView($evaluation_id) {
        $user          = auth()->user();
        $role          = ($user) ? $user->getRoleNames()[0] : null;
        $canAddResults = $role && (($role === Role::ADMIN || $role === Role::ITINERANT));

        if (!$canAddResults) {
            abort(404);
        }

        $evaluation = Evaluation::find($evaluation_id);

        $students = Student::where('evaluation_id', $evaluation->id)->orderBy('order', 'ASC')->get();

        $data = [
            'belts'      => Belt::get(),
            'students'   => $students,
            'evaluation' => $evaluation
        ];

        return view('student.itinerant_view', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $evaluation_id
     *
     * @return \Illuminate\View\View
     */
    public function create($evaluation_id, $from_itinerancy_view = false): \Illuminate\View\View {
        $user     = auth()->user();
        $role     = ($user) ? $user->getRoleNames()[0] : null;
        $referrer = ($from_itinerancy_view) ? '/students/itinerant_view/' . $evaluation_id : '/evaluations/' . $evaluation_id;

        $data = [
            'belts'             => Belt::get(),
            'instructors'       => Instructor::get(),
            'evaluationOptions' => Student::EVALUATION_OPTIONS,
            'evaluation'        => Evaluation::find($evaluation_id),
            'canAddResults'     => $role && (($role === Role::ADMIN || $role === Role::ITINERANT)),
            'referrer'          => $referrer
        ];

        return view('student.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse {
        $submitValue = $request->input('submit');
        $input       = $request->all();

        $this->validate($request, [
            'student'           => 'required_without:name',
            'name'              => 'required_without:student',
            'instructor_id'     => 'required',
            'current_belt_id'   => 'required',
            'photo'             => 'image|mimes:jpeg,png,jpg'
        ], $this->messages(), $this->attributes());

        $lastStudentCreated = Student::getLastStudentCreatedForEvaluation($input['evaluation_id']);
        $studentData        = null;

        if (isset($input['student'])) {
            $studentData = StudentData::firstWhere('id', $input['student']);
        } elseif (isset($input['name'])) {
            $studentData = StudentData::create([
                'name' => $input['name']
            ]);
        }

        if ($studentData instanceof StudentData) {
            $student = Student::create([
               'student_id'       => $studentData->id,
               'evaluation_id'    => $input['evaluation_id'],
               'receipt_number'   => $input['receipt_number'],
               'instructor_id'    => $input['instructor_id'],
               'current_belt_id'  => $input['current_belt_id'],
               'has_stripes'      => $input['has_stripes'],
               'months_practice'  => $input['months_practice'],
               'age'              => $input['age'],
               'is_paid'          => $input['is_paid'] ?? 0,
               'evaluating_for'   => $input['evaluating_for'] ?? null,
               'activity_1'       => $input['activity_1'] ?? null,
               'activity_2'       => $input['activity_2'] ?? null,
               'activity_3'       => $input['activity_3'] ?? null,
               'activity_4'       => $input['activity_4'] ?? null,
               'activity_5'       => $input['activity_5'] ?? null,
               'activity_6'       => $input['activity_6'] ?? null,
               'received_belt_id' => $input['received_belt_id'] ?? null,
               'received_stripes' => $input['received_stripes'] ?? null,
               'notes'            => $input['notes'] ?? null
            ]);

            // Update Order
            if ($lastStudentCreated) {
                $student->order = $lastStudentCreated->order + 1;
            } else {
                $student->order = 1;
            }

            $student->save();

            if ($request->photo) {
                $fileName = time() . '.' . $request->photo->extension();
                $request->photo->storeAs('public/images', $fileName);
                $studentData->photo = $fileName;
                $studentData->save();
            }
        }

        if ((int)$submitValue === 0) {
            return redirect('/evaluations/' . $student->evaluation_id)->with('success', 'Student created successfully');
        } else {
            return redirect('/students/create/' . $student->evaluation_id)->with('success', 'Student created successfully');
        }
    }

    public function itinerantUpdate(Request $request): \Illuminate\Http\RedirectResponse {
        $submitValue = $request->input('submit');

        $inputs          = $request->all();
        $studentsRequest = $inputs['students'];
        $evaluationId    = $inputs['evaluation_id'];
        $itinerancyId    = $inputs['itinerancy_id'];

        foreach ($studentsRequest as $studentRequest) {
            $student                   = Student::find($studentRequest['id']);
            $student->activity_1       = $studentRequest['activity_1'] ?? null;
            $student->activity_2       = $studentRequest['activity_2'] ?? null;
            $student->activity_3       = $studentRequest['activity_3'] ?? null;
            $student->activity_4       = $studentRequest['activity_4'] ?? null;
            $student->activity_5       = $studentRequest['activity_5'] ?? null;
            $student->activity_6       = $studentRequest['activity_6'] ?? null;
            $student->received_belt_id = $studentRequest['received_belt_id'] ?? null;
            $student->received_stripes = $studentRequest['received_stripes'] ?? null;
            $student->notes            = $studentRequest['notes'] ?? null;
            $student->save();
        }

        if ((int)$submitValue === 0) {
            return redirect('/itinerancies/' . $itinerancyId)->with('success', 'Students updated successfully');
        } else {
            return redirect('/students/itinerant_view/' . $evaluationId)->with('success', 'Students updated successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id): \Illuminate\View\View {
        $student = Student::find($id);

        return view('student.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(int $id): \Illuminate\View\View {
        $user    = auth()->user();
        $role    = ($user) ? $user->getRoleNames()[0] : null;
        $student = Student::find($id);

        $data = [
            'student'           => $student,
            'belts'             => Belt::get(),
            'instructors'       => Instructor::get(),
            'evaluationOptions' => Student::EVALUATION_OPTIONS,
            'evaluation'        => $student->evaluation,
            'canAddResults'     => $role && (($role === Role::ADMIN || $role === Role::ITINERANT)),
        ];

        return view('student.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse {
        $this->validate($request, [
            'name'            => 'required',
            'instructor_id'   => 'required',
            'current_belt_id' => 'required',
            'evaluation_id'   => 'required',
            'photo'           => 'image|mimes:jpeg,png,jpg'
        ], $this->messages(), $this->attributes());

        $student = Student::find($id);
        $studentData = $student->studentData;

        $input   = $request->all();
        $student->fill([
           'receipt_number'   => $input['receipt_number'],
           'instructor_id'    => $input['instructor_id'],
           'current_belt_id'  => $input['current_belt_id'],
           'has_stripes'      => $input['has_stripes'],
           'months_practice'  => $input['months_practice'],
           'age'              => $input['age'],
           'is_paid'          => $input['is_paid'] ?? 0,
           'evaluating_for'   => $input['evaluating_for'] ?? null,
           'activity_1'       => $input['activity_1'] ?? null,
           'activity_2'       => $input['activity_2'] ?? null,
           'activity_3'       => $input['activity_3'] ?? null,
           'activity_4'       => $input['activity_4'] ?? null,
           'activity_5'       => $input['activity_5'] ?? null,
           'activity_6'       => $input['activity_6'] ?? null,
           'received_belt_id' => $input['received_belt_id'],
           'received_stripes' => $input['received_stripes'],
           'notes'            => $input['notes']
        ]);

        $studentData->name = $input['name'];

        if ($request->photo) {
            $fileName = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('public/images', $fileName);
            $studentData->photo = $fileName;
        }

        $studentData->save();
        $student->save();

        return redirect()->route('evaluations.show', $student->evaluation_id)
                         ->with('success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse {
        $student       = Student::find($id);
        $evaluation_id = $student->evaluation_id;

        $student->delete();

        return redirect()->route('evaluations.show', $evaluation_id)
                         ->with('success', 'Student deleted successfully');
    }

    public function updateOrder(Request $request) {

        try {
            $data             = $request->all();
            $originalStudents = Student::where('evaluation_id', $data['evaluation_id'])->get()->all();
            $updatedStudents  = $data['students'];

            if (is_array($updatedStudents) && count($updatedStudents) > 0) {
                $order        = 1;
                $studentsById = $this->index_array_objects_by_field($originalStudents, 'id');
                foreach ($updatedStudents as $updatedStudent) {
                    $student        = $studentsById[$updatedStudent['id']];
                    $student->order = $order;
                    $student->save();
                    $order++;
                }
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Students Order Updated'
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getAll(): \Illuminate\Http\JsonResponse {
        try {
            $students = StudentData::get()->all();

            $data = array_map(function ($student) {
                return [
                    'value' => (string) $student->id,
                    'label' => $student->name
                ];
            }, $students);

            return response()->json([
                'status' => 'success',
                'data'   => $data
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getStudent($studentId): \Illuminate\Http\JsonResponse {
        try {
            if (!$studentId) {
                throw new Exception("Missing Student ID");
            }

            $student = StudentData::where('id', $studentId)->get()->first();

            return response()->json([
                'status' => 'success',
                'data'   => $student
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    function index_array_objects_by_field($array, $field) {
        if (!is_array($array)) {
            throw new Exception("Not an array");
        }

        $resultSet = [];
        foreach ($array as $element) {
            if (!isset($element[$field])) {
                throw new Exception("One or more elements does not contain property '$field'");
            }
            $rs_key             = $element[$field];
            $resultSet[$rs_key] = $element;
        }

        return $resultSet;
    }

}
