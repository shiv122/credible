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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name', 2000);
            $table->string('address', 2000);
            $table->string('website', 2000)->nullable();
            $table->string('phone');
            $table->string('email');
            $table->enum('type', ['organization', 'individual']);
            $table->string('age_of_business');
            $table->enum('status', ['active', 'inactive', 'rejected', 'blocked'])->default('inactive');
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
        Schema::dropIfExists('businesses');
    }
};
