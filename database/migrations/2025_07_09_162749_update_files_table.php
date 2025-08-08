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
        Schema::table('files', function (Blueprint $table) {
            $table->bigInteger('user_id');
            if (Schema::hasColumn('files', 'thumbnail_url')) {
                $table->dropColumn('thumbnail_url');
            }
            if (Schema::hasColumn('files', 'size')) {
                $table->dropColumn('size');
            }
            if (Schema::hasColumn('files', 'video_url')) {
                $table->dropColumn('video_url');
            }
            $table->text('download_url')->nullable();
            $table->text('preview_url')->nullable();
            $table->text('thumbnail_url')->nullable();
            $table->text('icon_url')->nullable();
            $table->bigInteger('size')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('extension')->nullable();
            $table->text('parents_id')->nullable();
            $table->boolean('starred');
            $table->boolean('trashed');
            $table->dropTimestamps();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
