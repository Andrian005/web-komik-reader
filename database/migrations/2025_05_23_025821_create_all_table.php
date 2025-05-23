<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->enum('level', ['super', 'editor']);
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('titles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['manga', 'manhua', 'manhwa', 'novel']);
            $table->string('author');
            $table->string('artist');
            $table->enum('status', ['ongoing', 'completed', 'hiatus']);
            $table->text('synopsis');
            $table->foreignId('genre_id')->constrained('genres')->onDelete('cascade');
            $table->string('cover_image')->nullable();
            $table->year('released_year');
            $table->string('country');
            $table->unsignedBigInteger('views')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('title_genre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('title_id')->constrained('titles')->onDelete('cascade');
            $table->foreignId('genre_id')->constrained('genres')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('title_id')->constrained('titles')->onDelete('cascade');
            $table->decimal('chapter_number', 5, 2);
            $table->string('chapter_title')->nullable();
            $table->date('release_date');
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();
        });

        Schema::create('chapter_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained('chapters')->onDelete('cascade');
            $table->integer('page_number');
            $table->string('image_path');
            $table->timestamps();
        });

        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('title_id')->constrained('titles')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('title_id')->nullable()->constrained('titles')->onDelete('cascade');
            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('title_id')->constrained('titles')->onDelete('cascade');
            $table->tinyInteger('score');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('chapter_pages');
        Schema::dropIfExists('chapters');
        Schema::dropIfExists('title_genre');
        Schema::dropIfExists('titles');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('users');
        Schema::dropIfExists('admins');
    }
};
