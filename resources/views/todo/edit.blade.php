@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
          <div class="panel-heading">
            Edit
          </div>
          <div class="panel-body">
            <form class="form-horizontal" action="{{ route('todos.update', $todo->id) }}" method="post">
              {{ csrf_field() }}{{ method_field('PATCH') }}
              <div class="form-group {{ $errors->has('todo') ? ' has-error' : '' }}">
                <label for="" class="control-label col-sm-2">Todo:</label>
                <div class="col-sm-10">
                  <input type="text" name="todo" value="{{ $todo->todo }}" class="form-control">
                  @if ($errors->has('todo'))
                      <span class="help-block">
                          <strong>{{ $errors->first('todo') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <a href="{{ URL::previous() }}" class="btn btn-default" style="float:right;margin-left:1rem;">Back</a>
              <button type="submit" name="button" class="btn btn-primary" style="float:right;">Update</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
