<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferValasTable extends Migration
{
    public function up()
    {
        Schema::create('transfer_valas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('account_number');
            $table->string('recipient_name');
            $table->string('recipient_bank');
            $table->string('currency'); // SGD, USD, JPY
            $table->decimal('amount', 15, 2); // dalam valas
            $table->decimal('exchange_rate', 15, 6); // valas -> IDR
            $table->decimal('total_in_local', 15, 2); // IDR
            $table->date('transfer_date');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transfer_valas');
    }
}
