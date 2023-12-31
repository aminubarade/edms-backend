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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_title')->unique();
            $table->string('slug')->unique();
            $table->string('type');
            $table->string('classification');
            $table->string('document_ref')->unique();
            $table->string('body');
            $table->string('status')->default("Draft");
            $table->foreignId('created_by');
            $table->boolean('is_active')->default(1);
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('completed_by')->nullable();
           // $table->foreignId('deleted_by')->nullable();
            $table->foreignId('task_id')->nullable();
            $table->foreignId('folder_id')->nullable();
            $table->foreignId('department_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
