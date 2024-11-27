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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id'); // Add this line for the relationship
            $table->string('category')->nullable();
            $table->string('type');
            $table->string('name');
            $table->string('title');
            $table->string('organization')->nullable();
            $table->string('designation')->nullable();
            $table->integer('days')->nullable();
            $table->string('date');
            $table->text('raw_text');
            $table->float('points')->nullable();
            $table->timestamps();
            //
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
