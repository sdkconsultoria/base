<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('versions', function (Blueprint $table) {
        //     $table->commonFields();
        //     $table->id();
        //     $table->enum('type', ['local', 'children'])->default('local');
        //     $table->string('versionable_type');
        //     $table->string('versionable_id');
        //     $table->foreignId('user_id')->constrained();
        //     $table->integer('version');
        //     $table->json('model_data');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('versions');
    }
}
