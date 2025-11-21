<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('sanphams') && !Schema::hasColumn('sanphams', 'hinhanh')) {
            Schema::table('sanphams', function (Blueprint $table) {
                $table->string('hinhanh')->nullable()->after('trangthai');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('sanphams') && Schema::hasColumn('sanphams', 'hinhanh')) {
            Schema::table('sanphams', function (Blueprint $table) {
                $table->dropColumn('hinhanh');
            });
        }
    }
};
