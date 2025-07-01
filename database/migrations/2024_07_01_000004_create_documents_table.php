<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_number')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('division_id')->constrained('divisions')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('version', 10)->default('1.0');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type');
            $table->integer('file_size');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('upload_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['document_number', 'title']);
            $table->index(['division_id', 'category_id']);
            $table->index('is_active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
