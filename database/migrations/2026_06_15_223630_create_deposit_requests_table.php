<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deposit_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('deposit_method_id')->nullable()->constrained()->nullOnDelete();
            $table->string('method_label');
            $table->decimal('amount', 15, 2);
            $table->string('reference')->nullable(); // tx hash / sender name
            $table->string('status')->default('pending'); // pending | approved | rejected
            $table->string('admin_note')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deposit_requests');
    }
};
