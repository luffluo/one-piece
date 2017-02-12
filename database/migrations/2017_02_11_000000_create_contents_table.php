<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->default(0)->index();
            $table->string('title', 200);
            $table->string('slug', 200)->nullable()->index()->comment('内容缩略名 用于友好的 url');
            $table->text('text')->nullable();
            $table->integer('comments_count')->unsigned()->default(0)->index()->comment('评论数');
            $table->integer('order')->unsigned()->default(0)->index();
            $table->string('template', 32)->nullable()->comment('模板');
            $table->string('type', 16)->nullable()->comment('post文章 draft草稿 page页面 link链接 attachment文件');
            $table->string('status', 16)->nullable()->comment('内容的状态 比如有时想隐藏文章 hidden隐藏 private私人');
            $table->timestamp('published_at')->nullable()->comment('发布时间 可以让文章定在某个时间发布');
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
        Schema::dropIfExists('contents');
    }
}
