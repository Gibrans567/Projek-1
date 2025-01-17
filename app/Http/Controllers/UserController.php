<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
{
    // Validasi input dari user
    $validated = $request->validate([
        'username' => 'required|string|unique:users,username|max:255',
        'password' => 'required|string|min:8|confirmed', // Validasi password dan konfirmasinya
        'shift' => 'required|string|max:255',
        'nomor_hp' => 'required|string|max:15',
    ]);

    // Menambahkan user baru ke dalam database
    $user = new Akun();
    $user->username = $validated['username'];
    $user->password = Hash::make($validated['password']); // Mengenkripsi password
    $user->shift = $validated['shift'];
    $user->nomor_hp = $validated['nomor_hp'];
    $user->save();

    // Kembalikan response sukses
    return response()->json([
        'message' => 'Akun baru berhasil ditambahkan!',
        'user' => $user
    ], 201); // HTTP status code 201 = Created
    }

    public function index()
    {
        $users = Akun::all(); // Mengambil semua data pengguna
        return response()->json($users);
    }

    public function show($id)
    {
        $user = Akun::find($id); // Mencari user berdasarkan ID

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404); // HTTP 404 Not Found jika user tidak ada
        }

        return response()->json($user); // Mengembalikan data user dalam format JSON
    }

    public function update(Request $request, $id)
    {
        // Validasi input yang diterima
        $validated = $request->validate([
            'username' => 'required|string|unique:users,username,' . $id . '|max:255', // Mengabaikan validasi unik untuk user yang sedang diedit
            'password' => 'nullable|string|min:8|confirmed', // Password bisa diubah, jika ada perubahan
            'shift' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:15',
        ]);

        $user = Akun::find($id); // Mencari user berdasarkan ID

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404); // HTTP 404 Not Found jika user tidak ada
        }

        // Update data user
        $user->username = $validated['username'];
        $user->shift = $validated['shift'];
        $user->nomor_hp = $validated['nomor_hp'];

        // Jika password diubah
        if ($request->has('password')) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save(); // Simpan perubahan

        return response()->json([
            'message' => 'User updated successfully!',
            'user' => $user
        ]);
    }

    public function destroy($id)
    {
        $user = Akun::find($id); // Mencari user berdasarkan ID

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404); // HTTP 404 Not Found jika user tidak ada
        }

        $user->delete(); // Hapus data user

        return response()->json([
            'message' => 'User deleted successfully!'
        ]);
    }

}
