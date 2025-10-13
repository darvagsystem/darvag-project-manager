@extends('admin.layout')

@section('title', 'مدیریت چک لیست‌ها')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-list-check me-2"></i>
                        مدیریت چک لیست‌ها
                    </h3>
                    <a href="{{ route('panel.checklists.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        چک لیست جدید
                    </a>
                </div>

                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <select class="form-select" id="categoryFilter">
                                <option value="">همه دسته‌بندی‌ها</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="statusFilter">
                                <option value="">همه وضعیت‌ها</option>
                                <option value="active">فعال</option>
                                <option value="completed">تکمیل شده</option>
                                <option value="paused">متوقف شده</option>
                                <option value="archived">آرشیو شده</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="searchInput" placeholder="جستجو در چک لیست‌ها...">
                        </div>
                    </div>

                    <!-- Checklists Grid -->
                    <div class="row" id="checklistsGrid">
                        @forelse($checklists as $checklist)
                            <div class="col-md-6 col-lg-4 mb-4 checklist-item"
                                 data-category="{{ $checklist->category_id }}"
                                 data-status="{{ $checklist->status }}"
                                 data-title="{{ $checklist->title }}">
                                <div class="card h-100 checklist-card" style="border-left: 4px solid {{ $checklist->color }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h5 class="card-title mb-0">{{ $checklist->title }}</h5>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('panel.checklists.show', $checklist) }}"></a>
                                                        <i class="fas fa-eye me-2"></i>مشاهده
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="{{ route('panel.checklists.edit', $checklist) }}">
                                                        <i class="fas fa-edit me-2"></i>ویرایش
                                                    </a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('panel.checklists.destroy', $checklist) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger"
                                                                    onclick="return confirm('آیا مطمئن هستید؟')">
                                                                <i class="fas fa-trash me-2"></i>حذف
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        @if($checklist->description)
                                            <p class="card-text text-muted small mb-3">{{ Str::limit($checklist->description, 100) }}</p>
                                        @endif

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            @if($checklist->category)
                                                <span class="badge" style="background-color: {{ $checklist->category->color }}20; color: {{ $checklist->category->color }}">
                                                    {{ $checklist->category->name }}
                                                </span>
                                            @endif
                                            <span class="badge bg-{{ $checklist->status === 'active' ? 'success' : ($checklist->status === 'completed' ? 'primary' : 'warning') }}">
                                                {{ $checklist->formatted_status }}
                                            </span>
                                        </div>

                                        <!-- Progress Bar -->
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <small class="text-muted">پیشرفت</small>
                                                <small class="text-muted">{{ $checklist->progress_percentage }}</small>
                                            </div>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: {{ $checklist->progress_percentage }}; background-color: {{ $checklist->color }}"
                                                     aria-valuenow="{{ $checklist->progress_percentage }}"
                                                     aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Stats -->
                                        <div class="d-flex justify-content-between align-items-center text-muted small">
                                            <span>
                                                <i class="fas fa-check-circle me-1"></i>
                                                {{ $checklist->completed_items_count }} از {{ $checklist->total_items_count }}
                                            </span>
                                            @if($checklist->due_date)
                                                <span>
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ \App\Services\PersianDateService::carbonToPersian($checklist->due_date) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-list-check fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">هنوز چک لیستی ایجاد نکرده‌اید</h5>
                                    <p class="text-muted">برای شروع، اولین چک لیست خود را ایجاد کنید</p>
                                    <a href="{{ route('panel.checklists.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i>
                                        ایجاد چک لیست
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($checklists->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $checklists->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.checklist-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    cursor: pointer;
}

.checklist-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.progress {
    border-radius: 3px;
}

.badge {
    font-size: 0.75rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');
    const searchInput = document.getElementById('searchInput');
    const checklistsGrid = document.getElementById('checklistsGrid');

    function filterChecklists() {
        const categoryValue = categoryFilter.value;
        const statusValue = statusFilter.value;
        const searchValue = searchInput.value.toLowerCase();

        const checklistItems = checklistsGrid.querySelectorAll('.checklist-item');

        checklistItems.forEach(item => {
            const category = item.dataset.category;
            const status = item.dataset.status;
            const title = item.dataset.title.toLowerCase();

            const categoryMatch = !categoryValue || category === categoryValue;
            const statusMatch = !statusValue || status === statusValue;
            const searchMatch = !searchValue || title.includes(searchValue);

            if (categoryMatch && statusMatch && searchMatch) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    categoryFilter.addEventListener('change', filterChecklists);
    statusFilter.addEventListener('change', filterChecklists);
    searchInput.addEventListener('input', filterChecklists);

    // Make cards clickable
    document.querySelectorAll('.checklist-card').forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                const checklistId = this.closest('.checklist-item').dataset.checklistId;
                window.location.href = `{{ route('panel.checklists.index') }}/${checklistId}`;
            }
        });
    });
});
</script>
@endpush
