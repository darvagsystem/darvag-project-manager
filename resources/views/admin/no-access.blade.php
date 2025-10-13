@extends('admin.layout')

@section('title', 'عدم دسترسی')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="mb-3">عدم دسترسی</h3>
                    <p class="text-muted mb-4">
                        شما به این بخش دسترسی ندارید. لطفاً با مدیر سیستم تماس بگیرید تا نقش و مجوزهای مناسب برای شما تعریف شود.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('panel.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-home"></i> بازگشت به داشبورد
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="fas fa-sign-out-alt"></i> خروج از سیستم
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
