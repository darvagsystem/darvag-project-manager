@extends('admin.layout')

@section('title', 'جزئیات پیام تماس')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">جزئیات پیام تماس</h1>
            <p class="text-muted">مشاهده و مدیریت پیام دریافتی</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-right me-1"></i>
                بازگشت به لیست
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Message Details -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">جزئیات پیام</h6>
                    <div class="d-flex gap-2">
                        @if($contactMessage->status === 'new')
                            <button class="btn btn-sm btn-success" onclick="markAsRead({{ $contactMessage->id }})">
                                <i class="fas fa-check me-1"></i>
                                علامت‌گذاری به عنوان خوانده شده
                            </button>
                        @endif
                        @if($contactMessage->status !== 'replied')
                            <button class="btn btn-sm btn-info" onclick="markAsReplied({{ $contactMessage->id }})">
                                <i class="fas fa-reply me-1"></i>
                                علامت‌گذاری به عنوان پاسخ داده شده
                            </button>
                        @endif
                        @if($contactMessage->status !== 'closed')
                            <button class="btn btn-sm btn-warning" onclick="markAsClosed({{ $contactMessage->id }})">
                                <i class="fas fa-lock me-1"></i>
                                بستن پیام
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-primary">اطلاعات فرستنده</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="120"><strong>نام:</strong></td>
                                    <td>{{ $contactMessage->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>ایمیل:</strong></td>
                                    <td>
                                        <a href="mailto:{{ $contactMessage->email }}" class="text-decoration-none">
                                            {{ $contactMessage->email }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>تلفن:</strong></td>
                                    <td>
                                        <a href="tel:{{ $contactMessage->phone }}" class="text-decoration-none">
                                            {{ $contactMessage->phone }}
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">اطلاعات پیام</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="120"><strong>موضوع:</strong></td>
                                    <td>
                                        <span class="badge bg-info">{{ $contactMessage->subject_name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>وضعیت:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $contactMessage->status_color }}">
                                            {{ $contactMessage->status_name }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>تاریخ ارسال:</strong></td>
                                    <td>{{ $contactMessage->created_at->format('Y/m/d H:i:s') }}</td>
                                </tr>
                                @if($contactMessage->read_at)
                                    <tr>
                                        <td><strong>تاریخ خواندن:</strong></td>
                                        <td>{{ $contactMessage->read_at->format('Y/m/d H:i:s') }}</td>
                                    </tr>
                                @endif
                                @if($contactMessage->replied_at)
                                    <tr>
                                        <td><strong>تاریخ پاسخ:</strong></td>
                                        <td>{{ $contactMessage->replied_at->format('Y/m/d H:i:s') }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-primary">متن پیام</h6>
                        <div class="bg-light p-3 rounded border">
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $contactMessage->message }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Actions -->
        <div class="col-lg-4">
            <!-- Status Management -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">مدیریت وضعیت</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.contact-messages.update', $contactMessage) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">وضعیت</label>
                            <select name="status" id="status" class="form-select">
                                @foreach(\App\Models\ContactMessage::STATUSES as $key => $value)
                                    <option value="{{ $key }}" {{ $contactMessage->status === $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="admin_notes" class="form-label">یادداشت ادمین</label>
                            <textarea name="admin_notes" id="admin_notes" rows="4" 
                                      class="form-control" 
                                      placeholder="یادداشت‌های خود را اینجا بنویسید...">{{ $contactMessage->admin_notes }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i>
                            ذخیره تغییرات
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">عملیات سریع</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $contactMessage->email }}?subject=پاسخ به پیام شما" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-envelope me-1"></i>
                            ارسال ایمیل پاسخ
                        </a>
                        
                        <a href="tel:{{ $contactMessage->phone }}" 
                           class="btn btn-outline-success">
                            <i class="fas fa-phone me-1"></i>
                            تماس تلفنی
                        </a>
                        
                        <button class="btn btn-outline-info" onclick="copyToClipboard('{{ $contactMessage->email }}')">
                            <i class="fas fa-copy me-1"></i>
                            کپی ایمیل
                        </button>
                        
                        <button class="btn btn-outline-secondary" onclick="copyToClipboard('{{ $contactMessage->phone }}')">
                            <i class="fas fa-copy me-1"></i>
                            کپی شماره تلفن
                        </button>
                    </div>
                </div>
            </div>

            <!-- Message Statistics -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">آمار پیام</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary">{{ $contactMessage->created_at->diffForHumans() }}</h4>
                                <small class="text-muted">زمان ارسال</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">{{ $contactMessage->created_at->format('H:i') }}</h4>
                            <small class="text-muted">ساعت ارسال</small>
                        </div>
                    </div>
                    
                    @if($contactMessage->read_at)
                        <hr>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h4 class="text-warning">{{ $contactMessage->read_at->diffForHumans() }}</h4>
                                    <small class="text-muted">زمان خواندن</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="text-info">{{ $contactMessage->read_at->format('H:i') }}</h4>
                                <small class="text-muted">ساعت خواندن</small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function markAsRead(messageId) {
    fetch(`{{ url('panel/contact-messages') }}/${messageId}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('خطا در بروزرسانی وضعیت');
    });
}

function markAsReplied(messageId) {
    fetch(`{{ url('panel/contact-messages') }}/${messageId}/mark-replied`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('خطا در بروزرسانی وضعیت');
    });
}

function markAsClosed(messageId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این پیام را ببندید؟')) {
        fetch(`{{ url('panel/contact-messages') }}/${messageId}/mark-closed`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('خطا در بروزرسانی وضعیت');
        });
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('کپی شد: ' + text);
    }, function(err) {
        console.error('Could not copy text: ', err);
        alert('خطا در کپی کردن');
    });
}
</script>
@endpush
