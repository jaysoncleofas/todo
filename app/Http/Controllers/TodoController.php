<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;

class TodoController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::where('user_id', auth()->id())
                  ->latest()
                  ->paginate(10);

        $n = (($todos->currentpage() - 1) * $todos->perpage()) + 1;
        return view('todo.index', compact('todos', 'n'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'todo' => 'unique:todos'
        ]);

        $todo = new Todo;
        $todo->user_id = auth()->id();
        $todo->todo = $request->todo;
        $todo->save();

        session()->flash('success', 'Successfully Added!');
        return redirect()->back();
        ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = Todo::findOrFail($id);
        return view('todo.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        if ($todo->todo != $request->todo) {
            $this->validate($request, [
              'todo' => 'unique:todos'
            ]);
        }
        $todo->todo = $request->todo;
        $todo->save();

        session()->flash('success', 'Successfully Updated!');
        return redirect()->route('todos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);

        $todo->delete();

        session()->flash('success', 'Successfully Deleted!');
        return redirect()->back();
    }

    public function completed(Request $request, $id)
    {
        $todo = Todo::find($id);
        $todo->completed = $request->isComplete;
        $todo->save();

        session()->flash('success', 'Successfully Completed!');
        return redirect()->back();
    }

    public function incomplete(Request $request, $id)
    {
        $todo = Todo::find($id);
        $todo->completed = $request->isComplete;
        $todo->save();

        session()->flash('failed', 'Return to incomplete!');
        return redirect()->back();
    }
}
