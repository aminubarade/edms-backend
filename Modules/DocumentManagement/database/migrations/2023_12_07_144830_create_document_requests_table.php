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
            $table->foreignId('request_from');
            $table->foreignId('request_to');
            $table->string('request_status')->default('pending');
            $table->foreignId('treated_by')->nullable();
            $table->string('remark')->nullable();
            $table->string('document_ref')->nullabe();
            $table->date('approval_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};
