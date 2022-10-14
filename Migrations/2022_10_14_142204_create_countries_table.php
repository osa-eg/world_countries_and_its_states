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
        if (Schema::hasTable('countries')) {
            Schema::drop('countries');
        }
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('continent_id')->nullable();
            $table->string('name', 255)->default('');
            $table->string('full_name', 255)->nullable();
            $table->char('country_code', 3)->default('');
            $table->string('capital', 255)->nullable();
            $table->string('citizenship', 255)->nullable();
            $table->string('currency', 255)->nullable();
            $table->string('currency_code', 255)->nullable();
            $table->string('currency_sub_unit', 255)->nullable();
            $table->string('currency_symbol', 3)->nullable();
            $table->integer('currency_decimals')->nullable();
            $table->char('iso_a2', 2)->default('');
            $table->char('iso_a3', 3)->default('');
            $table->char('region_code', 3)->default('');
            $table->char('sub_region_code', 3)->default('');
            $table->boolean('eea')->default(0);
            $table->string('calling_code', 3)->nullable();
            $table->string('flag', 6)->nullable();
            $table->string('flag_emoji')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->json('geo')->nullable();
            $table->string('languages', 255)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('countries');
    }
};