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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('description', 150);
            $table->boolean('vision')->default(false);
            $table->string('img')->nullable();
            $table->unsignedBigInteger('uploader')->nullable();
            $table->enum('revision_status', ['pending', 'approved'])->default('approved');
            $table->timestamps();

            $table->foreign('uploader')->references('id')->on('users')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
