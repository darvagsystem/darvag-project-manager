{{-- Example usage of Icon Picker Component --}}
{{-- This file shows how to use the icon picker in different scenarios --}}

{{-- Basic Usage --}}
@include('admin.partials.icon-picker')

{{-- Custom Parameters --}}
@include('admin.partials.icon-picker', [
    'inputId' => 'category_icon',
    'inputName' => 'category_icon',
    'label' => 'آیکون دسته‌بندی',
    'value' => old('category_icon', 'mdi mdi-folder')
])

{{-- Multiple Icon Pickers on Same Page --}}
@include('admin.partials.icon-picker', [
    'inputId' => 'main_icon',
    'inputName' => 'main_icon',
    'label' => 'آیکون اصلی',
    'value' => old('main_icon', 'mdi mdi-star')
])

@include('admin.partials.icon-picker', [
    'inputId' => 'secondary_icon',
    'inputName' => 'secondary_icon',
    'label' => 'آیکون فرعی',
    'value' => old('secondary_icon', 'mdi mdi-heart')
])

{{-- With Error Handling --}}
@include('admin.partials.icon-picker', [
    'inputId' => 'user_icon',
    'inputName' => 'user_icon',
    'label' => 'آیکون کاربر',
    'value' => old('user_icon', $user->icon ?? 'mdi mdi-account')
])

{{--
    Available Icon Categories:
    - Folders: mdi-folder, mdi-folder-open, mdi-folder-multiple
    - Files: mdi-file-document, mdi-file-pdf-box, mdi-file-word-box
    - Users: mdi-account, mdi-account-group, mdi-account-supervisor
    - Business: mdi-briefcase, mdi-office-building, mdi-bank
    - Charts: mdi-chart-bar, mdi-chart-pie, mdi-chart-line
    - Tools: mdi-cog, mdi-settings, mdi-wrench
    - And many more...
--}}
