@extends('nav')

@section('main')
    <div>
        <div class="float-start">
            <h4 class="pb-3">My Tasks</h4>
        </div>
        <div class="float-end">
            <a href="{{route('task.create')}}" class="btn btn-info">
                <i class="fa fa-plus-circle"></i>
                Create New Task
            </a>
        </div>
        <div class="clearfix"></div>
    </div>
    <form action="" method="GET">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <label>Filter By DueDate </label>
                <input type="date" class = "form-control" name="duedate" value="{{ Request::get('duedate')}}" />
            </div>
            <div class="col-md-3">
                <label >Filter By Status </label>
                <select name="status" id="status" class="form-select">
                    <option value="">Select Status</option>
                    <option value="completed" {{Request::get('status') == 'completed' ? 'selected' : '' }}> Completed</option>
                    <option value="notcompleted" {{Request::get('status') == 'notcompleted' ? 'selected' : '' }}> Not Completed</option>
                </select>
            </div>
            <div class="col-md-6">
                <br/>
                <button type = "submit" class="btn btn-primary">Filter</button>
            </div>
        </div>

    </form>
    <br/>
    @foreach($tasks as $task)
        <div class="card">
            <div class="card-header">
                @if ($task->status == "completed")
                    <del>{{$task->title}}</del>
                @else
                    {{$task->title}}   
                @endif
                <span class="badge rounded-pill text-bg-warning">
                    {{$task->created_at->diffForHumans()}}
                </span>
            </div>
            <div class="card-body">
                <div class="card-text">
                    <div class="float-start">
                        @if ($task->status == "completed")
                            <del>{{$task->description}}</del>
                        @else
                            {{$task->description}}   
                        @endif
                        <br>
                        @if ($task->status == "completed")
                            <span class="badge rounded-pill text-bg-success">
                                Completed
                            </span>
                        @else
                            <span class="badge rounded-pill text-bg-info">
                                Not Completed
                            </span>
                        @endif
                    
                        <small>Last Updated - {{$task->updated_at->diffForHumans()}}</small><br>

                        @if ($task->due == "true" && $task->status == "notcompleted")
                            <label class="badge rounded-pill text-bg-danger mt-2" >Due Date Expired :</label> {{$task->duedate}}<br>
                        @else
                            <label>Due Date :</label> {{$task->duedate}}<br>
                        @endif
                    </div>
                    <div class="float-end">
                        <!-- <a href="{{ route('task.show', $task->id)}}" class="btn btn-info">
                           <i class="fa fa-eye"></i> Show
                        </a> -->
                        <a href="{{ route('task.edit', $task->id)}}" class="btn btn-success">
                           <i class="fa fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('task.destroy', $task->id)}}" style="display:inline" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                               <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                        
                    </div>
                    <div class="clearfix"></div>    
                </div>
            </div>
        </div>
    @endforeach

    @if (count($tasks) === 0)
        <div class="alert alert-danger p-2">
            No Tasks Found!! Please create a Task.
            <br>
            <br>
            <a href="{{route('task.create')}}" class="btn btn-info">
                <i class="fa fa-plus-circle"></i>
                Create New Task
            </a>
        </div>
    @endif
@endsection