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
            $table->integer('views_count')->unsigned()->default(0)->index()->comment('浏览量');
            $table->integer('comments_count')->unsigned()->default(0)->index()->comment('评论量');
            $table->integer('order')->unsigned()->default(0)->index();

            $table->string('type', 16)->default('post')->comment('post文章 post_draft文章草稿 page页面 page_draft页面草稿 link链接 attachment文件 nav导航');
            $table->string('status', 16)->default('publish')->comment('内容的状态 publish发布 hidden隐藏 private私人');

            $table->boolean('allow_comment')->default(true)->comment('是否允许评论');
            $table->boolean('allow_feed')->default(true)->comment('是否允许在聚合中出现');

            $table->unsignedInteger('parent_id')->default(0)->comment('父类 ID');

            $table->timestamp('created_at', 0)->nullable()->index();
            $table->timestamp('updated_at', 0)->nullable();
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
