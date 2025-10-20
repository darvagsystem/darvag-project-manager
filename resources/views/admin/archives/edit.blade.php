@extends('admin.layout')

@section('title', 'ویرایش بایگانی: ' . $archive->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="page-title">ویرایش بایگانی</h1>
                        <p class="page-subtitle">{{ $archive->name }}</p>
                    </div>
                    <div>
                        <a href="{{ route('archives.show', $archive) }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> بازگشت
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('archives.update', $archive) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">نام بایگانی <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', $archive->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">پروژه</label>
                                    <input type="text" class="form-control" value="{{ $archive->project->name }}" readonly>
                                    <small class="form-text text-muted">پروژه قابل تغییر نیست</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">توضیحات</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description', $archive->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">تگ‌های الزامی</label>
                            <div class="card">
                                <div class="card-body">
                                    @livewire('tag-management-component', ['selectedTags' => old('required_tags', $selectedTags)])
                                </div>
                            </div>
                            <small class="form-text text-muted">تگ‌هایی که برای این پروژه الزامی هستند را انتخاب کنید</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-check"></i> به‌روزرسانی بایگانی
                            </button>
                            <a href="{{ route('archives.show', $archive) }}" class="btn btn-secondary">
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
