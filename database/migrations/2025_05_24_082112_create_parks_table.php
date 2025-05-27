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
        Schema::create('parks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->integer('city')->nullable();
            $table->integer('state');
            $table->integer('country');
            $table->text('train')->comment('nearest train station')->nullable();
            $table->text('airport')->comment('nearest airport')->nullable();
            $table->text('safari_session')->nullable();
            $table->integer('wildlife_found')->nullable();
            $table->string('safari_cost')->nullable();
            $table->string('safari_mode')->nullable();
            $table->string('closed_months')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parks');
    }
};
