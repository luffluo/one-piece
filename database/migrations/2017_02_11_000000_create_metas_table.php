<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique()->index()->comment('缩略名');
            $table->string('description')->nullable();
            $table->string('type', 16)->default('tag')->comment('tag标签 category分类 link_category链接分类');
            $table->integer('order')->unsigned()->default(0)->index();
            $table->integer('count')->unsigned()->default(0)->index()->comment('文章数');
            $table->integer('parent_id')->unsigned()->default(0)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metas');
    }
}
