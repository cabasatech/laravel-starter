@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Task #{{ $task->id }}</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-3 h4">Subject:</div>
                        <div class="col-md-6 h4">{{ $task->subject }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 h4">Description:</div>
                        <div class="col-md-6 h4">{{ $task->description or '-' }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 h4">Status:</div>
                        <div class="col-md-6 h4">{{ $task->status }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 h4">Started on:</div>
                        <div class="col-md-6 h4">{{ $task->started_on or '-' }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 h4">Completed on:</div>
                        <div class="col-md-6 h4">{{ $task->completed_on or '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
