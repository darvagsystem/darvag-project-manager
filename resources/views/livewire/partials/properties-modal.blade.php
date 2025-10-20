@if($showPropertiesModal && $propertiesItem)
<div class="modal-backdrop" wire:click="$set('showPropertiesModal', false)">
    <div class="modal-container modal-lg" wire:click.stop>
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="mdi mdi-information me-2"></i>ویژگی‌ها
                </h5>
                <button type="button" class="btn-close" wire:click="$set('showPropertiesModal', false)"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            <i class="mdi {{ $propertiesType === 'folder' ? 'mdi-folder' : 'mdi-file' }}"
                               style="font-size: 64px; color: {{ $propertiesType === 'folder' ? ($propertiesItem->color ?? '#6c757d') : '#6c757d' }};"></i>
                            <h6 class="mt-2">{{ $propertiesItem->name }}</h6>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-semibold">نام:</td>
                                <td>{{ $propertiesItem->name }}</td>
                            </tr>

                            @if($propertiesType === 'file')
                                <tr>
                                    <td class="fw-semibold">نوع فایل:</td>
                                    <td>{{ strtoupper($propertiesItem->extension) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">اندازه:</td>
                                    <td>{{ $propertiesItem->human_size }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">MIME Type:</td>
                                    <td>{{ $propertiesItem->mime_type }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td class="fw-semibold">وضعیت:</td>
                                <td>
                                    @if($propertiesItem->is_required)
                                        <span class="badge bg-danger">الزامی</span>
                                    @else
                                        <span class="badge bg-secondary">اختیاری</span>
                                    @endif
                                </td>
                            </tr>

                            @if($propertiesItem->description)
                                <tr>
                                    <td class="fw-semibold">توضیحات:</td>
                                    <td>{{ $propertiesItem->description }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td class="fw-semibold">ایجاد شده:</td>
                                <td>{{ \App\Helpers\DateHelper::toPersianDateTime($propertiesItem->created_at) }}</td>
                            </tr>

                            <tr>
                                <td class="fw-semibold">آخرین تغییر:</td>
                                <td>{{ \App\Helpers\DateHelper::toPersianDateTime($propertiesItem->updated_at) }}</td>
                            </tr>

                            @if($propertiesType === 'file' && $propertiesItem->tag_requirements)
                                <tr>
                                    <td class="fw-semibold">تگ‌ها:</td>
                                    <td>
                                        @foreach($propertiesItem->tag_requirements as $tagId)
                                            @php $tag = $tags->find($tagId) @endphp
                                            @if($tag)
                                                <span class="badge me-1" style="background-color: {{ $tag->color }}; color: white; font-weight: 500; padding: 4px 8px;">
                                                    {{ $tag->name }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="$set('showPropertiesModal', false)">
                    <i class="mdi mdi-close me-1"></i>بستن
                </button>
                @if($propertiesType === 'file')
                    <button type="button" class="btn btn-primary" wire:click="downloadFile({{ $propertiesItem->id }})">
                        <i class="mdi mdi-download me-1"></i>دانلود
                    </button>
                @endif
            </div>
        </div>
    </div>

<style>
.modal-lg {
    max-width: 800px;
}
</style>
@endif
