<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeBankAccount;
use App\Models\EmployeeDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EmployeeController extends Controller
{
    /**
     * Test method to verify controller is working
     */
    public function test()
    {
        try {
            // Test database connection
            DB::connection()->getPdo();

            // Test employees table
            $count = Employee::count();

            // Test creating a simple employee
            $testEmployee = Employee::create([
                'employee_code' => 'DVG1234567890',
                'first_name' => 'تست',
                'last_name' => 'کارمند',
                'national_code' => '1234567890',
                'status' => 'active',
                'marital_status' => 'single',
                'education' => 'diploma',
                'avatar' => 'default-avatar.png'
            ]);

            return response()->json([
                'message' => 'Employee controller is working',
                'database_connected' => true,
                'employees_count' => $count,
                'test_employee_created' => $testEmployee ? true : false,
                'test_employee_id' => $testEmployee ? $testEmployee->id : null,
                'table_structure' => Schema::getColumnListing('employees')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage(),
                'database_connected' => false,
                'stack_trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Test form submission
     */
    public function testForm()
    {
        return view('admin.employees.test-form');
    }

    /**
     * Test method to handle form submission without validation
     */
    public function testStore(Request $request)
    {
        try {
            \Log::info('Test store method called', $request->all());

            $data = $request->except(['avatar', 'employee_code']);
            $data['employee_code'] = 'DVG' . $request->national_code;
            $data['marital_status'] = $data['marital_status'] ?: 'single';
            $data['education'] = $data['education'] ?: 'diploma';
            $data['status'] = $data['status'] ?: 'active';
            $data['avatar'] = 'default-avatar.png';

            \Log::info('Creating employee with data:', $data);

            $employee = Employee::create($data);

            if ($employee) {
                \Log::info('Employee created successfully with ID: ' . $employee->id);
                return redirect()->route('employees.index')->with('success', 'کارمند تست با موفقیت اضافه شد');
            } else {
                \Log::error('Employee creation failed');
                return redirect()->back()->with('error', 'خطا در ثبت اطلاعات')->withInput();
            }

        } catch (\Exception $e) {
            \Log::error('Test store error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'خطا در ثبت اطلاعات: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display a listing of employees.
     */
    public function index()
    {
        $employees = Employee::orderBy('employee_code')->get();
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        try {
            \Log::info('Employee creation started', $request->all());

            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'national_code' => 'required|string|size:10|unique:employees',
                'birth_date' => 'nullable|string',
                'marital_status' => 'nullable|in:single,married,divorced,widowed',
                'education' => 'nullable|in:illiterate,elementary,middle_school,high_school,diploma,associate,bachelor,master,phd',
                'status' => 'nullable|in:active,vacation,inactive,terminated',
                'phone' => 'nullable|string|max:20',
                'mobile' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255|unique:employees',
                'address' => 'nullable|string',
                'emergency_contact' => 'nullable|string|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'notes' => 'nullable|string'
            ]);

            $data = $request->except(['avatar', 'employee_code']);

            // Generate employee code from national code
            $employeeCode = Employee::generateEmployeeCode($request->national_code);
            \Log::info('Generated employee code: ' . $employeeCode);

            // Check if employee code already exists
            if (Employee::employeeCodeExists($employeeCode)) {
                \Log::warning('Employee code already exists: ' . $employeeCode);
                return redirect()->back()
                               ->with('error', 'کد پرسنلی با این کد ملی قبلاً وجود دارد')
                               ->withInput();
            }

            $data['employee_code'] = $employeeCode;

            // Handle null/empty values by setting defaults
            $data['marital_status'] = $data['marital_status'] ?: 'single';
            $data['education'] = $data['education'] ?: 'diploma';
            $data['status'] = $data['status'] ?: 'active';

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $data['avatar'] = $avatarPath;
                \Log::info('Avatar uploaded: ' . $avatarPath);
            } else {
                $data['avatar'] = 'default-avatar.png';
            }

            \Log::info('Creating employee with data:', $data);

            $employee = Employee::create($data);

            if ($employee) {
                \Log::info('Employee created successfully with ID: ' . $employee->id);
                return redirect()->route('employees.index')->with('success', 'کارمند با موفقیت اضافه شد');
            } else {
                \Log::error('Employee creation failed');
                return redirect()->back()->with('error', 'خطا در ثبت اطلاعات')->withInput();
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Employee creation error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'خطا در ثبت اطلاعات: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified employee.
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('admin.employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'national_code' => 'required|string|size:10|unique:employees,national_code,' . $employee->id,
            'birth_date' => 'nullable|string',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'education' => 'nullable|in:illiterate,elementary,middle_school,high_school,diploma,associate,bachelor,master,phd',
            'status' => 'nullable|in:active,vacation,inactive,terminated',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:employees,email,' . $employee->id,
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string'
        ]);

        $data = $request->except(['avatar', 'employee_code']);

        // If national code changed, generate new employee code
        if ($request->national_code !== $employee->national_code) {
            $newEmployeeCode = Employee::generateEmployeeCode($request->national_code);

            // Check if new employee code already exists
            if (Employee::where('employee_code', $newEmployeeCode)->where('id', '!=', $employee->id)->exists()) {
                return redirect()->back()
                               ->with('error', 'کد پرسنلی با این کد ملی قبلاً وجود دارد')
                               ->withInput();
            }

            $data['employee_code'] = $newEmployeeCode;
        }

        // Handle null/empty values by setting defaults
        $data['marital_status'] = $data['marital_status'] ?: 'single';
        $data['education'] = $data['education'] ?: 'diploma';
        $data['status'] = $data['status'] ?: 'active';

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        $employee->update($data);

        return redirect()->route('employees.index')->with('success', 'اطلاعات کارمند با موفقیت به‌روزرسانی شد');
    }

    /**
     * Remove the specified employee.
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        // Check if employee has any related data
        if ($employee->bankAccounts()->count() > 0 || $employee->documents()->count() > 0) {
            return redirect()->route('employees.index')
                           ->with('error', 'این کارمند دارای اطلاعات مرتبط است و قابل حذف نیست');
        }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'کارمند با موفقیت حذف شد');
    }


    /**
     * Display employee documents.
     */
    public function documents($id)
    {
        $employee = Employee::findOrFail($id);
        $documents = $employee->documents()->get();
        $documentTypes = EmployeeDocument::getDocumentTypes();

        return view('admin.employees.documents', compact('employee', 'documents', 'documentTypes'));
    }
}
