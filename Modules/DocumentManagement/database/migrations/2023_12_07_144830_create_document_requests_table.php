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
        Schema::create('document_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id');
            $table->string('title');
            $table->string('slug');
            $table->foreignId('request_from');
            $table->foreignId('request_to');
            $table->string('request_status')->default('pending');
            $table->foreignId('originated_by');
            $table->foreignId('treated_by')->nullable();
            $table->boolean('is_active')->default(0);
            $table->string('remark')->nullable();
            $table->string('document_ref')->nullabe();
            $table->date('approval_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};
