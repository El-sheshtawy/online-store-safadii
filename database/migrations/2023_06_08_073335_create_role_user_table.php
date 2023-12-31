<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->morphs('authorizable'); //authorizable_id , authorizable_type
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->primary(['authorizable_id', 'authorizable_type', 'role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
