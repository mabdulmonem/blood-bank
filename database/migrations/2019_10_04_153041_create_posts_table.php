<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	public function up()
	{
		Schema::create('posts', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->string('title', 255);
			$table->string('img', 225)->nullable();
			$table->enum('status',['publish','draft'])->default('publish');
			$table->longText('content')->nullable();
			$table->unsignedBigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('category_id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('posts');
	}
}
