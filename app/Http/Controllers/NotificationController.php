<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Menampilkan notifikasi untuk user tertentu
    public function index($userId)
    {
        $notifications = Notification::where('user_id', $userId)->get();
        return response()->json($notifications);
    }

    // Tandai notifikasi sebagai telah dibaca
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);
        return response()->json(['message' => 'Notification marked as read.']);
    }

    // Menambah notifikasi baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'required|exists:users,id', // pastikan user_id valid
        ]);

        // Membuat notifikasi baru
        Notification::create($request->all());

        return response()->json(['message' => 'Notification created successfully.']);
    }

    // Fungsi tambahan untuk menambah notifikasi secara langsung
    public function addNotification($userId, $title, $message)
    {
        // Validasi parameter
        if (empty($userId) || empty($title) || empty($message)) {
            return response()->json(['error' => 'Invalid data. All fields are required.'], 400);
        }

        // Membuat notifikasi baru
        Notification::create([
            'title' => $title,
            'message' => $message,
            'user_id' => $userId,
        ]);

        return response()->json(['message' => 'Notification created successfully.']);
    }
}
