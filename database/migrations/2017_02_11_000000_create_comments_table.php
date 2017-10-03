<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id')->unsigned()->default(0)->index();
            $table->integer('user_id')->unsigned()->default(0)->index();
            $table->integer('owner_id')->unsigned()->default(0)->index()->comment('文章所属作者');
            $table->text('text')->comment('评论内容');
            $table->string('type', 16)->default('comment')->index()->comment('');
            $table->string('status', 16)->default('approved')->index()->comment('状态 approved已通过 waiting待审核 spam垃圾');
            $table->integer('parent_id')->unsigned()->default(0)->index();
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
        Schema::dropIfExists('comments');
    }
}
