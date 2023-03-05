<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    //
    public function store(Request $request, $todoId){
     
        
        $validator = Validator::make($request->all(), [
            'task_'.$todoId => 'required|max:150',
        ],[
            "task_$todoId.required" => 'The task is required.',
            "task_$todoId.max" => 'The task must not be greater than 150 characters.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        $task = new Task();
        $task->todo_id = $todoId;
        $task->task = $request->input('task_'.$todoId);
        $task->save();

        if($task)
            return redirect()->back()->with('message_'.$todoId, 'New task Created!');
        else
            return back()->withErrors([
                'message_'.$todoId => 'Unable to create'
            ])->withInput();
            
        
    }


    public function toggle($id)
    {
        $task = Task::findOrFail($id);
        $task->is_completed =( request('completed') == "1") ? 0 : 1;
        $task->save();
        return response()->json(['task' => $task]);
    }

    public function update(Request $request, $todoId, $id){

        $validator = Validator::make($request->all(), [
            'task_'.$todoId => 'required|max:150',
        ],[
            "task_$todoId.required" => 'The task is required.',
            "task_$todoId.max" => 'The task must not be greater than 150 characters.',
        ]);

        
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $task = Task::findOrFail($id);
        $task->task = $request->input('task_'.$todoId);
        $task->save();

        if($task)
            return redirect()->back()->with('message_'.$todoId, 'Updated Task Successfully!');
        else
            return back()->withErrors([
                'message_'.$todoId => 'Unable to create'
            ])->withInput();
    }

    public function destroy($id, $todoId){

        $task = Task::findOrFail($id);
        $task->delete();
        
        if($task){
            return redirect()->back()->with('message_'.$todoId, 'Task Deleted Successfully!');
        }else{
            return back()->with('error_message_'.$todoId , 'Task Deleted Successfully!');
        }
    }
}
