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
        Schema::create('comment_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comment_id')->nullable();
            $table->unsignedBigInteger('reply_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->text('reason')->nullable();
            $table->timestamps();

            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('reply_id')->references('id')->on('comment_replies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_reports');
    }
};
