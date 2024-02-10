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
        Schema::create('articles', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->id();
            $table->string('code', 255)->unique();
            $table->string('original_url')->nullable();
            $table->string('image')->nullable();
            $table->string('title', 255);
            $table->text('preview');
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('article_category', function (Blueprint $table) {
            $table->foreignId('article_id')->references('id')->on('articles');
            $table->foreignId('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_category');
        Schema::dropIfExists('articles');
    }
};
