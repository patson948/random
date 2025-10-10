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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->string('reference')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('payment_method')->default('mobile_money');
            $table->string('provider')->default('lenco');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('ZMW');
            $table->string('status')->default('pending'); // pending, successful, failed, cancelled
            $table->string('provider_status')->nullable(); // lenco status
            $table->string('provider_reference')->nullable(); // lenco reference
            $table->json('provider_data')->nullable(); // full lenco response
            $table->string('phone')->nullable();
            $table->string('operator')->nullable();
            $table->string('country', 2)->default('ZM');
            $table->text('failure_reason')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['reference']);
            $table->index(['provider_reference']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
