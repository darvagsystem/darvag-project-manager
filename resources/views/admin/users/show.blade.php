@extends('admin.layout')

@section('title', 'مشاهده کاربر')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">مشاهده کاربر: {{ $user->name }}</h3>
                    <div class="btn-group" role="group">
                        <a href="{{ route('panel.users.edit', $user) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> ویرایش
                        </a>
                        <a href="{{ route('panel.users.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-right"></i> بازگشت
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">نام:</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>نام کاربری:</th>
                                    <td>{{ $user->username }}</td>
                                </tr>
                                <tr>
                                    <th>ایمیل:</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>تاریخ عضویت:</th>
                                    <td>{{ $user->created_at->format('Y/m/d H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>آخرین به‌روزرسانی:</th>
                                    <td>{{ $user->updated_at->format('Y/m/d H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>نقش‌ها:</h5>
                            @if($user->roles->count() > 0)
                                @foreach($user->roles as $role)
                                    <span class="badge bg-primary text-white px-2 py-1 rounded me-1 mb-1">{{ $role->name }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">هیچ نقشی تخصیص داده نشده</span>
                            @endif
                            
                            <h5 class="mt-4">مجوزها:</h5>
                            @if($user->getAllPermissions()->count() > 0)
                                <div class="row">
                                    @foreach($user->getAllPermissions() as $permission)
                                        <div class="col-md-6 mb-1">
                                            <code class="bg-light text-dark px-2 py-1 rounded">{{ $permission->name }}</code>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">هیچ مجوزی تخصیص داده نشده</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection