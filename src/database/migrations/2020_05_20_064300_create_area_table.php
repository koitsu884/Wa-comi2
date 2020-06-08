<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $areas = [
            ['name' => 'オークランド'],
            ['name' => 'ウェリントン'],
            ['name' => 'タウランガ'],
            ['name' => 'ロトルア'],
            ['name' => 'ハミルトン'],
            ['name' => 'タウポ'],
            ['name' => 'ネイピア'],
            ['name' => 'ニュープリマス'],
            ['name' => 'パーマストンノース'],
            ['name' => 'ワンガヌイ'],
            ['name' => 'ノースランド'],
            ['name' => 'その他北島'],
            ['name' => 'クライストチャーチ'],
            ['name' => 'クイーンズタウン'],
            ['name' => 'ダニーデン'],
            ['name' => 'ネルソン'],
            ['name' => 'ワナカ'],
            ['name' => 'その他南島'],
            ['name' => 'ニュージーランド国外'],
        ];

        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20);
        });

        DB::table('areas')->insert($areas);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areas');
    }
}
