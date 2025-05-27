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
        Schema::create('share_safaris', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('park_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('no_of_safari');
            $table->string('theme')->nullable();
            $table->string('stay_category')->nullable(); // Correct spelling if needed
            $table->decimal('min_price_pp', 10, 2);
            $table->decimal('max_price_pp', 10, 2);
            $table->integer('total_seats');
            $table->integer('share_seats');
            $table->string('display_image')->nullable();
            $table->integer('picture')->nullable(); // Consider using JSON if storing multiple
            $table->integer('safari_plan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('share_safaris');
    }
};
