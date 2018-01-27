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
            $table->string('profile')->nullable()->comment('个人简介');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('password');
            $table->string('group', 16)->default('visitor')
                ->comment('administrator-管理员－0 editor－编辑－1 contributor－贡献者-2 subscriber－关注者－3 visitor-访问者－4 数字越小权限越高');
            $table->timestamp('activated_at')->nullable()->comment('最后活动时间');
            $table->timestamp('logged_at')->nullable()->comment('上次登录最后活跃时间');
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
