@extends('admin.layout')

@section('title', 'داشبورد')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>خوش آمدید</h1>
            <p>به سیستم مدیریت پروژه‌ها خوش آمدید.</p>

            <div class="row mt-4">

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">پروژه‌ها</h5>
                            <p class="card-text">مدیریت پروژه‌ها و فایل‌های آن‌ها</p>
                            <a href="{{ route('panel.projects.index') }}" class="btn btn-primary">مشاهده</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">کارمندان</h5>
                            <p class="card-text">مدیریت کارمندان</p>
                            <a href="{{ route('panel.employees.index') }}" class="btn btn-primary">مشاهده</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
