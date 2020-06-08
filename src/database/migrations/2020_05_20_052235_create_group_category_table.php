<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGroupCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            ['name' => '交流会'],
            ['name' => '趣味・サークル'],
            ['name' => 'スポーツ・アウトドア'],
            ['name' => '同郷・日本人会'],
            ['name' => '語学・エクスチェンジ'],
            ['name' => '育児・子育て'],
            ['name' => 'ビジネス'],
            ['name' => 'その他'],
        ];

        Schema::create('group_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20);
        });

        DB::table('group_categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_categories');
    }
}
