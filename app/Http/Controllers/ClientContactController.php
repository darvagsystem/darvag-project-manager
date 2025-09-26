<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\ClientContact;

class ClientContactController extends Controller
{
    /**
     * Display a listing of contacts for a specific client.
     */
    public function index($clientId)
    {
        $client = Client::findOrFail($clientId);
        $contacts = ClientContact::where('client_id', $clientId)->get();

        return view('admin.clients.contacts.index', compact('client', 'contacts'));
    }

    /**
     * Show the form for creating a new contact.
     */
    public function create($clientId)
    {
        $client = Client::findOrFail($clientId);
        return view('admin.clients.contacts.create', compact('client'));
    }

    /**
     * Store a newly created contact.
     */
    public function store(Request $request, $clientId)
    {
        $request->validate([
            'contact_person' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'extension' => 'nullable|string|max:10',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'preferred_contact' => 'nullable|in:phone,mobile,email',
            'availability' => 'nullable|string|max:255',
            'priority' => 'nullable|in:normal,high,urgent',
            'status' => 'nullable|in:active,inactive'
        ]);

        $contact = new ClientContact($request->all());
        $contact->client_id = $clientId;
        $contact->save();

        return redirect()->route('clients.contacts', $clientId)->with('success', 'مخاطب با موفقیت اضافه شد');
    }

    /**
     * Show the form for editing the specified contact.
     */
    public function edit($clientId, $contactId)
    {
        $client = Client::findOrFail($clientId);
        $contact = ClientContact::where('client_id', $clientId)->findOrFail($contactId);

        return view('admin.clients.contacts.edit', compact('client', 'contact'));
    }

    /**
     * Update the specified contact.
     */
    public function update(Request $request, $clientId, $contactId)
    {
        $contact = ClientContact::where('client_id', $clientId)->findOrFail($contactId);

        $request->validate([
            'contact_person' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'extension' => 'nullable|string|max:10',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'preferred_contact' => 'nullable|in:phone,mobile,email',
            'availability' => 'nullable|string|max:255',
            'priority' => 'nullable|in:normal,high,urgent',
            'status' => 'nullable|in:active,inactive'
        ]);

        $contact->update($request->all());

        return redirect()->route('clients.contacts', $clientId)->with('success', 'اطلاعات مخاطب با موفقیت به‌روزرسانی شد');
    }

    /**
     * Remove the specified contact.
     */
    public function destroy($clientId, $contactId)
    {
        $contact = ClientContact::where('client_id', $clientId)->findOrFail($contactId);
        $contact->delete();

        return redirect()->route('clients.contacts', $clientId)->with('success', 'مخاطب با موفقیت حذف شد');
    }
}
