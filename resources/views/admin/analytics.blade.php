@extends('admin.layout')

@section('title', 'تحلیل‌ها و گزارش‌ها')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-info">
            <div class="breadcrumb">
                <a href="{{ route('panel.dashboard') }}" class="breadcrumb-link">داشبورد</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">تحلیل‌ها و گزارش‌ها</span>
            </div>
            <h1 class="page-title">تحلیل‌ها و گزارش‌ها</h1>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">گزارش‌های تحلیلی</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="mdi mdi-information"></i>
                        این بخش در حال توسعه است و به زودی در دسترس خواهد بود.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
