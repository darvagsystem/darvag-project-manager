<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by subject
        if ($request->has('subject') && $request->subject !== '') {
            $query->where('subject', $request->subject);
        }

        // Search
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $messages = $query->paginate(15);

        // Statistics
        $stats = [
            'total' => ContactMessage::count(),
            'new' => ContactMessage::new()->count(),
            'read' => ContactMessage::read()->count(),
            'replied' => ContactMessage::replied()->count(),
            'closed' => ContactMessage::closed()->count(),
        ];

        return view('admin.contact-messages.index', compact('messages', 'stats'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactMessage $contactMessage)
    {
        // Mark as read if not already
        if (!$contactMessage->is_read) {
            $contactMessage->markAsRead();
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactMessage $contactMessage)
    {
        $request->validate([
            'status' => 'required|in:new,read,replied,closed',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $contactMessage->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        // Update timestamps based on status
        if ($request->status === 'replied' && !$contactMessage->is_replied) {
            $contactMessage->markAsReplied();
        }

        return redirect()->back()->with('success', 'پیام با موفقیت به‌روزرسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        
        return redirect()->route('admin.contact-messages.index')
                        ->with('success', 'پیام با موفقیت حذف شد');
    }

    /**
     * Mark message as read
     */
    public function markAsRead(ContactMessage $contactMessage)
    {
        $contactMessage->markAsRead();
        
        return response()->json(['success' => true]);
    }

    /**
     * Mark message as replied
     */
    public function markAsReplied(ContactMessage $contactMessage)
    {
        $contactMessage->markAsReplied();
        
        return response()->json(['success' => true]);
    }

    /**
     * Mark message as closed
     */
    public function markAsClosed(ContactMessage $contactMessage)
    {
        $contactMessage->markAsClosed();
        
        return response()->json(['success' => true]);
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:mark_read,mark_replied,mark_closed,delete',
            'message_ids' => 'required|array',
            'message_ids.*' => 'exists:contact_messages,id'
        ]);

        $messageIds = $request->message_ids;

        switch ($request->action) {
            case 'mark_read':
                ContactMessage::whereIn('id', $messageIds)->update([
                    'status' => 'read',
                    'read_at' => now()
                ]);
                break;
            case 'mark_replied':
                ContactMessage::whereIn('id', $messageIds)->update([
                    'status' => 'replied',
                    'replied_at' => now()
                ]);
                break;
            case 'mark_closed':
                ContactMessage::whereIn('id', $messageIds)->update(['status' => 'closed']);
                break;
            case 'delete':
                ContactMessage::whereIn('id', $messageIds)->delete();
                break;
        }

        return redirect()->back()->with('success', 'عملیات با موفقیت انجام شد');
    }
}
