<?php

namespace App\Http\Controllers;

use App\Exports\ItinerancyExport;
use App\Models\Evaluation;
use App\Models\Itinerancy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ItinerancyController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:itinerancy-list', ['only' => ['index','store','export']]);
        $this->middleware('permission:itinerancy-create', ['only' => ['create','store']]);
        $this->middleware('permission:itinerancy-edit', ['only' => ['edit','update','export']]);
        $this->middleware('permission:itinerancy-delete', ['only' => ['destroy']]);
    }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
   */
  public function index(Request $request)
  {
      $data = Itinerancy::orderBy('id','DESC')->paginate(5);

      return view('itinerancy.index',compact('data'))
          ->with('i', ($request->input('page', 1) - 1) * 5);
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): \Illuminate\View\View
    {
        $data = Itinerancy::pluck('name','name')->all();
        return view('itinerancy.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $input = $request->all();

        Itinerancy::create($input);

        return redirect()->route('itinerancies.index')
                         ->with('success','Itinerancy created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $itinerancy = Itinerancy::find($id);
        $evaluations = Evaluation::where("itinerancy_id", $id)->get();

        return view('itinerancy.show', compact('itinerancy', 'evaluations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id): View
    {
        $itinerancy = Itinerancy::find($id);

        return view('itinerancy.edit', compact('itinerancy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $itinerancy = Itinerancy::find($id);
        $itinerancy->name = $request->input('name');
        $itinerancy->save();

        return redirect()->route('itinerancies.index')
                         ->with('success','Itinerancy updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        Itinerancy::find($id)->delete();
        return redirect()->route('itinerancies.index')
                         ->with('success','Itinerancy deleted successfully');
    }

    public function export($itinerancy_id) {
        $itinerancy = Itinerancy::find($itinerancy_id);
        $evaluations = $itinerancy->evaluations;
        $data = [];

        foreach ($evaluations as $evaluation) {
            $students = $evaluation->students;
            foreach ($students as $student) {
                $data[] = [
                    'Discipline' => $evaluation->discipline->name,
                    'Name' => $student->name,
                    'Instructor' => $student->instructor->name,
                    'Current Belt' => $student->currentBelt->name,
                    'Current Stripes' => $student->has_stripes,
                    'Months Practicing' => $student->months_practice,
                    'Age' => $student->age,
                    'Evaluation Paid' => $student->is_paid,
                    'Belt or Patch' => $student->evaluating_for,
                    'Activity 1' => $student->activity_1 ?? '',
                    'Activity 2' => $student->activity_2 ?? '',
                    'Activity 3' => $student->activity_3 ?? '',
                    'Activity 4' => $student->activity_4 ?? '',
                    'Activity 5' => $student->activity_5 ?? '',
                    'Activity 6' => $student->activity_6 ?? '',
                    'New Belt' => $student->receivedBelt?->name ?? '',
                    'Received Stripes' => $student->received_stripes ?? '',
                    'Itinerant Notes' => $student->notes ?? ''
                ];
            }
        }

        return Excel::download(new ItinerancyExport($data), $itinerancy->name . '.xlsx');
    }

}
