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

                    <form class="form-horizontal{{ $errors->all() ? ' was-validated' : '' }}" method="POST" action="{{ route('task.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group row{{ $errors->has('subject') ? ' is-invalid' : '' }}">
                            <label for="subject" class="col-md-3 col-form-label">Subject:</label>

                            <div class="col-md-7">
                                <input id="subject" type="text" class="form-control" name="subject" value="{{ old('subject') }}" required autofocus>

                                @if ($errors->has('subject'))
                                <span class="invalid-feedback">{{ $errors->first('subject') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row{{ $errors->has('description') ? ' is-invalid' : '' }}">
                            <label for="description" class="col-md-3 col-form-label">Description:</label>

                            <div class="col-md-7">
                                <textarea id="description" type="text" class="form-control" name="description" autofocus>{{ old('description') }}</textarea>

                                @if ($errors->has('description'))
                                <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-7 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    Create
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
