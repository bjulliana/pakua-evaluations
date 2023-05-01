<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Evaluation;
use App\Models\Itinerancy;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class EvaluationController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($itinerancy_id): \Illuminate\View\View
    {
        $disciplines = Discipline::get();

        return view('evaluation.create',compact('itinerancy_id', 'disciplines'));
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
            'discipline_id' => 'required',
            'date' => 'required',
            'itinerancy_id' => 'required'
        ]);

        $input = $request->all();

        $evaluation = Evaluation::create($input);

        return redirect()->route('itinerancies.show', $evaluation->itinerancy_id)
                         ->with('success','Evaluation created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $evaluation = Evaluation::find($id);
        $students = Student::where("evaluation_id", $id)->get();

        return view('evaluation.show', compact('evaluation', 'students'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id): View
    {
        $evaluation = Evaluation::find($id);

        return view('evaluation.edit', compact('evaluation'));
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
            'discipline' => 'required',
            'date' => 'required'
        ]);

        $evaluation = Evaluation::find($id);
        $evaluation->discipline = $request->input('discipline');
        $evaluation->date = $request->input('date');
        $evaluation->save();

        return redirect()->route('itinerancies.show', $evaluation->itinerancy_id)
                         ->with('success','Evaluation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $evaluation = Evaluation::find($id);
        $itinerancy_id = $evaluation->itinerancy_id;
        $evaluation->delete();

        return redirect()->route('itinerancies.show', $itinerancy_id)
                         ->with('success','Evaluation deleted successfully');
    }

}

?>
