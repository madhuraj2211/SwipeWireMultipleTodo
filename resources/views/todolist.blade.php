@extends('master')
@section('content')
    <div class = "container mt-5">
        <div class=" d-flex justify-content-center customer-login card">
            <div class="row card-body">
                <form id="todoForm" action = "{{route('todolist.store')}}" method = "POST">
                    @csrf
                    <div id="alertdiv">
                        @if(session()->has('message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>  {{ session()->get('message') }}</strong> 
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if(session()->has('error_message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>  {{session()->get('error_message')}}</strong> 
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                    <div class="form-inline d-flex ">
                            <input type="text" name = "todo" id="todo" class="form-control" placeholder="Hi {{ucwords(Session::get('user')['name'])}}, Enter Your Todo" value = {{old('todo')}}> 
                    <div class="mx-2">
                        <button type="submit" id="submitbtn" class="btn btn-success text-nowrap">Create Todo</button>
                    </div>
                    </div>
                    <div id = "errordiv">
                        @if ($errors->has('todo'))
                            @foreach ($errors->get('todo') as $error)
                                <p class="text-danger">{{$error}}</p>
                            @endforeach
                        @endif

                        @if ($errors->has('message'))
                        @foreach ($errors->get('message') as $error)
                            <p class="text-danger">{{$error}}</p>
                        @endforeach
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

   @if (count($todos)== 0)
       <div class="d-flex justify-content-center container align-items-center mt-5 fs-3">
           <strong>Create your first Todo List!</strong> 
       </div>
   @else    
    <div class="container-fluid">
    <div class="row">
        @foreach ($todos as $todo)
        <div class="col-sm-4">
            <div class="card p-0 ">
                <div class="card-header d-flex justify-content-between align-items-center ">
                <div class="text-truncate">
                    <strong>{{Str::ucfirst($todo->todo)}}</strong>
                </div>
                <div class=" d-flex ">
                    <button class="btn btn-outline-success rounded-circle mx-2" onclick="editTodo('{{$todo->id}}', '{{$todo->todo}}')">
                        <i class="fa-regular fa-pen-to-square" ></i>
                    </button>
                    <form action="{{route('todolist.delete', $todo->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger rounded-circle">
                            <i class="fa-regular fa-trash-can" type=""></i>
                        </button>
                    </form>
                </div>
                </div>
                <div class="card-body">
                    <form name = {{'todo_'.$todo->id}} id={{'todo_'.$todo->id}} action = "{{route('task.store', $todo->id)}}" method ="POST">
                        @csrf
                        <div id={{'alertdiv_'.$todo->id}}>
                            @if(session()->has('message_'.$todo->id))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>  {{ session()->get('message_'.$todo->id) }}</strong> 
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if(session()->has('error_message_'.$todo->id))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>  {{session()->get('error_message_'.$todo->id)}}</strong> 
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>   
                            @endif
                        </div>
                        <div class="input-group">
                            <input type="text" name= {{'task_'.$todo->id}} class="form-control rounded-0" placeholder="Enter a task">
                            <div>
                                <button class="btn btn-dark rounded-0" type="submit" id="button-addon2">Add Task</button>
                            </div>
                        </div>
                        <div id = {{'errordiv_'.$todo->id}}>
                            @if ($errors->has('task_'.$todo->id))
                                @foreach ($errors->get('task_'.$todo->id) as $error)
                                    <p class="text-danger">{{$error}}</p>
                                @endforeach
                            @endif
                            @if ($errors->has('message_'.$todo->id))
                                @foreach ($errors->get('message_'.$todo->id) as $error)
                                    <p class="text-danger">{{$error}}</p>
                                @endforeach
                            @endif
                        </div>
                    </form>
                     
                    <div class='tasks'>
                        @if (count($todo->tasks) == 0)
                            <div class="d-flex align-items-center justify-content-center fs-4 mt-4 text-secondary">
                                <strong>Create a task!</strong>
                            </div>
                        @else
                        <table class="text-wrap table table-hover">
                        <thead>
                            <th width="95%"></th>
                            <th width="3%"> </th>
                            <th width="2%"> </th>
                        </thead>
                        @foreach ($todo->tasks as $task)
                            <tr >
                                <td class="">{{$task->task}}</td>
                                <td class="text-nowrap">
                                    <div class="d-flex">
                                        <span class="mx-3">
                                            <i class="fa-regular fa-pen-to-square text-primary edit-task" data-inputname="{{'task_'.$todo->id}}" data-formname="{{'todo_'.$todo->id}}" data-todoid ="{{$todo->id}}" data-taskid="{{$task->id}}" style="cursor: pointer;" ></i>
                                        </span>
                                        <span  class="">
                                        <form action="{{route('task.delete',['taskid'=>$task->id, 'todoId' =>$todo->id])}}" id="{{'task_delete_form_'.$task->id}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                                <i class="fa-regular fa-trash-can text-danger delete-task" type="" style="cursor: pointer;" onclick="document.getElementById('task_delete_form_{{$task->id}}').submit();"></i>
                                            </form>
                                        </span>  
                                    </div>
                                </td>
                                <td class="task" data-id="{{ $task->id }}">
                                    <span class="toggle-badge badge bg-{{ $task->is_completed ? 'success' : 'warning text-dark' }}" data-completed="{{ $task->is_completed ? '1' : '0' }}" style="cursor: pointer;">
                                        {{$task->is_completed ? 'Completed' : 'Incomplete' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
            {{$todos->links()}}
    </div>
    
    </div>
   @endif
@endsection

@section('scripts')
    <script src="{{ asset('js/script.js') }}"></script>
@endsection 