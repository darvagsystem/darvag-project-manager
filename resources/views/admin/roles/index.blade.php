@extends('admin.layout')

@section('title', 'مدیریت نقش‌ها')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">لیست نقش‌ها</h3>
                    <a href="#" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> افزودن نقش
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>نام</th>
                                    <th>تعداد کاربران</th>
                                    <th>تعداد مجوزها</th>
                                    <th>تاریخ ایجاد</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\Spatie\Permission\Models\Role::withCount(['users', 'permissions'])->get() as $role)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary text-white px-2 py-1 rounded">{{ $role->name }}</span>
                                    </td>
                                    <td>{{ $role->users_count }}</td>
                                    <td>{{ $role->permissions_count }}</td>
                                    <td>{{ $role->created_at->format('Y/m/d') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="#" class="btn btn-sm btn-info" title="مشاهده">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-warning" title="ویرایش">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-danger" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
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
