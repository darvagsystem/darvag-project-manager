<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\SajarService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'national_id' => 'required|string|unique:companies,national_id|max:20',
            'registration_number' => 'nullable|string|max:50',
            'economic_code' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        Company::create($request->all());

        return redirect()->route('panel.companies.index')
            ->with('success', 'شرکت با موفقیت اضافه شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        // Load certificates and their fields for this specific company
        $company->load(['certificates.fields', 'contracts']);

        return view('admin.companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'national_id' => 'required|string|unique:companies,national_id,' . $company->id . '|max:20',
            'registration_number' => 'nullable|string|max:50',
            'economic_code' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $company->update($request->all());

        return redirect()->route('panel.companies.index')
            ->with('success', 'اطلاعات شرکت با موفقیت به‌روزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('panel.companies.index')
            ->with('success', 'شرکت با موفقیت حذف شد.');
    }

    /**
     * همگام‌سازی اطلاعات شرکت از ساجر
     */
    public function syncFromSajar(Company $company)
    {
        $sajarService = new SajarService();

        if ($sajarService->syncCompanyFromSajar($company)) {
            return redirect()->route('panel.companies.show', $company)
                ->with('success', 'اطلاعات شرکت با موفقیت از ساجر همگام‌سازی شد.');
        } else {
            return redirect()->route('panel.companies.show', $company)
                ->with('error', 'خطا در همگام‌سازی اطلاعات از ساجر. لطفاً دوباره تلاش کنید.');
        }
    }

    /**
     * همگام‌سازی همه شرکت‌ها
     */
    public function syncAllFromSajar()
    {
        $sajarService = new SajarService();
        $results = $sajarService->syncAllCompanies();

        $message = "همگام‌سازی کامل شد. ";
        $message .= "کل شرکت‌ها: {$results['total']}، ";
        $message .= "موفق: {$results['success']}، ";
        $message .= "ناموفق: {$results['failed']}";

        return redirect()->route('panel.companies.index')
            ->with('success', $message);
    }

    /**
     * جستجوی شرکت در ساجر برای انتخاب
     */
    public function searchSajar(Request $request)
    {
        $query = $request->get('q', '');

        if (empty($query)) {
            return response()->json([]);
        }

        try {
            $sajarService = new SajarService();
            $companies = $sajarService->searchCompaniesForSelection($query);

            return response()->json($companies);
        } catch (Exception $e) {
            // در صورت خطا، یک نمونه برگردانیم
            return response()->json([
                [
                    'LatestCompanyName' => $query . ' (تست)',
                    'NationalCode' => '12345678901',
                    'TaxNumber' => '1234567890',
                    'CompanyID' => 999
                ]
            ]);
        }
    }

    /**
     * ایجاد شرکت از اطلاعات ساجر
     */
    public function createFromSajar(Request $request)
    {
        $sajarData = $request->get('sajar_data');

        if (!$sajarData) {
            return redirect()->route('panel.companies.create')
                ->with('error', 'اطلاعات ساجر یافت نشد.');
        }

        // ایجاد شرکت جدید
        $company = Company::create([
            'name' => $sajarData['LatestCompanyName'] ?? '',
            'national_id' => $sajarData['NationalCode'] ?? '',
            'economic_code' => $sajarData['TaxNumber'] ?? '',
            'status' => 'active'
        ]);

        // همگام‌سازی کامل اطلاعات
        $sajarService = new SajarService();
        $sajarService->syncCompanyFromSajar($company);

        return redirect()->route('panel.companies.show', $company)
            ->with('success', 'شرکت با موفقیت از ساجر ایجاد شد.');
    }
}
