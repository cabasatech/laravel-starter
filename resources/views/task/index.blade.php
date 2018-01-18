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

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SUBJECT</th>
                                    <th>DESCRIPTION</th>
                                    <th>STARTED</th>
                                    <th>COMPLETED</th>
                                    <th>STATUS</th>
                                    <th></th>
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
                                        <form action='{{ route("task.destroy", [$task->id]) }}' method="GET">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-link">Delete</button>
                                        </form>
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
</div>
@endsection
