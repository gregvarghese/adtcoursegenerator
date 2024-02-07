<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('prompt');
            $table->longText('json');
            $table->longText('markdown');
            $table->longText('html');
            $table->unsignedBigInteger('topic_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('user_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
