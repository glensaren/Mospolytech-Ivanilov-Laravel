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
        Schema::table('articles', function (Blueprint $table) {
            // Добавьте недостающие колонки
            $table->string('title')->after('id');
            $table->text('content')->after('title');
            $table->string('short_description')->nullable()->after('content');
            $table->string('author')->after('short_description');
            $table->date('publication_date')->after('author');
            $table->string('category')->after('publication_date');
            $table->string('preview_image')->nullable()->after('category');
            $table->boolean('is_published')->default(true)->after('preview_image');
            $table->integer('views_count')->default(0)->after('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['title', 'content', 'short_description', 'author', 
                              'publication_date', 'category', 'preview_image', 
                              'is_published', 'views_count']);
        });
    }
};
