<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;

class BankController extends Controller
{
    /**
     * Display banks management page.
     */
    public function index()
    {
        $banks = Bank::orderBy('name')->get();
        return view('admin.settings.banks.index', compact('banks'));
    }

    /**
     * Show the form for creating a new bank.
     */
    public function create()
    {
        return view('admin.settings.banks.create');
    }

    /**
     * Store a newly created bank.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['name']);
        $data['is_active'] = $request->has('is_active');

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('bank-logos', 'public');
            $data['logo'] = $logoPath;
        }

        Bank::create($data);

        return redirect()->route('panel.settings.banks')->with('success', 'بانک با موفقیت اضافه شد');
    }

    /**
     * Show the form for editing the specified bank.
     */
    public function edit($id)
    {
        $bank = Bank::findOrFail($id);
        return view('admin.settings.banks.edit', compact('bank'));
    }

    /**
     * Update the specified bank.
     */
    public function update(Request $request, $id)
    {
        $bank = Bank::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['name']);
        $data['is_active'] = $request->has('is_active');

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('bank-logos', 'public');
            $data['logo'] = $logoPath;
        }

        $bank->update($data);

        return redirect()->route('panel.settings.banks')->with('success', 'بانک با موفقیت به‌روزرسانی شد');
    }

    /**
     * Remove the specified bank.
     */
    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);

        // Check if bank has any associated accounts
        if ($bank->employeeBankAccounts()->count() > 0) {
            return redirect()->route('panel.settings.banks')
                           ->with('error', 'این بانک دارای حساب‌های مرتبط است و قابل حذف نیست');
        }

        $bank->delete();

        return redirect()->route('panel.settings.banks')->with('success', 'بانک با موفقیت حذف شد');
    }

    /**
     * Seed default banks
     */
    public function seed()
    {
        // Check if banks already exist
        if (Bank::count() > 0) {
            return redirect()->route('panel.settings.banks')
                           ->with('error', 'بانک‌ها قبلاً تعریف شده‌اند');
        }

        $banks = [
            ['name' => 'بانک ملی ایران', 'is_active' => true],
            ['name' => 'بانک سپه', 'is_active' => true],
            ['name' => 'بانک کشاورزی', 'is_active' => true],
            ['name' => 'بانک صنعت و معدن', 'is_active' => true],
            ['name' => 'بانک تجارت', 'is_active' => true],
            ['name' => 'بانک صادرات ایران', 'is_active' => true],
            ['name' => 'بانک ملت', 'is_active' => true],
            ['name' => 'بانک پارسیان', 'is_active' => true],
            ['name' => 'بانک پاسارگاد', 'is_active' => true],
            ['name' => 'بانک سامان', 'is_active' => true],
            ['name' => 'بانک اقتصاد نوین', 'is_active' => true],
            ['name' => 'بانک دی', 'is_active' => true],
            ['name' => 'بانک سینا', 'is_active' => true],
            ['name' => 'بانک شهر', 'is_active' => true],
            ['name' => 'بانک گردشگری', 'is_active' => true],
            ['name' => 'بانک قرض‌الحسنه مهر ایران', 'is_active' => true],
            ['name' => 'بانک انصار', 'is_active' => true],
            ['name' => 'بانک آینده', 'is_active' => true],
            ['name' => 'بانک کارآفرین', 'is_active' => true],
            ['name' => 'بانک ایران زمین', 'is_active' => true],
            ['name' => 'بانک خاورمیانه', 'is_active' => true],
            ['name' => 'بانک کوثر', 'is_active' => true],
            ['name' => 'بانک مهر اقتصاد', 'is_active' => true],
            ['name' => 'بانک پست بانک ایران', 'is_active' => true],
            ['name' => 'بانک توسعه تعاون', 'is_active' => true],
            ['name' => 'بانک قوامین', 'is_active' => true],
            ['name' => 'بانک حکمت ایرانیان', 'is_active' => true],
            ['name' => 'بانک آریا', 'is_active' => true],
            ['name' => 'بانک کیش', 'is_active' => true],
            ['name' => 'بانک تات', 'is_active' => true],
        ];

        foreach ($banks as $bank) {
            Bank::create($bank);
        }

        return redirect()->route('panel.settings.banks')
                       ->with('success', '30 بانک پیش‌فرض با موفقیت اضافه شدند');
    }
}
