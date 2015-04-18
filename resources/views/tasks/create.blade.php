@extends('app')

@section('content')
    <h2>Create Task</h2>

    {!! Form::model(new App\Task, ['route' => ['project.tasks.store']]) !!}
        @include('tasks/partials/_form', ['submit_text' => 'Create Task'])
    {!! Form::close() !!}
@endsection
