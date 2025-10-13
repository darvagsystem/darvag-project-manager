@extends('admin.layout')

@section('title', 'مدیریت مجوزها')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">لیست مجوزها</h3>
                    <a href="#" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> افزودن مجوز
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>نام</th>
                                    <th>تعداد نقش‌ها</th>
                                    <th>تاریخ ایجاد</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\Spatie\Permission\Models\Permission::withCount('roles')->get() as $permission)
                                <tr>
                                    <td>
                                        <code class="bg-light text-dark px-2 py-1 rounded">{{ $permission->name }}</code>
                                    </td>
                                    <td>{{ $permission->roles_count }}</td>
                                    <td>{{ $permission->created_at->format('Y/m/d') }}</td>
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
