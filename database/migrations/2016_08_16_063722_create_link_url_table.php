<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkUrlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * link_id 链接id
     * link_name 链接名称
     * link_tilte 链接标题
     * link_url 链接地址
     * link_order 链接排序
     * @return void
     */
    public function up()
    {
        Schema::create('links',function (Blueprint $table){
            $table->engine = 'MyISAM';
            $table->increments('link_id');
            $table->string('link_name',32)->default('')->comment('');
            $table->string('link_title',32)->default('')->comment('//链接名称');
            $table->string('link_url',255)->default('')->comment('//链接url');
            $table->integer('link_order')->unsigned()->default(0)->comment('//链接排序');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('links');
    }
}
