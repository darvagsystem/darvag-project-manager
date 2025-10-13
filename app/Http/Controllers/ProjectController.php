<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;
use App\Services\ActivityLoggerService;

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
        $clients = Client::all();
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
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'cropped_image' => 'nullable|string',
                'featured_image_alt' => 'nullable|string|max:255',
                'notes' => 'nullable|string'
            ]);

            $data = $request->all();

            // Use raw values for money fields
            $data['initial_estimate'] = $request->initial_estimate_raw;
            $data['final_amount'] = $request->final_amount_raw;

            // Handle featured image upload (cropped or original)
            if ($request->filled('cropped_image')) {
                // Handle cropped image (base64)
                $croppedImage = $request->input('cropped_image');
                $imageName = time() . '_' . uniqid() . '.jpg';

                // Decode base64 image
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $croppedImage));

                // Save cropped image
                file_put_contents(storage_path('app/public/projects/featured/' . $imageName), $imageData);
                $data['featured_image'] = 'projects/featured/' . $imageName;
            } elseif ($request->hasFile('featured_image')) {
                // Handle original file upload
                $image = $request->file('featured_image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/projects/featured', $imageName);
                $data['featured_image'] = 'projects/featured/' . $imageName;
            }

            // Set default values
            $data['priority'] = $data['priority'] ?: 'normal';
            $data['currency'] = $data['currency'] ?: 'IRR';
            $data['progress'] = $data['progress'] ?: 0;

            \Log::info('Creating project with data:', $data);

            $project = Project::create($data);

            if ($project) {
                \Log::info('Project created successfully with ID: ' . $project->id);

                // Log activity
                ActivityLoggerService::logCreated($project, [
                    'client_id' => $project->client_id,
                    'contract_number' => $project->contract_number,
                    'initial_estimate' => $project->initial_estimate,
                    'final_amount' => $project->final_amount,
                    'status' => $project->status,
                    'priority' => $project->priority
                ]);

                return redirect()->route('panel.projects.index')->with('success', 'پروژه با موفقیت اضافه شد');
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
    public function show(Project $project)
    {
        $project = Project::with('client')->findOrFail($project->id);
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {

        $project = Project::findOrFail($project->id);
        $clients = Client::all();
        return view('admin.projects.edit', compact('project', 'clients'));
    }

    /**
     * Update the specified project.
     */
    public function update(Request $request, Project $project)
    {
        try {
            // Log the incoming request data
            \Log::info('Project update request data:', $request->all());

            $request->validate([
                'name' => 'required|string|max:255',
                'client_id' => 'required|exists:clients,id',
                'contract_number' => 'required|string|max:255|unique:projects,contract_number,' . $project->id,
                'initial_estimate_raw' => 'required|numeric|min:0',
                'final_amount_raw' => 'required|numeric|min:0',
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
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'cropped_image' => 'nullable|string',
                'featured_image_alt' => 'nullable|string|max:255',
                'notes' => 'nullable|string'
            ]);

            $data = $request->all();

            // Use raw values for money fields
            $data['initial_estimate'] = $request->initial_estimate_raw;
            $data['final_amount'] = $request->final_amount_raw;

            // Handle featured image upload (cropped or original)
            if ($request->filled('cropped_image')) {
                // Handle cropped image (base64)
                $croppedImage = $request->input('cropped_image');
                $imageName = time() . '_' . uniqid() . '.jpg';

                // Decode base64 image
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $croppedImage));

                // Save cropped image
                file_put_contents(storage_path('app/public/projects/featured/' . $imageName), $imageData);
                $data['featured_image'] = 'projects/featured/' . $imageName;
            } elseif ($request->hasFile('featured_image')) {
                // Handle original file upload
                $image = $request->file('featured_image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/projects/featured', $imageName);
                $data['featured_image'] = 'projects/featured/' . $imageName;
            }

            // Set default values
            $data['priority'] = $data['priority'] ?: 'normal';
            $data['currency'] = $data['currency'] ?: 'IRR';
            $data['progress'] = $data['progress'] ?: 0;

            \Log::info('Updating project with data:', $data);

            $project->update($data);

            // Log activity
            ActivityLoggerService::logUpdated($project, [
                'client_id' => $project->client_id,
                'contract_number' => $project->contract_number,
                'initial_estimate' => $project->initial_estimate,
                'final_amount' => $project->final_amount,
                'status' => $project->status,
                'priority' => $project->priority
            ]);

            return redirect()->route('panel.projects.index')->with('success', 'پروژه با موفقیت به‌روزرسانی شد');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Project update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'خطا در به‌روزرسانی پروژه: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified project.
     */
    public function destroy(Project $project)
    {
        try {
            $project = Project::findOrFail($project->id);

            // Log activity before deletion
            ActivityLoggerService::logDeleted($project, [
                'client_id' => $project->client_id,
                'contract_number' => $project->contract_number,
                'name' => $project->name
            ]);

            $project->delete();

            return redirect()->route('panel.projects.index')->with('success', 'پروژه با موفقیت حذف شد');

        } catch (\Exception $e) {
            \Log::error('Project deletion error: ' . $e->getMessage());
            return redirect()->route('panel.projects.index')->with('error', 'خطا در حذف پروژه');
        }
    }

    /**
     * Copy project structure from one project to another
     */
    public function copyStructure(Request $request)
    {
        try {
            $request->validate([
                'source_project_id' => 'required|integer|exists:projects,id',
                'target_project_id' => 'required|integer|exists:projects,id'
            ]);

            $sourceProject = Project::findOrFail($request->source_project_id);
            $targetProject = Project::findOrFail($request->target_project_id);

            // Prevent copying from the same project to itself
            if ($sourceProject->id === $targetProject->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'نمی‌توانید ساختار پروژه را به خودش کپی کنید.'
                ], 400);
            }

            // Get only root folders from source project (no files)
            $sourceItems = \App\Models\FileManager::where('project_id', $sourceProject->id)
                ->whereNull('parent_id')
                ->where('is_folder', true)
                ->get();

            $copiedCount = 0;

            foreach ($sourceItems as $item) {
                // Copy the structure recursively
                $item->copyStructure($targetProject->id);
                $copiedCount++;
            }

            // Log the activity
            ActivityLoggerService::logCreated($targetProject, [
                'action' => 'structure_copied',
                'source_project' => $sourceProject->name,
                'copied_items' => $copiedCount
            ]);

            return response()->json([
                'success' => true,
                'message' => "ساختار پوشه‌بندی با موفقیت کپی شد! ({$copiedCount} پوشه کپی شد)",
                'copied_count' => $copiedCount
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Project structure copy validation error: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعتبارسنجی: ' . implode(', ', array_flatten($e->errors()))
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Project structure copy error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'خطا در کپی کردن ساختار: ' . $e->getMessage()
            ], 500);
        }
    }
}
