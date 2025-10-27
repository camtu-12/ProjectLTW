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
        Schema::create('chitietdonhangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donhang_id')->constrained('donhangs')->onDelete('cascade');
            $table->foreignId('sanpham_id')->constrained('sanphams')->onDelete('cascade');
            $table->integer('soluong');
            $table->decimal('gia', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chitietdonhangs');
    }
};
