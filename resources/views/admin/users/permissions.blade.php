@extends('admin.layout')

@section('title', 'مجوزهای کاربر')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-key me-2"></i>
                        مجوزهای کاربر: {{ $user->name }}
                    </h3>
                    <a href="{{ route('panel.users.show', $user) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right"></i> بازگشت
                    </a>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        مجوزهای کاربر از طریق نقش‌های اختصاص یافته به او تعیین می‌شوند. برای تغییر مجوزها، نقش‌های کاربر را ویرایش کنید.
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>نقش‌های فعلی</h5>
                            @if($user->roles->count() > 0)
                                @foreach($user->roles as $role)
                                    <div class="card mb-3">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <span class="badge me-2" style="background-color: {{ $role->color }}; color: white;">
                                                    {{ $role->name }}
                                                </span>
                                                @if($role->description)
                                                    <small class="text-muted">{{ $role->description }}</small>
                                                @endif
                                            </div>
                                            <a href="{{ route('panel.roles.show', $role) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <h6>مجوزهای این نقش:</h6>
                                            @if($role->permissions->count() > 0)
                                                <div class="row">
                                                    @foreach($role->permissions->groupBy('module') as $module => $permissions)
                                                        <div class="col-md-6">
                                                            <strong>{{ $permissions->first()->formatted_module }}:</strong>
                                                            <div class="mt-1">
                                                                @foreach($permissions as $permission)
                                                                    <span class="badge bg-secondary me-1 mb-1">
                                                                        {{ $permission->formatted_action }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-muted mb-0">این نقش مجوزی ندارد.</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted">این کاربر هیچ نقشی ندارد.</p>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <h5>مجوزهای کل کاربر</h5>
                            @if($user->getAllPermissions()->count() > 0)
                                <div class="row">
                                    @foreach($user->getAllPermissions()->groupBy('module') as $module => $permissions)
                                        <div class="col-12">
                                            <div class="card mb-3">
                                                <div class="card-header">
                                                    <h6 class="card-title mb-0">{{ $permissions->first()->formatted_module }}</h6>
                                                </div>
                                                <div class="card-body">
                                                    @foreach($permissions as $permission)
                                                        <span class="badge bg-primary me-1 mb-1">
                                                            {{ $permission->formatted_action }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">این کاربر هیچ مجوزی ندارد.</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>تغییر نقش‌ها</h5>
                        <p class="text-muted">برای تغییر نقش‌های کاربر، از دکمه ویرایش استفاده کنید:</p>
                        <a href="{{ route('panel.users.edit', $user) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> ویرایش نقش‌های کاربر
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
