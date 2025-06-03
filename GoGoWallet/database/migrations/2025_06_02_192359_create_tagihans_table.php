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

{
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_rekening');
            $table->string('nama_rekening');
            $table->decimal('nominal_tagihan', 12, 2);
            $table->string('deskripsi');
            $table->boolean('status_dibayar')->default(false);
            $table->timestamps();
        });
}

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
