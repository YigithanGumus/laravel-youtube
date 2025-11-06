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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('channel_id'); // SQLite için bigInteger kullan
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('duration')->nullable();
            $table->integer('views')->default(0);
            $table->string('uid');
            $table->string('thumbnail_image')->nullable();
            $table->text('path')->nullable();
            $table->string('processed_file')->nullable();
            $table->string('visibility')->default('private'); // SQLite enum desteklemez
            $table->boolean('processed')->default(false);
            $table->boolean('allow_likes')->default(false);
            $table->boolean('allow_comments')->default(false);
            $table->string('processing_percentage')->default('0');
            $table->timestamps();
            $table->string('image')->nullable();
            $table->integer('is_converting_for_streaming')->default(0);
            $table->string('video_orginal_path')->nullable();
            $table->string('video_orginal_url')->nullable();
            $table->string('file_hash')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
