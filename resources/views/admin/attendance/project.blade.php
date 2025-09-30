@extends('admin.layout')

@section('title', 'حضور و غیاب کارکنان - ' . $project->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @livewire('attendance-component', ['projectId' => $project->id])
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
