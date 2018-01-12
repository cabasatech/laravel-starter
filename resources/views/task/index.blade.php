@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Task</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th>SUBJECT</th>
                            <th>DESCRIPTION</th>
                            <th>STARTED</th>
                            <th>COMPLETED</th>
                            <th colspan="2">STATUS</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $task->subject }}</td>
                                <td style="word-wrap: break-word">{{ $task->description }}</td>
                                <td>{{ $task->started_on or '-' }}</td>
                                <td>{{ $task->completed_on or '-' }}</td>
                                <td>{{ $task->status }}</td>
                                <td>
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
