@extends('admin.layout')

@section('title', 'حضور و غیاب کارکنان')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="mdi mdi-information me-2"></i>
                لطفاً ابتدا یک پروژه انتخاب کنید تا بتوانید حضور و غیاب کارکنان آن را مدیریت کنید.
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <i class="mdi mdi-folder-open display-4 text-muted mb-3"></i>
                    <h5>انتخاب پروژه</h5>
                    <p class="text-muted">برای مدیریت حضور و غیاب، ابتدا از لیست پروژه‌ها یکی را انتخاب کنید.</p>
                    <a href="{{ route('projects.index') }}" class="btn btn-primary">
                        <i class="mdi mdi-folder me-1"></i>
                        مشاهده پروژه‌ها
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('livewire:init', function () {
    // Auto-refresh every 5 minutes
    setInterval(function() {
        Livewire.dispatch('loadData');
    }, 300000);

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl + A for select all
        if (e.ctrlKey && e.key === 'a') {
            e.preventDefault();
            Livewire.dispatch('toggleSelectAll');
        }

        // Escape to clear selection
        if (e.key === 'Escape') {
            Livewire.dispatch('clearSelection');
        }
    });
});
</script>
@endpush
