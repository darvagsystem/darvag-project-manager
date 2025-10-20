<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">مدیریت وظایف</h3>
                        <div>
                            <button wire:click="showCreateTask" class="btn btn-primary">
                                <i class="fas fa-plus"></i> وظیفه جدید
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Filters -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <input type="text" wire:model.live="search" class="form-control" placeholder="جستجو در عنوان و توضیحات...">
                                    </div>
                                    <div class="col-md-2">
                                        <select wire:model.live="status" class="form-select">
                                            <option value="all">همه وضعیت‌ها</option>
                                            <option value="pending">در انتظار</option>
                                            <option value="in_progress">در حال انجام</option>
                                            <option value="completed">تکمیل شده</option>
                                            <option value="cancelled">لغو شده</option>
                                            <option value="on_hold">در انتظار</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select wire:model.live="priority" class="form-select">
                                            <option value="all">همه اولویت‌ها</option>
                                            <option value="low">پایین</option>
                                            <option value="normal">عادی</option>
                                            <option value="high">بالا</option>
                                            <option value="urgent">فوری</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select wire:model.live="assignedTo" class="form-select">
                                            <option value="all">همه کاربران</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select wire:model.live="projectId" class="form-select">
                                            <option value="all">همه پروژه‌ها</option>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model.live="showOverdue" id="showOverdue">
                                            <label class="form-check-label" for="showOverdue">
                                                معوق
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tasks Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>عنوان</th>
                                        <th>وضعیت</th>
                                        <th>اولویت</th>
                                        <th>واگذار شده به</th>
                                        <th>پروژه</th>
                                        <th>دسته‌بندی</th>
                                        <th>تاریخ سررسید</th>
                                        <th>پیشرفت</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tasks as $task)
                                        <tr class="{{ $task->is_overdue ? 'table-danger' : '' }}">
                                            <td>
<div>
                                                    <strong>{{ $task->title }}</strong>
                                                    @if($task->is_overdue)
                                                        <span class="badge bg-danger ms-1">معوق</span>
                                                    @endif
                                                    @if($task->description)
                                                        <br><small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'primary' : ($task->status == 'cancelled' ? 'danger' : 'warning')) }}">
                                                    {{ $task->formatted_status }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $task->priority == 'urgent' ? 'danger' : ($task->priority == 'high' ? 'warning' : ($task->priority == 'low' ? 'secondary' : 'info')) }}">
                                                    {{ $task->formatted_priority }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($task->assignedUser)
                                                    {{ $task->assignedUser->name }}
                                                @else
                                                    <span class="text-muted">واگذار نشده</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($task->project)
                                                    <a href="{{ route('panel.projects.show', $task->project) }}" class="text-decoration-none">
                                                        {{ $task->project->name }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">بدون پروژه</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($task->category)
                                                    <span class="badge" style="background-color: {{ $task->category->color }}; color: white;">
                                                        {{ $task->category->name }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">بدون دسته‌بندی</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($task->due_date)
                                                    {{ \App\Helpers\DateHelper::toPersianDateTime($task->due_date) }}
                                                @else
                                                    <span class="text-muted">تعین نشده</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $task->progress }}%">
                                                        {{ $task->progress }}%
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button wire:click="showEditTask({{ $task->id }})" class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button wire:click="updateTaskStatus({{ $task->id }}, 'completed')" class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button wire:click="deleteTask({{ $task->id }})" class="btn btn-sm btn-outline-danger" onclick="return confirm('آیا مطمئن هستید؟')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-4">
                                                هیچ وظیفه‌ای یافت نشد
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $tasks->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Task Modal -->
    @if($showCreateModal)
        <div class="modal fade show" style="display: block;" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ایجاد وظیفه جدید</h5>
                        <button type="button" wire:click="closeModals" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit="saveTask">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="title" class="form-label">عنوان وظیفه <span class="text-danger">*</span></label>
                                        <input type="text" wire:model="title" class="form-control" required>
                                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="description" class="form-label">توضیحات</label>
                                        <textarea wire:model="description" class="form-control" rows="3"></textarea>
                                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="priority" class="form-label">اولویت <span class="text-danger">*</span></label>
                                        <select wire:model="priority" class="form-select" required>
                                            <option value="low">پایین</option>
                                            <option value="normal">عادی</option>
                                            <option value="high">بالا</option>
                                            <option value="urgent">فوری</option>
                                        </select>
                                        @error('priority') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="assignedTo" class="form-label">واگذار شده به</label>
                                        <select wire:model="assignedTo" class="form-select">
                                            <option value="">انتخاب کنید...</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assignedTo') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="projectId" class="form-label">پروژه</label>
                                        <select wire:model="projectId" class="form-select">
                                            <option value="">بدون پروژه</option>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('projectId') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="categoryId" class="form-label">دسته‌بندی</label>
                                        <select wire:model="categoryId" class="form-select">
                                            <option value="">بدون دسته‌بندی</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('categoryId') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="dueDate" class="form-label">تاریخ سررسید</label>
                                        <input type="datetime-local" wire:model="dueDate" class="form-control">
                                        @error('dueDate') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closeModals" class="btn btn-secondary">انصراف</button>
                        <button type="button" wire:click="saveTask" class="btn btn-primary">ایجاد وظیفه</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Edit Task Modal -->
    @if($showEditModal)
        <div class="modal fade show" style="display: block;" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ویرایش وظیفه</h5>
                        <button type="button" wire:click="closeModals" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit="saveTask">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="title" class="form-label">عنوان وظیفه <span class="text-danger">*</span></label>
                                        <input type="text" wire:model="title" class="form-control" required>
                                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="description" class="form-label">توضیحات</label>
                                        <textarea wire:model="description" class="form-control" rows="3"></textarea>
                                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="priority" class="form-label">اولویت <span class="text-danger">*</span></label>
                                        <select wire:model="priority" class="form-select" required>
                                            <option value="low">پایین</option>
                                            <option value="normal">عادی</option>
                                            <option value="high">بالا</option>
                                            <option value="urgent">فوری</option>
                                        </select>
                                        @error('priority') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="assignedTo" class="form-label">واگذار شده به</label>
                                        <select wire:model="assignedTo" class="form-select">
                                            <option value="">انتخاب کنید...</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assignedTo') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="projectId" class="form-label">پروژه</label>
                                        <select wire:model="projectId" class="form-select">
                                            <option value="">بدون پروژه</option>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('projectId') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="categoryId" class="form-label">دسته‌بندی</label>
                                        <select wire:model="categoryId" class="form-select">
                                            <option value="">بدون دسته‌بندی</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('categoryId') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="dueDate" class="form-label">تاریخ سررسید</label>
                                        <input type="datetime-local" wire:model="dueDate" class="form-control">
                                        @error('dueDate') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closeModals" class="btn btn-secondary">انصراف</button>
                        <button type="button" wire:click="saveTask" class="btn btn-primary">به‌روزرسانی وظیفه</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
