<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_valas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('account_number');
            $table->string('recipient_bank');
            $table->string('currency'); // USD, SGD, JPY
            $table->decimal('amount_idr', 15, 2); // Jumlah dalam Rupiah
            $table->decimal('exchange_rate', 15, 2); // Rate tukar
            $table->decimal('amount_valas', 15, 2); // Jumlah dalam valas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_valas');
    }
};
