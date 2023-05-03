<?php

namespace App\Http\Controllers;

use App\Models\Belt;
use App\Models\Evaluation;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class StudentController extends Controller
{
    protected $_user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('permission:student-list', ['only' => ['index','store']]);
        $this->middleware('permission:student-create', ['only' => ['create','store']]);
        $this->middleware('permission:student-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:student-delete', ['only' => ['destroy']]);
        $this->middleware('permission:itinerancy-list', ['only' => ['itinerant_view/update', 'update_order', 'itinerant_view']]);
        $this->middleware('permission:itinerancy-update', ['only' => ['itinerant_view/update', 'update_order', 'itinerant_view']]);
    }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\View\View
   */
  public function itinerantView($evaluation_id) {
      $user = auth()->user();
      $role = ($user) ? $user->getRoleNames()[0] : null;
      $canAddResults = $role && (($role === Role::ADMIN || $role === Role::ITINERANT));

      if (!$canAddResults) abort(404);

      $evaluation = Evaluation::find($evaluation_id);

      $students = Student::where('evaluation_id', $evaluation->id)->orderBy('order', 'ASC')->get();

      $data = [
          'belts' => Belt::get(),
          'students' => $students,
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
      $user = auth()->user();
      $role = ($user) ? $user->getRoleNames()[0] : null;
      $referrer = ($from_itinerancy_view) ? '/students/itinerant_view/' . $evaluation_id : '/evaluations/' . $evaluation_id;

      $data = [
          'belts' => Belt::get(),
          'instructors' => Instructor::get(),
          'evaluationOptions' => Student::EVALUATION_OPTIONS,
          'evaluation' => Evaluation::find($evaluation_id),
          'canAddResults' => $role && (($role === Role::ADMIN || $role === Role::ITINERANT)),
          'referrer' => $referrer
      ];

      return view('student.create', $data);
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
  public function store(Request $request): \Illuminate\Http\RedirectResponse {
      $this->validate($request, [
          'name' => 'required',
          'instructor_id' => 'required',
          'current_belt_id' => 'required',
          'has_stripes' => 'required',
          'months_practice' => 'required',
          'age' => 'required',
          'evaluating_for' => 'required',
          'is_paid' => 'required',
          'evaluation_id' => 'required'
      ]);

      $input = $request->all();
      $lastStudentCreated = Student::getLastStudentCreatedForEvaluation($input['evaluation_id']);

      $student = Student::create($input);

      // Update Order
      if ($lastStudentCreated) {
          $student->order = $lastStudentCreated->order + 1;
      } else {
          $student->order = 1;
      }

      $student->save();

      return redirect('/students/create/' . $student->evaluation_id)->with('success','Student created successfully');
  }

  public function itinerantUpdate(Request $request): \Illuminate\Http\RedirectResponse {
      $inputs = $request->all();
      $studentsRequest = $inputs['students'];
      $evaluationId = $inputs['evaluation_id'];

      foreach ($studentsRequest as $studentRequest) {
          $student = Student::find($studentRequest['id']);
          $student->activity_1 = $studentRequest['activity_1'] ?? NULL;
          $student->activity_2 = $studentRequest['activity_2'] ?? NULL;
          $student->activity_3 = $studentRequest['activity_3'] ?? NULL;
          $student->activity_4 = $studentRequest['activity_4'] ?? NULL;
          $student->activity_5 = $studentRequest['activity_5'] ?? NULL;
          $student->activity_6 = $studentRequest['activity_6'] ?? NULL;
          $student->received_belt_id = $studentRequest['received_belt_id'] ?? NULL;
          $student->received_stripes = $studentRequest['received_stripes'] ?? NULL;
          $student->notes = $studentRequest['notes'] ?? NULL;
          $student->save();
      }

      return redirect('/students/itinerant_view/' . $evaluationId)->with('success','Students updated successfully');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
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
        $user = auth()->user();
        $role = ($user) ? $user->getRoleNames()[0] : null;
        $student = Student::find($id);

        $data = [
            'student' => $student,
            'belts' => Belt::get(),
            'instructors' => Instructor::get(),
            'evaluationOptions' => Student::EVALUATION_OPTIONS,
            'evaluation' => $student->evaluation,
            'canAddResults' => $role && (($role === Role::ADMIN || $role === Role::ITINERANT)),
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
          'name' => 'required',
          'instructor_id' => 'required',
          'current_belt_id' => 'required',
          'has_stripes' => 'required',
          'months_practice' => 'required',
          'age' => 'required',
          'evaluating_for' => 'required',
          'is_paid' => 'required',
          'evaluation_id' => 'required'
      ]);

      $student = Student::find($id);
      $student->fill($request->all());
      $student->save();

      return redirect()->route('evaluations.show', $student->evaluation_id)
                       ->with('success','Student updated successfully');
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $student = Student::find($id);
        $evaluation_id = $student->evaluation_id;
        $student->delete();

        return redirect()->route('evaluations.show', $evaluation_id)
                         ->with('success','Student deleted successfully');
    }

    public function updateOrder(Request $request)
    {

        try {
            $data = $request->all();
            $originalStudents = Student::where('evaluation_id', $data['evaluation_id'])->get()->all();
            $updatedStudents = $data['students'];

            if (is_array($updatedStudents) && count($updatedStudents) > 0) {
                $order = 1;
                $studentsById = $this->index_array_objects_by_field($originalStudents, 'id');
                foreach ($updatedStudents as $updatedStudent) {
                    $student = $studentsById[$updatedStudent['id']];
                    $student->order = $order;
                    $student->save();
                    $order++;
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Students Order Updated'
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
             ]);
        }

    }

    function index_array_objects_by_field($array, $field)
    {
        if (!is_array($array)) throw new Exception("Not an array");

        $resultSet = array();
        foreach ($array as $element) {
            if (!isset($element[$field])) throw new Exception("One or more elements does not contain property '$field'");
            $rs_key = $element[$field];
            $resultSet[$rs_key] = $element;
        }

        return $resultSet;
    }

}
