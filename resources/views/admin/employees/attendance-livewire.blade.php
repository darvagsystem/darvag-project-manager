@extends('admin.layout')

@section('title', 'حضور و غیاب پرسنل - ' . $employee->full_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @livewire('employee-attendance-component', ['employee' => $employee])
        </div>
    </div>
</div>
@endsection
