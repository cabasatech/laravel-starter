@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">Task #{{ $task->id }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4 h5">Subject:</div>
                        <div class="col-md-8 h5">{{ $task->subject }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 h5">Description:</div>
                        <div class="col-md-8 h5">{{ $task->description or '-' }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 h5">Status:</div>
                        <div class="col-md-8 h5">{{ $task->status }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 h5">Started on:</div>
                        <div class="col-md-8 h5">{{ $task->started_on or '-' }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 h5">Completed on:</div>
                        <div class="col-md-8 h5">{{ $task->completed_on or '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
