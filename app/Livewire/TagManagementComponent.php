<?php

namespace App\Livewire;

use App\Models\Tag;
use App\Models\TagCategory;
use Livewire\Component;
use Livewire\WithPagination;

class TagManagementComponent extends Component
{
    use WithPagination;

    public $selectedTags = [];
    public $search = '';
    public $categoryFilter = '';
    public $showModal = false;
    public $editingTag = null;
    public $tagName = '';
    public $tagColor = '#007bff';
    public $tagDescription = '';
    public $tagCategoryId = '';
    public $isFolderTag = false;
    public $isActive = true;
    public $allowedExtensions = '';
    public $allowedMimeTypes = '';

    protected $rules = [
        'tagName' => 'required|string|max:255',
        'tagColor' => 'required|string',
        'tagDescription' => 'nullable|string',
        'tagCategoryId' => 'required|exists:tag_categories,id',
        'isFolderTag' => 'boolean',
        'isActive' => 'boolean',
        'allowedExtensions' => 'nullable|string',
        'allowedMimeTypes' => 'nullable|string'
    ];

    public function mount($selectedTags = [])
    {
        $this->selectedTags = $selectedTags;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter()
    {
        $this->resetPage();
    }

    public function toggleTag($tagId)
    {
        if (in_array($tagId, $this->selectedTags)) {
            $this->selectedTags = array_diff($this->selectedTags, [$tagId]);
        } else {
            $this->selectedTags[] = $tagId;
        }
    }

    public function selectAll()
    {
        $this->selectedTags = $this->getFilteredTags()->pluck('id')->toArray();
    }

    public function deselectAll()
    {
        $this->selectedTags = [];
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->editingTag = null;
    }

    public function openEditModal($tagId)
    {
        $tag = Tag::findOrFail($tagId);
        $this->editingTag = $tag;
        $this->tagName = $tag->name;
        $this->tagColor = $tag->color;
        $this->tagDescription = $tag->description;
        $this->tagCategoryId = $tag->category_id;
        $this->isFolderTag = $tag->is_folder_tag;
        $this->isActive = $tag->is_active;
        $this->allowedExtensions = is_array($tag->allowed_extensions) ? implode(', ', $tag->allowed_extensions) : '';
        $this->allowedMimeTypes = is_array($tag->allowed_mime_types) ? implode(', ', $tag->allowed_mime_types) : '';
        $this->showModal = true;
    }

    public function saveTag()
    {
        $this->validate();

        $data = [
            'name' => $this->tagName,
            'color' => $this->tagColor,
            'description' => $this->tagDescription,
            'category_id' => $this->tagCategoryId,
            'is_folder_tag' => $this->isFolderTag,
            'is_active' => $this->isActive,
            'allowed_extensions' => $this->allowedExtensions ? array_map('trim', explode(',', $this->allowedExtensions)) : null,
            'allowed_mime_types' => $this->allowedMimeTypes ? array_map('trim', explode(',', $this->allowedMimeTypes)) : null,
        ];

        if ($this->editingTag) {
            $this->editingTag->update($data);
            session()->flash('success', 'تگ با موفقیت به‌روزرسانی شد.');
        } else {
            Tag::create($data);
            session()->flash('success', 'تگ با موفقیت ایجاد شد.');
        }

        $this->closeModal();
    }

    public function deleteTag($tagId)
    {
        $tag = Tag::findOrFail($tagId);
        $tag->delete();
        session()->flash('success', 'تگ با موفقیت حذف شد.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->tagName = '';
        $this->tagColor = '#007bff';
        $this->tagDescription = '';
        $this->tagCategoryId = '';
        $this->isFolderTag = false;
        $this->isActive = true;
        $this->allowedExtensions = '';
        $this->allowedMimeTypes = '';
        $this->editingTag = null;
    }

    public function getFilteredTags()
    {
        $query = Tag::with('category');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        return $query->orderBy('name')->paginate(12);
    }

    public function render()
    {
        $tags = $this->getFilteredTags();
        $categories = TagCategory::orderBy('name')->get();

        return view('livewire.tag-management-component', [
            'tags' => $tags,
            'categories' => $categories
        ]);
    }
}
