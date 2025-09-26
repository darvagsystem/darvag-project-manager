<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index()
    {
        $projects = Project::with('client')->orderBy('created_at', 'desc')->get();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        $clients = Client::active()->get();
        return view('admin.projects.create', compact('clients'));
    }

    /**
     * Store a newly created project.
     */
    public function store(Request $request)
    {
        try {
            // Log the incoming request data
            \Log::info('Project creation request data:', $request->all());

            $request->validate([
                'name' => 'required|string|max:255',
                'client_id' => 'required|exists:clients,id',
                'contract_number' => 'required|string|max:255|unique:projects',
                'initial_estimate' => 'required|numeric|min:0',
                'final_amount' => 'required|numeric|min:0',
                'contract_coefficient' => 'required|numeric|min:0',
                'department' => 'required|string|max:255',
                'contract_start_date' => 'required|string',
                'contract_end_date' => 'required|string',
                'actual_start_date' => 'nullable|string',
                'actual_end_date' => 'nullable|string',
                'status' => 'required|in:planning,in_progress,completed,paused,cancelled',
                'priority' => 'nullable|in:low,normal,high,urgent',
                'progress' => 'required|integer|min:0|max:100',
                'project_manager' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'category' => 'nullable|in:construction,industrial,infrastructure,energy,petrochemical,other',
                'currency' => 'nullable|in:IRR,USD,EUR',
                'description' => 'nullable|string',
                'notes' => 'nullable|string'
            ]);

            $data = $request->all();

            // Set default values
            $data['priority'] = $data['priority'] ?: 'normal';
            $data['currency'] = $data['currency'] ?: 'IRR';
            $data['progress'] = $data['progress'] ?: 0;

            \Log::info('Creating project with data:', $data);

            $project = Project::create($data);

            if ($project) {
                \Log::info('Project created successfully with ID: ' . $project->id);
                return redirect()->route('projects.index')->with('success', 'پروژه با موفقیت اضافه شد');
            } else {
                \Log::error('Project creation failed');
                return redirect()->back()->with('error', 'خطا در ثبت اطلاعات')->withInput();
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Project creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'خطا در ثبت اطلاعات: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified project.
     */
    public function show($id)
    {
        $project = Project::with('client')->findOrFail($id);
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $clients = Client::active()->get();
        return view('admin.projects.edit', compact('project', 'clients'));
    }

    /**
     * Update the specified project.
     */
    public function update(Request $request, $id)
    {
        try {
            $project = Project::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'client_id' => 'required|exists:clients,id',
                'contract_number' => 'required|string|max:255|unique:projects,contract_number,' . $project->id,
                'initial_estimate' => 'required|numeric|min:0',
                'final_amount' => 'required|numeric|min:0',
                'contract_coefficient' => 'required|numeric|min:0',
                'department' => 'required|string|max:255',
                'contract_start_date' => 'required|string',
                'contract_end_date' => 'required|string',
                'actual_start_date' => 'nullable|string',
                'actual_end_date' => 'nullable|string',
                'status' => 'required|in:planning,in_progress,completed,paused,cancelled',
                'priority' => 'nullable|in:low,normal,high,urgent',
                'progress' => 'required|integer|min:0|max:100',
                'project_manager' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'category' => 'nullable|in:construction,industrial,infrastructure,energy,petrochemical,other',
                'currency' => 'nullable|in:IRR,USD,EUR',
                'description' => 'nullable|string',
                'notes' => 'nullable|string'
            ]);

            $data = $request->all();

            // Set default values
            $data['priority'] = $data['priority'] ?: 'normal';
            $data['currency'] = $data['currency'] ?: 'IRR';

            $project->update($data);

            return redirect()->route('projects.index')->with('success', 'اطلاعات پروژه با موفقیت به‌روزرسانی شد');

        } catch (\Exception $e) {
            \Log::error('Project update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'خطا در به‌روزرسانی اطلاعات: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified project.
     */
    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();

            return redirect()->route('projects.index')->with('success', 'پروژه با موفقیت حذف شد');

        } catch (\Exception $e) {
            \Log::error('Project deletion error: ' . $e->getMessage());
            return redirect()->route('projects.index')->with('error', 'خطا در حذف پروژه');
        }
    }
}
