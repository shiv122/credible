<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_data_images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('business_data_id')->unsigned();
            $table->foreign('business_data_id')->on('business_data')->references('id')->onDelete('cascade');
            $table->string('image', 2000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_data_images');
    }
};
