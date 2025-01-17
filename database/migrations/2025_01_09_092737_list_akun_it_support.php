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
        Schema::create('list_akun_it_supports', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('username')->unique(); // Unique username
            $table->string('password'); // Password field
            $table->string('shift'); // Shift field
            $table->string('nomor_hp'); // Phone number field
            $table->timestamps(); // Created_at and Updated_at fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_akun_it_supports');
    }
};
