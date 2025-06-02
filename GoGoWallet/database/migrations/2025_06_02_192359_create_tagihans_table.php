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
            $table->string('nama_pelanggan');
            $table->string('deskripsi');
            $table->decimal('jumlah', 12, 2);
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
