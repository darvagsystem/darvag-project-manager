{{-- Modal Usage Examples --}}
{{-- This file shows how to use the dynamic modal in different scenarios --}}

<!-- Example 1: Simple Message Modal -->
<button onclick="showMessage()" class="btn btn-info">نمایش پیام</button>

<!-- Example 2: Confirmation Modal -->
<button onclick="showConfirm()" class="btn btn-warning">تأیید حذف</button>

<!-- Example 3: Form Modal -->
<button onclick="showForm()" class="btn btn-primary">فرم جدید</button>

<!-- Example 4: Loading Modal -->
<button onclick="showLoading()" class="btn btn-secondary">نمایش بارگذاری</button>

<script>
// Example 1: Show simple message
function showMessage() {
    ModalManager.message({
        title: 'اطلاعات',
        message: 'این یک پیام ساده است',
        icon: 'mdi mdi-information',
        color: '#17a2b8',
        size: 'modal-sm'
    });
}

// Example 2: Show confirmation dialog
function showConfirm() {
    ModalManager.confirm({
        title: 'تأیید حذف',
        message: 'آیا از حذف این آیتم اطمینان دارید؟',
        icon: 'mdi mdi-delete-alert',
        color: '#dc3545',
        confirmText: 'حذف',
        cancelText: 'انصراف',
        confirmButtonClass: 'btn-danger'
    }).then(confirmed => {
        if (confirmed) {
            console.log('User confirmed deletion');
            // Perform deletion logic here
        } else {
            console.log('User cancelled deletion');
        }
    });
}

// Example 3: Show form modal
function showForm() {
    ModalManager.form({
        title: 'ایجاد آیتم جدید',
        size: 'modal-lg',
        fields: [
            {
                name: 'name',
                type: 'text',
                label: 'نام',
                placeholder: 'نام آیتم را وارد کنید',
                required: true,
                value: ''
            },
            {
                name: 'email',
                type: 'email',
                label: 'ایمیل',
                placeholder: 'ایمیل را وارد کنید',
                required: true,
                value: ''
            },
            {
                name: 'category',
                type: 'select',
                label: 'دسته‌بندی',
                placeholder: 'دسته‌بندی را انتخاب کنید',
                required: true,
                options: [
                    { value: '1', label: 'دسته‌بندی 1' },
                    { value: '2', label: 'دسته‌بندی 2' },
                    { value: '3', label: 'دسته‌بندی 3' }
                ],
                value: ''
            },
            {
                name: 'description',
                type: 'textarea',
                label: 'توضیحات',
                placeholder: 'توضیحات را وارد کنید',
                rows: 4,
                value: ''
            },
            {
                name: 'is_active',
                type: 'checkbox',
                label: 'فعال است',
                value: false
            }
        ],
        onSubmit: function(formData, callback) {
            // Simulate API call
            console.log('Form data:', formData);

            // Simulate validation
            const errors = {};
            if (!formData.name) {
                errors.name = 'نام الزامی است';
            }
            if (!formData.email) {
                errors.email = 'ایمیل الزامی است';
            }
            if (!formData.category) {
                errors.category = 'دسته‌بندی الزامی است';
            }

            // Simulate API delay
            setTimeout(() => {
                if (Object.keys(errors).length > 0) {
                    callback(false, errors);
                } else {
                    callback(true);
                    console.log('Form submitted successfully');
                }
            }, 1000);
        }
    });
}

// Example 4: Show loading modal
function showLoading() {
    ModalManager.loading({
        title: 'در حال پردازش',
        message: 'لطفاً صبر کنید...'
    });

    // Hide after 3 seconds
    setTimeout(() => {
        ModalManager.hide();
    }, 3000);
}

// Example 5: Success message
function showSuccess() {
    ModalManager.message({
        title: 'موفق',
        message: 'عملیات با موفقیت انجام شد',
        icon: 'mdi mdi-check-circle',
        color: '#28a745',
        size: 'modal-sm'
    });
}

// Example 6: Error message
function showError() {
    ModalManager.message({
        title: 'خطا',
        message: 'خطا در انجام عملیات',
        icon: 'mdi mdi-alert-circle',
        color: '#dc3545',
        size: 'modal-sm'
    });
}

// Example 7: Warning message
function showWarning() {
    ModalManager.message({
        title: 'هشدار',
        message: 'این عملیات ممکن است خطرناک باشد',
        icon: 'mdi mdi-alert',
        color: '#ffc107',
        size: 'modal-sm'
    });
}

// Example 8: Complex form with validation
function showComplexForm() {
    ModalManager.form({
        title: 'فرم پیچیده',
        size: 'modal-xl',
        fields: [
            {
                name: 'title',
                type: 'text',
                label: 'عنوان',
                placeholder: 'عنوان را وارد کنید',
                required: true,
                help: 'عنوان باید حداقل 3 کاراکتر باشد'
            },
            {
                name: 'type',
                type: 'radio',
                label: 'نوع',
                required: true,
                options: [
                    { value: 'public', label: 'عمومی' },
                    { value: 'private', label: 'خصوصی' },
                    { value: 'draft', label: 'پیش‌نویس' }
                ]
            },
            {
                name: 'tags',
                type: 'text',
                label: 'برچسب‌ها',
                placeholder: 'برچسب‌ها را با کاما جدا کنید',
                help: 'مثال: تگ1, تگ2, تگ3'
            },
            {
                name: 'notifications',
                type: 'checkbox',
                label: 'ارسال اعلان',
                value: true
            }
        ],
        onSubmit: function(formData, callback) {
            // Complex validation
            const errors = {};

            if (!formData.title || formData.title.length < 3) {
                errors.title = 'عنوان باید حداقل 3 کاراکتر باشد';
            }

            if (!formData.type) {
                errors.type = 'نوع الزامی است';
            }

            // Simulate API call
            setTimeout(() => {
                if (Object.keys(errors).length > 0) {
                    callback(false, errors);
                } else {
                    callback(true);
                    console.log('Complex form submitted:', formData);
                }
            }, 1500);
        }
    });
}
</script>

{{--
    Modal Types:
    1. message - Simple message display
    2. confirm - Confirmation dialog
    3. form - Form with fields
    4. loading - Loading indicator

    Available Field Types:
    - text, email, password
    - textarea
    - select
    - checkbox
    - radio

    Modal Sizes:
    - modal-sm (300px)
    - modal-md (500px) - default
    - modal-lg (800px)
    - modal-xl (1140px)

    Usage:
    ModalManager.message({...})
    ModalManager.confirm({...})
    ModalManager.form({...})
    ModalManager.loading({...})
    ModalManager.hide()
--}}
