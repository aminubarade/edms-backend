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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('phone', 10)->unique();
            $table->string('email')->unique();
            $table->string('rank');
            $table->date('dob');
            $table->string('service_number')->unique();
            $table->string('appt');
            $table->string('service');
            $table->string('unit');
            $table->string('command');
            $table->string('department');
            $table->string('password');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
