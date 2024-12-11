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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->default('user');
            $table->integer('school_id')->default(0);
            $table->string('acad_attainment')->nullable();
            $table->float('performance')->default(0);
            $table->float('experience')->default(0);
            $table->date('date')->default(now());
            $table->string('office')->nullable();
            $table->float('points')->default(0);
            $table->string('present_rank')->default('Unranked');
            $table->string('next_rank')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
