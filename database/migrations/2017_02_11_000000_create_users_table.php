<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('name')->unique()->comment('用户名 可用于登录');
            $table->string('email')->unique()->comment('可用于登录');
            $table->string('nickname')->nullable()->comment('昵称 用于显示的名称');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('password');
            $table->timestamp('activated_at')->nullable()->comment('激活时间');
            $table->timestamp('last_seen_time')->nullable()->comment('最后登录时间');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
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
