@extends('admin.layout')

@section('title', 'تست فرم کارمند')

@section('content')
<div class="container">
    <h1>تست فرم کارمند</h1>

    <form method="POST" action="{{ route('employees.test-store') }}">
        @csrf

        <div>
            <label>نام:</label>
            <input type="text" name="first_name" value="احمد" required>
        </div>

        <div>
            <label>نام خانوادگی:</label>
            <input type="text" name="last_name" value="رضایی" required>
        </div>

        <div>
            <label>کد ملی:</label>
            <input type="text" name="national_code" value="1234567890" required>
        </div>

        <div>
            <label>وضعیت تأهل:</label>
            <select name="marital_status">
                <option value="single">مجرد</option>
                <option value="married">متأهل</option>
            </select>
        </div>

        <div>
            <label>تحصیلات:</label>
            <select name="education">
                <option value="diploma">دیپلم</option>
                <option value="bachelor">کارشناسی</option>
            </select>
        </div>

        <div>
            <label>وضعیت:</label>
            <select name="status">
                <option value="active">فعال</option>
                <option value="inactive">غیرفعال</option>
            </select>
        </div>

        <button type="submit">ثبت تست</button>
    </form>

    @if(session('success'))
        <div style="color: green; margin-top: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="color: red; margin-top: 20px;">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div style="color: red; margin-top: 20px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
