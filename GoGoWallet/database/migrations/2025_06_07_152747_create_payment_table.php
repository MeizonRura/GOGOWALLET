<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Jika ingin benar-benar fresh, hapus tabel dulu (hati-hati di production!)
        Schema::dropIfExists('payments');

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('va_number');
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('pending');
            $table->string('description')->nullable();
            $table->timestamps();

            // Jika VA harus unik, aktifkan baris di bawah ini:
            // $table->unique('va_number');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};