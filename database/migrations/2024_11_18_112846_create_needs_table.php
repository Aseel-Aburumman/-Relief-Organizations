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
        Schema::create('needs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('item_name')->nullable();
            $table->string('item_name_ar')->nullable();

            $table->integer('quantity_needed');
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();

            $table->enum('urgency', ['High Priority', 'Medium Priority']);
            $table->enum('status', ['Available', 'Partially Fulfilled', 'Fulfilled'])->default('Available');
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('needs');
    }
};
