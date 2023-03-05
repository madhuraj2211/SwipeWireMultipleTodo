<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoListController extends Controller
{
    //
    public function index(){
        $user_id = Auth::id(); 

        $todos = Todo::where('user_id',  $user_id )
        ->with('tasks')
        ->orderby('id', 'desc')
        ->paginate(3);


        // echo '<pre>';
        // print_r($todos->toJson());
        // die;

        return view('todolist', compact('todos'));
    }

    public function store(Request $request){
     
        $request->validate([
            'todo'=> 'required|max:150',
        ]);

        $user_id = Auth::id();

        $todo = new Todo();
        $todo->todo = $request->input('todo');
        $todo->user_id = $user_id;
        $todo->save();

        if($todo)
            return redirect('todolist?page=1')->with('message', 'New Todo Created!');
        else
            return back()->withErrors([
                'message' => 'Unable to create'
            ])->withInput();
            
        
    }

    public function edit ($id){
        $todo = Todo::findOrFail($id);
        return view('todolist', compact('todo'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'todo'=> 'required|max:150',
        ]);

        $todo = Todo::findOrFail($id);
        $todo->todo = $request->input('todo');
        $todo->save();

        if($todo)
            return redirect()->route('todolist.index')->with('message', 'Todo Updated!');
        else
            return back()->withErrors([
                'message' => 'Unable to update'
            ])->withInput();
    }

    public function destroy($id){

        $todo = Todo::findOrFail($id);
        $todo->delete();
        
        if($todo){
            return redirect()->back()->with('message', 'Task Deleted Successfully!');
        }else{
            return redirect()->back()->with('error_message', 'Task Deleted Successfully!');
        }
      
    }

    public function store_(Request $request){
     
        $validator = Validator::make($request->all(), [
            'todo'=> 'required|max:150',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'errors'=>$validator->messages()
            ], 422);
        }
        else
        {
            $todo = new Todo();
            $todo->todo = $request->input('todo');
            $todo->save();
            if($todo)
                return response()->json([
                    'message'=>'Todo Created Successfully.'
                ], 200);
            else
                return response()->json([
                    'message'=>'Unable to Create.'
                ], 400);
            
        }
    }

    public function fetchlist()
    {
        $todo = Todo::all();
        return response()->json([
            'todo'=>$todo,
        ]);
    }

}
