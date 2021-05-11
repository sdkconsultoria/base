<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->commonFields();
            $table->string('imageable_id');
            $table->string('imageable_type');
            $table->string('extension');
            $table->string('type')->nullable();
            $table->integer('order')->default(1);
            $table->index('imageable_type');
            $table->index('imageable_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
