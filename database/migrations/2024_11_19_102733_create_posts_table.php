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
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // مفتاح أساسي
            $table->string('title'); // عنوان المنشور
            $table->text('content'); // محتوى المنشور
            $table->foreignId('lang_id')->constrained('languages')->onDelete('cascade'); // مفتاح أجنبي مرتبط بجدول اللغات
            $table->timestamps(); // حقول created_at و updated_at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
