<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTranslatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_translates', function (Blueprint $table) {
            $table->commonFields();
            $table->string('language')->nullable();
            $table->foreignId('product_id')->constrained();
            $table->string('name');
            $table->string('seoname');
            $table->text('description');
            $table->string('short_description');
            $table->double('price')->nullable();
            $table->double('cost_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_translates');
    }
}
