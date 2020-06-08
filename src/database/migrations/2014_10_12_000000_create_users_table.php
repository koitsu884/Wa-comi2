<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('name', 100);
            $table->string('avatar')->nullable();
            $table->string('introduction', 5000)->nullable();
            $table->string('twitter', 200)->nullable();
            $table->string('instagram', 200)->nullable();
            $table->string('facebook', 200)->nullable();
            $table->string("verification_token")->nullable();
            $table->boolean('admin')->default(false);
            $table->rememberToken();
            $table->timestamps();

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
        Schema::dropIfExists('users');
    }
}
