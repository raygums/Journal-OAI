<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom 'role' setelah kolom 'email'.
            // Tipe ENUM membatasi nilai hanya boleh 'admin' atau 'pengelola'.
            // Defaultnya adalah 'pengelola'.
            $table->enum('role', ['admin', 'pengelola'])->after('email')->default('pengelola');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom 'role' jika migration di-rollback.
            $table->dropColumn('role');
        });
    }
};