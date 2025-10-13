<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share common task data with views
        View::composer('admin.tasks.*', function ($view) {
            $view->with('taskStatuses', [
                'pending' => 'در انتظار',
                'in_progress' => 'در حال انجام',
                'completed' => 'تکمیل شده',
                'cancelled' => 'لغو شده'
            ]);

            $view->with('taskPriorities', [
                'low' => 'کم',
                'medium' => 'متوسط',
                'high' => 'زیاد',
                'urgent' => 'فوری'
            ]);

            $view->with('assignmentTypes', [
                'primary' => 'اصلی',
                'collaborator' => 'مشارکت کننده',
                'reviewer' => 'بررسی کننده',
                'observer' => 'ناظر'
            ]);

            $view->with('collaborationTypes', [
                'contributor' => 'مشارکت کننده',
                'reviewer' => 'بررسی کننده',
                'advisor' => 'مشاور',
                'observer' => 'ناظر',
                'supporter' => 'پشتیبان'
            ]);

            $view->with('requestTypes', [
                'start_work' => 'درخواست شروع کار',
                'complete_work' => 'درخواست تکمیل کار',
                'extend_deadline' => 'درخواست تمدید مهلت',
                'change_priority' => 'درخواست تغییر اولویت',
                'add_collaborator' => 'درخواست افزودن مشارکت کننده',
                'remove_collaborator' => 'درخواست حذف مشارکت کننده',
                'change_requirements' => 'درخواست تغییر الزامات',
                'pause_work' => 'درخواست توقف کار',
                'resume_work' => 'درخواست ادامه کار'
            ]);
        });
    }
}
