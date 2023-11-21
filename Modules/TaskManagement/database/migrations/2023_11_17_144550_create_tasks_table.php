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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_title')->unique();
            $table->string('slug')->unique();
            $table->string('description');
            $table->integer('created_by');
            $table->foreignId('user_id');//to be saved as array in future
            $table->string('type');// task and document type table
            $table->integer('status');//only 1 to 4
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
