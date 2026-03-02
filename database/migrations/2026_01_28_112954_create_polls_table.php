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

            $table->string('slug', config('librepolls.polls.slug_length'))->unique();
            $table->string('title', config('librepolls.polls.title_max_length'));
            $table->string('description', config('librepolls.polls.description_max_length'))->nullable();

            $table->boolean('multiple_choices')->default(false);

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
