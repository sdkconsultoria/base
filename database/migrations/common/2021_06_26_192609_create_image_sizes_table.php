<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Sdkconsultoria\Base\Models\Common\Image\ImageSize;

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
            $table->string('model')->nullable();
            $table->string('name');
            $table->string('height');
            $table->string('width');
            $table->string('quality');
            $table->string('aspect');
            $table->string('fill')->nullable();
            $table->boolean('transparency');
        });

        $sizes = [
            [
                'name' => 'thumbnail',
                'aspect' => 'crop',
            ],
            [
                'name' => 'small',
                'aspect' => 'crop',
            ],
            [
                'name' => 'medium',
                'aspect' => 'crop',
            ],
            [
                'name' => 'large',
                'aspect' => 'upsize',
            ],
        ];

        foreach ($sizes as $index => $size) {
            // Db::table('image_sizes')->insert([
            //     'name' => $size['name'],
            //     'height' => $index + 1 * 100,
            //     'width' => $index + 1 * 100,
            //     'quality' => '90',
            //     'aspect' => $size['aspect'],
            //     'fill' => false,
            //     'transparency' => '0',
            //     'status' => ImageSize::STATUS_ACTIVE,
            // ]);
        }
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
