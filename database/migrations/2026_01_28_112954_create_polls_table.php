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
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('slug', 8)->unique();
            $table->string('title', 255);
            $table->string('description', 1023)->nullable();

            $table->boolean('multiple_choices')->default(false);
            $table->boolean('locked')->default(false);

            $table->enum('voter_identifier', ['ip', 'token', 'none']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polls');
    }
};
