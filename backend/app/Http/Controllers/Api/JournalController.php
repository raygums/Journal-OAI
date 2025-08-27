<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class JournalController
 *
 * Controller ini bertanggung jawab untuk menangani semua logika bisnis
 * terkait pengelolaan data jurnal oleh pengguna dengan peran "Pengelola".
 */
class JournalController extends Controller
{

    /**
     * Fungsi private untuk otorisasi. Memastikan hanya Pengelola yang bisa
     * menjalankan aksi-aksi tertentu.
     */
    private function authorizePengelola()
    {
        if (Auth::user()->role !== 'pengelola') {
            abort(403, 'Unauthorized. Only Pengelola can perform this action.');
        }
    }

    /**
     * Menampilkan daftar jurnal yang dibuat oleh Pengelola yang sedang login.
     */
    public function index()
    {
        $this->authorizePengelola();
        $journals = Auth::user()->journals()->latest()->get();
        return response()->json($journals);
    }


    /**
     * Menampilkan daftar draf jurnal HANYA milik pengguna yang sedang login.
     * Terhubung ke: GET /api/journals
     */
    

    /**
     * Menyimpan draf jurnal baru ke database dan mengaitkannya dengan pengguna yang sedang login.
     * Terhubung ke: POST /api/journals
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'institution' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'editorial_team' => 'required|string',
            'sinta_link' => 'nullable|url|max:255',
            'sinta_accreditation' => 'nullable|string|max:50',
            'garuda_link' => 'nullable|url|max:255',
            'scopus_indexing' => 'nullable|string|max:50',
            'original_title' => 'required|string',
            'display_title' => 'required|string',
            'doi' => 'required|string|max:255',
            'journal_type' => 'required|string|max:100',
            'issn' => 'required|string|max:50',
            'e_issn' => 'required|string|max:50',
            'publisher' => 'required|string|max:255',
            'publisher_country' => 'required|string|max:100',
            'journal_website_url' => 'required|url',
            'journal_contact_name' => 'required|string|max:255',
            'journal_official_email' => 'required|email|max:255',
            'journal_contact_phone' => 'required|string|max:50',
            'start_year' => 'required|digits:4|integer|min:1900',
            'period_of_issue' => 'required|string|max:255',
            'editorial_address' => 'required|string',
            'description' => 'required|string',
            'has_homepage' => 'required|boolean',
            'is_using_ojs' => 'required|boolean',
            'ojs_link' => 'required|url',
            'open_access_example_url' => 'required|url',
            'editorial_board_url' => 'required|url',
            'contact_url' => 'required|url',
            'reviewer_url' => 'required|url',
            'google_scholar_url' => 'required|url',
            'journal_cover_url' => 'required|url',
            'subject_area_arjuna' => 'required|array',
            'subject_area_garuda' => 'required|array',
        ]);

        // Membuat jurnal baru menggunakan relasi. Laravel akan secara otomatis
        // mengisi kolom 'user_id' dengan ID pengguna yang sedang login.
        $journal = Auth::user()->journals()->create($validatedData);

        return response()->json([
            'message' => 'Journal draft created successfully. Ready for review.',
            'data' => $journal
        ], 201);
    }

    /**
     * Menampilkan data detail dari satu draf jurnal spesifik, dengan verifikasi kepemilikan.
     * Terhubung ke: GET /api/journals/{journal}
     */
    /**
     * Menampilkan detail satu jurnal (untuk halaman review).
     */
    public function show(Journal $journal)
    {
        // Otorisasi: Pastikan Pengelola hanya bisa melihat jurnal miliknya.
        if (Auth::id() !== $journal->user_id) {
            abort(403, 'Unauthorized.');
        }
        return response()->json($journal);
    }

    /**
     * Memperbarui draf jurnal.
     */
    public function update(Request $request, Journal $journal)
    {
        $this->authorizePengelola();
        if (Auth::id() !== $journal->user_id) {
            abort(403, 'Unauthorized.');
        }

        // Hanya draf atau yang butuh revisi yang bisa di-update
        if (!in_array($journal->status, ['draft', 'needs_revision'])) {
            return response()->json(['message' => 'This journal cannot be edited at its current state.'], 403);
        }

        // Validasi data yang masuk (sama seperti method store).
        $validatedData = $request->validate([
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'institution' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'editorial_team' => 'required|string',
            'sinta_link' => 'nullable|url|max:255',
            'sinta_accreditation' => 'nullable|string|max:50',
            'garuda_link' => 'nullable|url|max:255',
            'scopus_indexing' => 'nullable|string|max:50',
            'original_title' => 'required|string',
            'display_title' => 'required|string',
            'doi' => 'required|string|max:255',
            'journal_type' => 'required|string|max:100',
            'issn' => 'required|string|max:50',
            'e_issn' => 'required|string|max:50',
            'publisher' => 'required|string|max:255',
            'publisher_country' => 'required|string|max:100',
            'journal_website_url' => 'required|url',
            'journal_contact_name' => 'required|string|max:255',
            'journal_official_email' => 'required|email|max:255',
            'journal_contact_phone' => 'required|string|max:50',
            'start_year' => 'required|digits:4|integer|min:1900',
            'period_of_issue' => 'required|string|max:255',
            'editorial_address' => 'required|string',
            'description' => 'required|string',
            'has_homepage' => 'required|boolean',
            'is_using_ojs' => 'required|boolean',
            'ojs_link' => 'required|url',
            'open_access_example_url' => 'required|url',
            'editorial_board_url' => 'required|url',
            'contact_url' => 'required|url',
            'reviewer_url' => 'required|url',
            'google_scholar_url' => 'required|url',
            'journal_cover_url' => 'required|url',
            'subject_area_arjuna' => 'required|array',
            'subject_area_garuda' => 'required|array',
        ]);

        $journal->update($validatedData);

        return response()->json([
            'message' => 'Journal draft updated successfully.',
            'data' => $journal
        ]);
    }

    
    /**
     * Mengirim draf untuk verifikasi oleh Admin.
     */
    public function submitForApproval(Journal $journal)
    {
        $this->authorizePengelola();
        if (Auth::id() !== $journal->user_id) {
            abort(403, 'Unauthorized.');
        }

        if ($journal->status !== 'draft' && $journal->status !== 'needs_revision') {
             return response()->json(['message' => 'Only drafts or journals needing revision can be submitted.'], 422);
        }

        $journal->status = 'pending_approval';
        $journal->save();

        return response()->json(['message' => 'Journal submitted for approval successfully!']);
    }

        /**
     * Menangani permintaan izin edit dari Pengelola untuk jurnal yang sudah dipublikasikan.
     */
    public function requestEditApproval(Journal $journal)
    {
        $this->authorizePengelola();
        if (Auth::id() !== $journal->user_id) {
            abort(403, 'Unauthorized.');
        }

        // Hanya jurnal yang sudah 'published' yang bisa diminta untuk diedit
        if ($journal->status !== 'published') {
            return response()->json(['message' => 'Only published journals can be requested for edit.'], 422);
        }

        $journal->status = 'edit_requested';
        $journal->save();

        return response()->json(['message' => 'Edit request submitted successfully. Please wait for admin approval.']);
    }
}