<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->enum('type',['billing', 'shipping']);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->char('country',60);
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('street_address');
            $table->string('postal_code')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_addresses');
    }
};
