<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JournalController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Mengambil daftar semua jurnal untuk ditampilkan di dashboard Admin.
     */
    public function index()
    {
        // Mengambil semua jurnal dan data pengguna yang membuatnya
        $journals = Journal::with('user')->latest()->get();
        return response()->json($journals);
    }

    /**
     * Memperbarui jurnal. Ini adalah method utama untuk verifikasi oleh Admin.
     * Admin bisa mengubah status dan mengisi link OAI.
     */
    public function update(Request $request, Journal $journal)
    {
        $validatedData = $request->validate([
            // Admin hanya boleh mengubah dua kolom ini saat verifikasi
            'oai_link' => 'required|url',
            'status' => ['required', Rule::in(['published', 'needs_revision'])],
        ]);

        $journal->update($validatedData);

        return response()->json([
            'message' => 'Journal status updated successfully!',
            'data' => $journal
        ]);
    }

    /**
     * Menghapus jurnal.
     */
    public function destroy(Journal $journal)
    {
        $journal->delete();
        return response()->json(['message' => 'Journal deleted successfully.']);
    }

    /**
     * Menyetujui permintaan edit dari Pengelola.
     * Ini akan "membuka kunci" jurnal dan mengizinkan Pengelola untuk mengeditnya.
     */
    public function approveEditRequest(Journal $journal)
    {
        // Otorisasi sudah ditangani oleh middleware di file rute

        if ($journal->status !== 'edit_requested') {
            return response()->json(['message' => 'This journal is not awaiting an edit approval.'], 422);
        }

        // Mengubah status menjadi 'needs_revision' akan memungkinkan Pengelola
        // untuk menggunakan method update() di JournalController.
        $journal->status = 'needs_revision';
        $journal->save();

        return response()->json([
            'message' => 'Edit request approved. The user can now update the journal draft.',
            'data' => $journal
        ]);
    }
}