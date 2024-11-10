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
            $table->string('type');
            $table->string('name');
            $table->string('title');
            $table->string('date');
            $table->text('raw_text');
            $table->float('points')->default(0);
            $table->timestamps();
            //
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    //
    public function teacher()
    {
    return $this->belongsTo(Teacher::class);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
