<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Method ini akan dieksekusi ketika kamu menjalankan perintah `php artisan migrate`.
     * Tujuannya adalah untuk membuat tabel 'journals' beserta semua kolomnya.
     */
    public function up(): void
    {
        Schema::create('journals', function (Blueprint $table) {
            // === BAGIAN UTAMA ===
            $table->id(); // Kunci utama (Primary Key) untuk setiap jurnal
           
            // === BAGIAN CONTACT DETAIL (PIC) ===
            // Sesuai dengan form "Contact Detail"
            $table->string('contact_name'); // Kolom untuk "Your Name"
            $table->string('contact_email'); // Kolom untuk "Your email (PIC of Journal)"
            $table->string('institution'); // Kolom untuk "Institution/Company"
            $table->string('faculty'); // Kolom untuk Fakultas (option)

            // === BAGIAN JOURNAL INFORMATION ===
            // Sesuai dengan form "Journal Information"
            $table->string('original_title'); // Kolom untuk "The Original Title of The Journal"
            $table->string('display_title'); // Kolom untuk "Title of The Journal"
            $table->string('doi'); // Kolom untuk "DOI", wajib diisi
            $table->string('journal_type')->default('Journal'); // Kolom untuk "Journal Type"
            $table->string('issn'); // Kolom untuk "ISSN", wajib diisi
            $table->string('e_issn'); // Kolom untuk "e-ISSN", wajib diisi

            // === BAGIAN PUBLISHER & DETAIL JURNAL ===
            // Sesuai dengan form "Publisher" dan informasi lainnya
            $table->string('publisher'); // Kolom untuk "Publisher"
            $table->string('publisher_country')->default('Indonesia (ID)'); // Kolom untuk "Country of Publisher"
            $table->string('journal_website_url'); // Kolom untuk "Journal Website"
            $table->string('journal_contact_name'); // Kolom untuk "Journal Contact name", wajib diisi
            $table->string('journal_official_email'); // Kolom untuk "Journal Official Email", wajib diisi
            $table->string('journal_contact_phone'); // Kolom untuk "Journal Contact Phone", wajib diisi
            $table->year('start_year'); // Kolom untuk "Start year since online full text content is available"
            $table->string('period_of_issue'); // Kolom untuk "Period Of Issue Per Year"
            $table->text('editorial_team'); // Kolom untuk Tim Editorial (text field)
            $table->text('editorial_address'); // Kolom untuk "Journal editorial address"
            $table->text('description'); // Kolom untuk "Description of the aim and scope of the journal"

            // === BAGIAN INFORMASI TAMBAHAN (URL & STATUS) ===
            // Sesuai dengan form bagian akhir
            $table->boolean('has_homepage'); // Kolom untuk "Does the journal has a homepage?"
            $table->boolean('is_using_ojs'); // Kolom untuk "Is the journal already used Open Journal System (OJS)"
            $table->string('ojs_link'); // Kolom untuk link OJS
            $table->string('open_access_example_url'); // Kolom untuk "example link to the online full text"
            $table->string('editorial_board_url'); // Kolom untuk "URL of the editorial board"
            $table->string('contact_url'); // Kolom untuk "URL of the Contact"
            $table->string('reviewer_url'); // Kolom untuk "URL of reviewer"
            $table->string('google_scholar_url')->nullable();; // Kolom untuk "URL of Google Scholar"
            $table->string('sinta_link')->nullable(); // Kolom untuk Link Sinta (text field, bisa kosong)
            $table->string('sinta_accreditation')->nullable(); // Kolom untuk Akreditasi Sinta (option, bisa kosong)
            $table->string('garuda_link')->nullable(); // Kolom untuk Link Garuda (text field, bisa kosong)
            $table->string('scopus_indexing')->nullable(); // Kolom untuk Indexing Scopus (option, bisa kosong)
            $table->string('oai_link')->nullable();
            $table->string('journal_cover_url'); // Kolom untuk "URL of Journal's Cover"
            
            // === BAGIAN SUBJECT AREA ===
            // Menggunakan tipe JSON untuk menyimpan array dari subjek yang dipilih.
            $table->json('subject_area_arjuna'); // Kolom untuk "Subject Area Arjuna"
            $table->json('subject_area_garuda'); // Kolom untuk "Subject Area Garuda (max. 5)"

            // Kolom status dengan definisi finalnya
            $table->enum('status', [
                'draft',
                'pending_approval',
                'needs_revision',
                'published',
                'edit_requested'
            ])->default('draft');


            // Timestamps otomatis akan membuat kolom `created_at` dan `updated_at`
            // untuk melacak kapan data dibuat dan terakhir diubah.
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * Method ini akan dieksekusi ketika kamu menjalankan `php artisan migrate:rollback`.
     * Tujuannya adalah untuk menghapus tabel 'journals' jika diperlukan.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
