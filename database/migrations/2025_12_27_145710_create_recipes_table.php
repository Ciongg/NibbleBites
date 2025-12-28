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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->json('ingredients');
            $table->text('instructions');
            $table->string('image_path')->nullable();
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->enum('cost_range', ['low', 'medium', 'high'])->default('low');
            $table->integer('minutes_to_make');
            $table->integer('servings')->default(1);
            $table->integer('calories_per_serving');
            $table->boolean('is_private')->default(false);
            $table->boolean('is_vegan')->default(false);
            $table->integer('nibbled_count')->default(0);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
