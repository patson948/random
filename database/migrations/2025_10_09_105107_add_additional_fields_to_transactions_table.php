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
        Schema::table('transactions', function (Blueprint $table) {
            // Add fields to capture additional Lenco response data
            $table->decimal('fee', 10, 2)->nullable()->after('amount');
            $table->string('bearer')->nullable()->after('fee');
            $table->string('source')->nullable()->after('bearer');
            $table->string('account_name')->nullable()->after('phone');
            $table->string('operator_transaction_id')->nullable()->after('account_name');
            $table->timestamp('initiated_at')->nullable()->after('processed_at');
            $table->timestamp('completed_at')->nullable()->after('initiated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'fee',
                'bearer', 
                'source',
                'account_name',
                'operator_transaction_id',
                'initiated_at',
                'completed_at'
            ]);
        });
    }
};
