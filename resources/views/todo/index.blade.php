@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          @if ($flash = session('success'))
            <div class="alert alert-success alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>{{ $flash }}</strong>
            </div>
          @elseif ($flash = session('failed'))
            <div class="alert alert-danger alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>{{ $flash }}</strong>
            </div>
          @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                  <form class="form-horizontal" action="{{ route('todos.store') }}" method="post" style="margin-top:20px;">
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('todo') ? ' has-error' : '' }}">
                      <label for="todo" class="control-label col-sm-2">Todo:</label>
                      <div class="col-sm-8">
                        <input type="text" name="todo" id="todo" value="{{ old('todo') }}" class="form-control">
                          @if ($errors->has('todo'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('todo') }}</strong>
                              </span>
                          @endif
                      </div>
                      <div class="col-sm-2">
                        <button type="submit" name="button" class="btn btn-primary">Add</button>
                      </div>
                    </div>
                  </form>
                </div>

                <div class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Todo</th>
                            <th colspan="2">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($todos as $todo)
                          <tr>
                            <td>{{ $n++ }}</td>
                            <td><a href="{{ route('todos.edit', $todo->id) }}">{{ $todo->todo }}</a></td>
                            <td>
                              <div class="" style="float:left;">
                                @if (!$todo->completed)
                                  <form class="" action="{{ route('completed', $todo->id) }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="isComplete" value="1"></input>
                                    <button type="submit" class="btn btn-success">Mark as completed</button>
                                  </form>
                                  @else
                                    <form class="" action="{{ route('incomplete', $todo->id) }}" method="post">
                                      {{ csrf_field() }}
                                      <input type="hidden" name="isComplete" value="0"></input>
                                      <button type="submit" class="btn btn-info">Completed</button>
                                    </form>
                                @endif
                              </div>
                            </td>
                            <td>
                              <div class="">
                                <form class="" action="{{ route('todos.destroy', $todo->id) }}" method="post">
                                  {{ csrf_field() }}{{ method_field('DELETE') }}
                                  <button type="submit" name="button" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?') " style="margin-left:5px;">Delete</button>
                                </form>
                              </div>
                            </td>
                          </tr>
                            @endforeach
                        </tbody>
                    </table>
                  </div>
                  {{ $todos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
