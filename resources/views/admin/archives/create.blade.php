@extends('admin.layout')

@section('title', 'ایجاد بایگانی جدید')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="page-title">ایجاد بایگانی جدید</h1>
                        <p class="page-subtitle">ایجاد بایگانی برای پروژه انتخاب شده</p>
                    </div>
                    <div>
                        <a href="{{ route('archives.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> بازگشت
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('archives.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="project_id" class="form-label">پروژه <span class="text-danger">*</span></label>
                                    <select class="form-select @error('project_id') is-invalid @enderror"
                                            id="project_id" name="project_id" required>
                                        <option value="">انتخاب پروژه</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">نام بایگانی <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">توضیحات</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">تگ‌های الزامی</label>
                            <div class="card">
                                <div class="card-body">
                                    @livewire('tag-management-component', ['selectedTags' => old('required_tags', [])])
                                </div>
                            </div>
                            <small class="form-text text-muted">تگ‌هایی که برای این پروژه الزامی هستند را انتخاب کنید</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-check"></i> ایجاد بایگانی
                            </button>
                            <a href="{{ route('archives.index') }}" class="btn btn-secondary">
                                <i class="mdi mdi-close"></i> انصراف
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
