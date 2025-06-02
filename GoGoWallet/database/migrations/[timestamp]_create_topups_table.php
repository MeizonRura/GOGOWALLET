<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('topups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->string('status'); // success, pending, failed
            $table->string('payment_method'); // bca, bni, mandiri
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('topups');
    }
};