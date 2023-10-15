<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->primary('admin_id');
            $table->foreignId('admin_id')->unique()->constrained('admins')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthday');
            $table->enum('gender',['male','female','others'])->nullable();
            $table->string('street_address');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->char('country',60);
            $table->string('postal_code')->nullable();
            $table->string('locale')->default('en');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
