<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug', 100)->unique();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('group_category_id')->unsigned()->nullable();
            $table->integer('area_id')->unsigned()->nullable();
            $table->string('name', 100);
            $table->boolean('is_public')->default(true);
            $table->enum('invitation_role', ['owner', 'organizer', 'member', 'anyone'])->default('anyone');
            $table->string('description', 5000);
            $table->string('homepage', 200)->nullable();
            $table->string('facebook', 200)->nullable();
            $table->string('twitter', 200)->nullable();
            $table->string('instagram', 200)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('group_category_id')->references('id')->on('group_categories')->onDelete('set null');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('set null');

            $table->index('updated_at');
            $table->index('created_at');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
