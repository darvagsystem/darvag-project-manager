<?php

namespace App\Http\Controllers;

use App\Models\ProjectTemplate;
use App\Models\FileManager;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectTemplateController extends Controller
{
    /**
     * Display templates list
     */
    public function index()
    {
        $templates = ProjectTemplate::with(['creator'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.project-templates.index', compact('templates'));
    }

    /**
     * Show create template form
     */
    public function create()
    {
        return view('admin.project-templates.create');
    }

    /**
     * Store new template
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:project_templates,name',
            'description' => 'nullable|string',
            'folder_structure' => 'required|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $template = ProjectTemplate::create([
                'name' => $request->name,
                'description' => $request->description,
                'folder_structure' => $request->folder_structure,
                'created_by' => auth()->id(),
                'is_active' => true
            ]);

            // Create template folder structure
            $this->createTemplateStructure($template, $request->folder_structure);

            return redirect()->route('admin.project-templates.index')
                ->with('success', 'قالب پروژه با موفقیت ایجاد شد');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'خطا در ایجاد قالب: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show template details
     */
    public function show($id)
    {
        $template = ProjectTemplate::with(['creator', 'rootFolders.children'])
            ->findOrFail($id);

        return view('admin.project-templates.show', compact('template'));
    }

    /**
     * Show edit template form
     */
    public function edit($id)
    {
        $template = ProjectTemplate::findOrFail($id);
        return view('admin.project-templates.edit', compact('template'));
    }

    /**
     * Update template
     */
    public function update(Request $request, $id)
    {
        $template = ProjectTemplate::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:project_templates,name,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $template->update([
                'name' => $request->name,
                'description' => $request->description,
                'is_active' => $request->has('is_active')
            ]);

            return redirect()->route('admin.project-templates.index')
                ->with('success', 'قالب پروژه با موفقیت به‌روزرسانی شد');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'خطا در به‌روزرسانی قالب: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete template
     */
    public function destroy($id)
    {
        try {
            $template = ProjectTemplate::findOrFail($id);

            // Delete template folder structure
            FileManager::where('project_id', null)
                ->where('is_template', true)
                ->delete();

            $template->delete();

            return redirect()->route('admin.project-templates.index')
                ->with('success', 'قالب پروژه با موفقیت حذف شد');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'خطا در حذف قالب: ' . $e->getMessage());
        }
    }

    /**
     * Apply template to project
     */
    public function applyToProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template_id' => 'required|exists:project_templates,id',
            'project_id' => 'required|exists:projects,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعتبارسنجی داده‌ها',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $template = ProjectTemplate::findOrFail($request->template_id);
            $project = Project::findOrFail($request->project_id);

            // Apply template structure to project
            $template->applyToProject($project->id);

            return response()->json([
                'success' => true,
                'message' => 'ساختار قالب با موفقیت به پروژه اعمال شد'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعمال قالب: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get templates for project creation
     */
    public function getTemplatesForProject()
    {
        $templates = ProjectTemplate::where('is_active', true)
            ->select('id', 'name', 'description')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'templates' => $templates
        ]);
    }

    /**
     * Create template folder structure
     */
    private function createTemplateStructure($template, $structure, $parentId = null)
    {
        foreach ($structure as $item) {
            $folder = FileManager::create([
                'name' => $item['name'],
                'type' => 'folder',
                'is_folder' => true,
                'is_template' => true,
                'parent_id' => $parentId,
                'project_id' => null, // Templates don't belong to specific projects
                'description' => $item['description'] ?? null,
                'folder_color' => $item['color'] ?? null,
                'uploaded_by' => auth()->id()
            ]);

            // Create subfolders recursively
            if (isset($item['children']) && is_array($item['children'])) {
                $this->createTemplateStructure($template, $item['children'], $folder->id);
            }
        }
    }

    /**
     * Create template from existing project
     */
    public function createFromProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'source_project_id' => 'required|exists:projects,id',
            'target_project_id' => 'required|exists:projects,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعتبارسنجی داده‌ها',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $sourceProject = Project::findOrFail($request->source_project_id);
            $targetProject = Project::findOrFail($request->target_project_id);

            // Get folder structure from source project
            $sourceFolders = FileManager::where('project_id', $sourceProject->id)
                ->where('is_folder', true)
                ->whereNull('parent_id')
                ->get();

            // Copy folder structure to target project
            foreach ($sourceFolders as $sourceFolder) {
                $this->copyFolderStructure($sourceFolder, null, $targetProject->id);
            }

            return response()->json([
                'success' => true,
                'message' => 'ساختار پوشه‌بندی با موفقیت کپی شد'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در کپی کردن ساختار: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Copy folder structure recursively
     */
    private function copyFolderStructure($sourceFolder, $parentId, $targetProjectId)
    {
        // Create folder in target project
        $newFolder = FileManager::create([
            'name' => $sourceFolder->name,
            'type' => 'folder',
            'is_folder' => true,
            'is_template' => false,
            'parent_id' => $parentId,
            'project_id' => $targetProjectId,
            'description' => $sourceFolder->description,
            'folder_color' => $sourceFolder->folder_color,
            'uploaded_by' => auth()->id()
        ]);

        // Copy subfolders
        $subfolders = FileManager::where('parent_id', $sourceFolder->id)
            ->where('is_folder', true)
            ->get();

        foreach ($subfolders as $subfolder) {
            $this->copyFolderStructure($subfolder, $newFolder->id, $targetProjectId);
        }
    }

    /**
     * Create template from existing project (old method)
     */
    public function createFromProjectOld(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'template_name' => 'required|string|max:255|unique:project_templates,name',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعتبارسنجی داده‌ها',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $project = Project::findOrFail($request->project_id);

            // Create template
            $template = ProjectTemplate::create([
                'name' => $request->template_name,
                'description' => $request->description,
                'created_by' => auth()->id(),
                'is_active' => true
            ]);

            // Copy project folder structure to template
            $rootFolders = FileManager::where('project_id', $project->id)
                ->whereNull('parent_id')
                ->where('is_folder', true)
                ->get();

            foreach ($rootFolders as $rootFolder) {
                $this->copyProjectStructureToTemplate($rootFolder, null);
            }

            return response()->json([
                'success' => true,
                'message' => 'قالب از پروژه با موفقیت ایجاد شد',
                'template' => $template
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در ایجاد قالب: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Copy project structure to template
     */
    private function copyProjectStructureToTemplate($folder, $newParentId)
    {
        // Create template folder
        $templateFolder = FileManager::create([
            'name' => $folder->name,
            'type' => 'folder',
            'is_folder' => true,
            'is_template' => true,
            'parent_id' => $newParentId,
            'project_id' => null,
            'description' => $folder->description,
            'folder_color' => $folder->folder_color,
            'uploaded_by' => auth()->id()
        ]);

        // Copy children recursively (only folders for templates)
        foreach ($folder->folders as $childFolder) {
            $this->copyProjectStructureToTemplate($childFolder, $templateFolder->id);
        }

        return $templateFolder;
    }
}
