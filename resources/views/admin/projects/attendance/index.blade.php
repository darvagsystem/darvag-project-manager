@extends('admin.layout')

@section('title', 'حضور و غیاب - ' . $project->name)

@section('content')
    @livewire('attendance-component', ['project' => $project])
@endsection
