<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->commonFields();
            $table->string('addressable_id')->nullable();
            $table->string('addressable_type')->nullable();
            $table->string('address');
            $table->string('postal_code');
            $table->string('colony');
            $table->string('location');
            $table->string('municipality');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
