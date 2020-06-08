<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_member', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->enum('role', ['owner', 'organizer', 'member'])->default('member');
            $table->integer('created_by')->unsigned()->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->unique(['user_id', 'group_id']);

            $table->timestamps();

            $table->index('updated_at');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_member');
    }
}
