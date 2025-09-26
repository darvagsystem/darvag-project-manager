<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanySetting;

class AdminController extends Controller
{
    protected $companySettings;

    /**
     * Constructor to share company settings across all admin views
     */
    public function __construct()
    {
        $this->companySettings = CompanySetting::getSettings();
        view()->share('companySettings', $this->companySettings);
    }

    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        // Get statistics for dashboard
        $stats = [
            'total_projects' => \App\Models\Project::count(),
            'active_projects' => \App\Models\Project::where('status', 'in_progress')->count(),
            'completed_projects' => \App\Models\Project::where('status', 'completed')->count(),
            'total_employees' => \App\Models\Employee::count(),
            'active_employees' => \App\Models\Employee::where('status', 'active')->count(),
            'total_clients' => \App\Models\Client::count(),
            'total_banks' => \App\Models\Bank::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Get statistics for API
     */
    public function getStats()
    {
        $stats = [
            'total_projects' => \App\Models\Project::count(),
            'active_projects' => \App\Models\Project::where('status', 'in_progress')->count(),
            'completed_projects' => \App\Models\Project::where('status', 'completed')->count(),
            'planning_projects' => \App\Models\Project::where('status', 'planning')->count(),
            'paused_projects' => \App\Models\Project::where('status', 'paused')->count(),
            'total_employees' => \App\Models\Employee::count(),
            'active_employees' => \App\Models\Employee::where('status', 'active')->count(),
            'inactive_employees' => \App\Models\Employee::where('status', 'inactive')->count(),
            'total_clients' => \App\Models\Client::count(),
            'active_clients' => \App\Models\Client::where('status', 'active')->count(),
            'total_banks' => \App\Models\Bank::count(),
            'total_project_value' => \App\Models\Project::sum('final_amount'),
            'average_project_value' => \App\Models\Project::avg('final_amount'),
            'total_initial_estimates' => \App\Models\Project::sum('initial_estimate'),
            'total_difference' => \App\Models\Project::sum('final_amount') - \App\Models\Project::sum('initial_estimate'),
        ];

        return response()->json($stats);
    }

    /**
     * Display analytics page.
     */
    public function analytics()
    {
        return view('admin.analytics');
    }

    /**
     * Display services management page.
     */
    public function services()
    {
        return view('admin.services');
    }

    /**
     * Display blog management page.
     */
    public function blog()
    {
        return view('admin.blog');
    }

    /**
     * Display gallery management page.
     */
    public function gallery()
    {
        return view('admin.gallery');
    }

    /**
     * Display users management page.
     */
    public function users()
    {
        return view('admin.users');
    }

    /**
     * Display roles management page.
     */
    public function roles()
    {
        return view('admin.roles');
    }

    /**
     * Display settings page.
     */
    public function settings()
    {
        return view('admin.settings.index');
    }

    /**
     * Display company settings page.
     */
    public function companySettings()
    {
        $settings = $this->companySettings;
        return view('admin.settings.company', compact('settings'));
    }

    /**
     * Update company settings.
     */
    public function settingsUpdate(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'nullable|string',
            'postal_code' => 'nullable|string|max:20',
            'ceo_name' => 'nullable|string|max:255',
            'national_id' => 'nullable|string|max:20',
            'economic_id' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only([
            'company_name', 'company_address', 'postal_code', 'ceo_name',
            'national_id', 'economic_id', 'phone', 'email', 'website', 'description'
        ]);

        // Handle logo upload
        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('company-logos', 'public');
            $data['company_logo'] = $logoPath;
        }

        CompanySetting::updateSettings($data);

        // Refresh company settings
        $this->companySettings = CompanySetting::getSettings();
        view()->share('companySettings', $this->companySettings);

        return redirect()->route('admin.settings.company')->with('success', 'تنظیمات شرکت با موفقیت به‌روزرسانی شد');
    }

    /**
     * Display backup page.
     */
    public function backup()
    {
        return view('admin.backup');
    }

    /**
     * Display system logs page.
     */
    public function logs()
    {
        return view('admin.logs');
    }

    /**
     * Handle admin logout.
     */
    public function logout(Request $request)
    {
        // Add logout logic here
        return redirect('/');
    }
}
