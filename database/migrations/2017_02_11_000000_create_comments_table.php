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
            $table->integer('content_id')->unsigned()->index();
            // $table->integer('author_id')->unsigned()->index()->comment('评论的文章的作者');
            $table->integer('user_id')->unsigned()->index();
            $table->text('text');
            $table->integer('parent_id')->unsigned()->index();
            $table->string('status', 16)->default('approved')->comment('是否通过审核等 approved已通过 waiting待审核 spam垃圾');
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
