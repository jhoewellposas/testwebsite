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
        Schema::create('rank_distributions', function (Blueprint $table) {
            $table->id();
            $table->string('rank')->unique();
            $table->float('productiveGroupAPercentage')->default(0.8);
            $table->float('productiveGroupBPercentage')->default(0.2);
            $table->float('communityGroupAPercentage')->default(0.7);
            $table->float('communityGroupBPercentage')->default(0.3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rank_distributions');
    }
};
