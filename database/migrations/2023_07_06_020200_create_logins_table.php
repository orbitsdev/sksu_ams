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
        Schema::create('logins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('day_record_id')->nullable();
            $table->foreignId('account_id')->nullable();
            $table->timestamp('morning_in')->nullable();
            $table->timestamp('morning_out')->nullable();
            $table->timestamp('noon_in')->nullable();
            $table->timestamp('noon_out')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logins');
    }
};
