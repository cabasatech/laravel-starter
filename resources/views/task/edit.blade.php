@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">Task</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form class="form-horizontal{{ $errors->all() ? ' was-validated' : '' }}" method="POST" action="{{ route('task.update', [$task->id]) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group{{ $errors->has('subject') ? 'is-invalid' : '' }} row">
                            <label for="subject" class="col-md-4 col-form-label">Subject</label>

                            <div class="col-md-6">
                                <input id="subject" type="text" class="form-control" name="subject" value="{{ $task->subject }}" required autofocus>

                                @if ($errors->has('subject'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('subject') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('description') ? ' is-invalid' : '' }} row">
                            <label for="description" class="col-md-4 col-form-label">Description</label>

                            <div class="col-md-6">
                                <textarea id="description" type="text" class="form-control" name="description" autofocus>{{ $task->description }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
