<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->enum('status', ['pending', 'in progress', 'delivered'])->default('pending')->change();
       //     DB::statement("ALTER TABLE `delivers`
       //         CHANGE COLUMN `status` `status` ENUM('pending', 'in progress', 'delivered') DEFAULT NOT NULL 'pending'");
       });
    }

    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->enum('status', ['pending', 'in progress', 'delivered'])->default('pending')->change();
        });
    }
};
