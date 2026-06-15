<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deposit_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');                     // e.g. "USDT (TRC20)", "Bank Transfer"
            $table->string('type')->default('crypto');  // crypto | bank
            $table->string('code')->nullable();         // BTC, ETH, USDT…
            $table->string('network')->nullable();      // TRC20, ERC20, Bitcoin…
            $table->string('address')->nullable();      // wallet address
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->text('instructions')->nullable();
            $table->string('icon')->nullable();
            $table->decimal('min_amount', 15, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deposit_methods');
    }
};
