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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger('post_id'); // foreign id type should match the column type of the other table
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('body');
            $table->timestamps();

            // Foreign key constraint, delete all associated data with post
            // $table->foreignId('post_id')->constrained(); is equal too
            // $table->unsignedBigInteger('post_id'); and $table->foreign('post_id')->references('id')->on('posts')->OnDelete('cascade');
            //$table->foreign('post_id')->references('id')->on('posts')->OnDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
