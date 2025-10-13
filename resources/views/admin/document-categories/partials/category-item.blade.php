<div class="category-item" style="margin-right: {{ $level * 2 }}rem;">
    <div class="category-header">
        <div class="category-info" style="cursor: pointer;">
            @if($category->children->count() > 0)
                <i class="mdi mdi-chevron-right toggle-icon"></i>
            @else
                <i class="mdi mdi-minus" style="color: #6c757d; margin-left: 1.5rem;"></i>
            @endif

            <div class="category-icon" style="background-color: {{ $category->color }};">
                <i class="{{ $category->icon }}"></i>
            </div>

            <div class="category-details">
                <div class="category-name">{{ $category->name }}</div>
                <div class="category-meta">
                    <span class="badge bg-{{ $category->status_color }}">{{ $category->status_text }}</span>
                    <span class="text-muted ms-2">
                        <i class="mdi mdi-file-document-multiple me-1"></i>
                        {{ $category->documents_count ?? 0 }} سند
                    </span>
                    @if($category->description)
                        <span class="text-muted ms-2">{{ Str::limit($category->description, 50) }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="category-actions">
            <a href="{{ route('panel.document-categories.show', $category) }}" class="btn btn-sm btn-outline-info" title="مشاهده">
                <i class="mdi mdi-eye"></i>
            </a>
            <a href="{{ route('panel.document-categories.edit', $category) }}" class="btn btn-sm btn-outline-primary" title="ویرایش">
                <i class="mdi mdi-pencil"></i>
            </a>
            <button type="button" class="btn btn-sm btn-outline-{{ $category->is_active ? 'warning' : 'success' }}"
                    onclick="toggleStatus({{ $category->id }})" title="{{ $category->is_active ? 'غیرفعال کردن' : 'فعال کردن' }}">
                <i class="mdi mdi-{{ $category->is_active ? 'pause' : 'play' }}"></i>
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger"
                    onclick="deleteCategory({{ $category->id }}, '{{ $category->name }}')" title="حذف">
                <i class="mdi mdi-delete"></i>
            </button>
        </div>
    </div>

    @if($category->children->count() > 0)
        <div class="category-children">
            @foreach($category->children as $child)
                @include('admin.document-categories.partials.category-item', ['category' => $child, 'level' => $level + 1])
            @endforeach
        </div>
    @endif
</div>
