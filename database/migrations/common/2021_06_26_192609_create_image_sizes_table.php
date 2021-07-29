<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_sizes', function (Blueprint $table) {
            $table->commonFields();
            $table->string('model');
            $table->string('name');
            $table->string('height');
            $table->string('width');
            $table->string('quality');
            $table->string('aspect');
            $table->boolean('fill');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_sizes');
    }
}
