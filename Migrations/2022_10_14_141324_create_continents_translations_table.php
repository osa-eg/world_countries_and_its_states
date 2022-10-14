<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('continents_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('continent_id');
            $table->string('locale')->index();
            $table->string('name')->nullable();
            $table->unique(['continent_id', 'locale']);
            $table->foreign('continent_id')->references('id')->on('continents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('continents_translations');
    }
};