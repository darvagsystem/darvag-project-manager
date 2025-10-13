<!-- Create Folder Modal -->
<div class="modal fade" id="createFolderModal" tabindex="-1" aria-labelledby="createFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createFolderModalLabel">ایجاد پوشه جدید</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createFolderForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="folderName" class="form-label">نام پوشه</label>
                        <input type="text" class="form-control" id="folderName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="folderDescription" class="form-label">توضیحات (اختیاری)</label>
                        <textarea class="form-control" id="folderDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="folderColor" class="form-label">رنگ پوشه</label>
                        <select class="form-select" id="folderColor" name="folder_color">
                            <option value="">رنگ پیش‌فرض</option>
                            <option value="#ffc107">زرد</option>
                            <option value="#28a745">سبز</option>
                            <option value="#dc3545">قرمز</option>
                            <option value="#007bff">آبی</option>
                            <option value="#6f42c1">بنفش</option>
                            <option value="#fd7e14">نارنجی</option>
                            <option value="#20c997">فیروزه‌ای</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">تگ‌ها (اختیاری)</label>
                        <div id="folderTags" class="tag-selection">
                            @foreach(\App\Models\Tag::all() as $tag)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="folder_tag_{{ $tag->id }}">
                                    <label class="form-check-label" for="folder_tag_{{ $tag->id }}" style="color: {{ $tag->color }}">
                                        {{ $tag->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary">ایجاد پوشه</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Rename Modal -->
<div class="modal fade" id="renameModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="renameModalLabel">تغییر نام</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="renameForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="newName" class="form-label">نام جدید</label>
                        <input type="text" class="form-control" id="newName" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary">تغییر نام</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Move Modal -->
<div class="modal fade" id="moveModal" tabindex="-1" aria-labelledby="moveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="moveModalLabel">انتقال فایل/پوشه</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="moveForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="moveDestination" class="form-label">مقصد</label>
                        <select class="form-select" id="moveDestination" name="destination_folder_id">
                            <option value="">انتخاب پوشه مقصد</option>
                            <!-- Options will be populated by JavaScript -->
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary">انتقال</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">تأیید حذف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="mdi mdi-alert-circle me-2"></i>
                    آیا مطمئن هستید که می‌خواهید این آیتم را حذف کنید؟
                </div>
                <p id="deleteMessage">این عمل قابل بازگشت نیست.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">حذف</button>
            </div>
        </div>
    </div>
</div>

<!-- File Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">جزئیات فایل</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailsContent">
                <!-- Content will be loaded by JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
</div>

