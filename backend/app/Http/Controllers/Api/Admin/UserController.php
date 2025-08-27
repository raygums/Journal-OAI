<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Fungsi private untuk otorisasi. Memastikan hanya pengguna dengan peran 'admin'
     * yang bisa menjalankan method di dalam controller ini.
     */
    private function authorizeAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized. Only admins can perform this action.');
        }
    }

    /**
     * Mengambil daftar semua pengguna dengan peran 'pengelola'.
     */
    public function index()
    {
        $this->authorizeAdmin();
        $pengelolaUsers = User::where('role', 'pengelola')->latest()->get();
        return response()->json($pengelolaUsers);
    }

    /**
     * Membuat akun Pengelola baru.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'faculty' => 'required|string|max:255',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'faculty' => $validatedData['faculty'],
            'role' => 'pengelola', // Otomatis diatur sebagai 'pengelola'
            'password' => Hash::make($validatedData['password']),
        ]);

        return response()->json(['message' => 'Pengelola account created successfully!', 'user' => $user], 201);
    }

    /**
     * Mengambil data satu pengguna spesifik untuk form edit.
     */
    public function show(User $user)
    {
        $this->authorizeAdmin();
        return response()->json($user);
    }

    /**
     * Memperbarui data pengguna Pengelola.
     */
    public function update(Request $request, User $user)
    {
        $this->authorizeAdmin();
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'faculty' => 'required|string|max:255',
            'password' => ['nullable', 'confirmed', Password::min(8)], // Password opsional
        ]);

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'faculty' => $validatedData['faculty'],
        ]);

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
            $user->save();
        }

        return response()->json(['message' => 'User updated successfully!', 'user' => $user]);
    }

    /**
     * Menghapus akun pengguna Pengelola.
     */
    public function destroy(User $user)
    {
        $this->authorizeAdmin();
        // Keamanan tambahan: jangan biarkan admin menghapus akun admin lain atau dirinya sendiri
        if ($user->role === 'admin') {
            return response()->json(['message' => 'Admin accounts cannot be deleted.'], 403);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }
}