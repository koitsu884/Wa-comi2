<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            ['name' => '友達'],
            ['name' => '趣味・同好会'],
            ['name' => '旅仲間・ライドシェア'],
            ['name' => 'フラットメイト'],
            ['name' => '語学・エクスチェンジ'],
            ['name' => 'その他'],
        ];

        Schema::create('post_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20);
        });

        DB::table('post_categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_categories');
    }
}
