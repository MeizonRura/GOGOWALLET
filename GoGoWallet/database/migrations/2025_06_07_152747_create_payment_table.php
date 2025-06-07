<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Drop any existing indexes safely
        if (Schema::hasTable('payments')) {
            try {
                DB::statement('DROP TABLE IF EXISTS payments');
            } catch (\Exception $e) {
                // If table drop fails, try to remove indexes first
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                DB::statement('ALTER TABLE payments DROP INDEX IF EXISTS payments_virtual_account_unique');
                DB::statement('DROP TABLE IF EXISTS payments');
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            }
        }

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('va_number');
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('pending');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};