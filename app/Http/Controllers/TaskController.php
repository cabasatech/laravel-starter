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

    private $_view = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_view = [];
    }
    
    /**
     * Show the list of tasks created.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->_view['tasks'] = Task::all();

        return view('task.index', $this->_view);
    }

    /**
     * Show the form for creating a new task.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.create', $this->_view);
    }

    /**
     * Store a newly created task in database.
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'subject' => 'required'
            ]
        );
        
        $task = Task::create(
            [
                'subject' => $request->subject,
                'description' => $request->description
            ]
        );
        
        session()->flash('status', 'Task created successfully.');
        return redirect()->route('task.show', [$task->id]);
    }

    /**
     * Display the specified task.
     *
     * @param Task $task 
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $this->_view['task'] = $task;

        return view('task.show', $this->_view);
    }

    /**
     * Show the form for editing the specified task.
     *
     * @param Task $task 
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $this->_view['task'] = $task;

        return view('task.edit', $this->_view);
    }

    /**
     * Update the specified task in database.
     *
     * @param \Illuminate\Http\Request $request 
     * @param Task                     $task 
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $request->validate(
            [
                'subject' => 'required'
            ]
        );

        $task->fill(
            [
                'subject' => $request->subject,
                'description' => $request->description
            ]
        )->update();
        
        session()->flash('status', 'Task updated successfully.');
        return redirect()->route('task.show', [$task->id]);
    }

    /**
     * Remove the specified task.
     *
     * @param Task $task 
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        
        session()->flash('status', 'Task deleted successfully.');
        return redirect()->route('tasks');
    }
}
