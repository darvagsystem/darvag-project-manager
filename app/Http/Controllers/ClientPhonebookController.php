<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\ClientPhonebook;

class ClientPhonebookController extends Controller
{
    /**
     * Display a listing of phonebook entries for a specific client.
     */
    public function index(Client $client)
    {
        $search = request('search');
        $region = request('region');
        $department = request('department');

        $query = $client->phonebook()->active();

        if ($search) {
            $query->search($search);
        }

        if ($region) {
            $query->where('region', $region);
        }

        if ($department) {
            $query->where('department', $department);
        }

        $phonebook = $query->orderBy('person_name')->paginate(20);

        // Get unique regions and departments for filters
        $regions = $client->phonebook()->active()->distinct()->pluck('region')->filter()->sort()->values();
        $departments = $client->phonebook()->active()->distinct()->pluck('department')->filter()->sort()->values();

        return view('admin.clients.phonebook.index', compact('client', 'phonebook', 'regions', 'departments', 'search', 'region', 'department'));
    }

    /**
     * Show the form for creating a new phonebook entry.
     */
    public function create(Client $client)
    {
        return view('admin.clients.phonebook.create', compact('client'));
    }

    /**
     * Store a newly created phonebook entry.
     */
    public function store(Request $request, Client $client)
    {
        $request->validate([
            'region' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'person_name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $client->phonebook()->create($request->all());

        return redirect()->route('panel.clients.phonebook.index', $client->id)
                        ->with('success', 'مخاطب با موفقیت اضافه شد');
    }

    /**
     * Show the form for editing the specified phonebook entry.
     */
    public function edit(Client $client, ClientPhonebook $phonebook)
    {
        return view('admin.clients.phonebook.edit', compact('client', 'phonebook'));
    }

    /**
     * Update the specified phonebook entry.
     */
    public function update(Request $request, Client $client, ClientPhonebook $phonebook)
    {
        $request->validate([
            'region' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'person_name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $phonebook->update($request->all());

        return redirect()->route('panel.clients.phonebook.index', $client->id)
                        ->with('success', 'اطلاعات مخاطب با موفقیت به‌روزرسانی شد');
    }

    /**
     * Remove the specified phonebook entry.
     */
    public function destroy(Client $client, ClientPhonebook $phonebook)
    {
        $phonebook->delete();

        return redirect()->route('panel.clients.phonebook.index', $client->id)
                        ->with('success', 'مخاطب با موفقیت حذف شد');
    }

    /**
     * Toggle the active status of a phonebook entry.
     */
    public function toggleStatus(Client $client, ClientPhonebook $phonebook)
    {
        $phonebook->update(['is_active' => !$phonebook->is_active]);

        $status = $phonebook->is_active ? 'فعال' : 'غیرفعال';

        return redirect()->route('panel.clients.phonebook.index', $client->id)
                        ->with('success', "مخاطب {$status} شد");
    }
}
