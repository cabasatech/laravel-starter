<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Task Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles users' tasks for the application.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the list of tasks created.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('task.index', ["tasks" => Task::all()]);
    }

    /**
     * Show the form for creating a new task.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created task in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required'
        ]);
        
        $task = new Task();
        
        $task->subject = $request->subject;
        $task->description = $request->description;
        
        $task->save();
        
        session()->flash('status', 'Task created successfully.');
        return redirect()->route('showTask', [$task]);
    }

    /**
     * Display the specified task.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('task.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified task.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('task.edit', ['task' => $task]);
    }

    /**
     * Update the specified task in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'subject' => 'required'
        ]);

        $task->subject = $request->subject;
        $task->description = $request->description;
        
        $task->save();
        
        session()->flash('status', 'Task updated successfully.');
        return redirect()->route('showTask', [$task]);
    }

    /**
     * Remove the specified task.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
//        $task->delete();
        
        session()->flash('status', 'Task deleted successfully.');
        return redirect()->route('showTask', [$task]);
    }
}
