<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->string('name', 100);
			$table->string('phone', 100)->unique();
			$table->string('email', 100)->unique()->nullable();
			$table->string('password', 100);
			$table->date('date_of_birth')->nullable();
			$table->date('last_donation_date')->nullable();
			$table->integer('rest_code')->nullable();
			$table->enum('status',['active','deactivate'])->default('active');
			$table->string('api_token', 191)->unique()->nullable();
			$table->boolean("is_verified")->default(false) ->nullable();
			$table->integer('blood_type_id')->unsigned();
			$table->integer('city_id')->unsigned();
			$table->string('lang')->default('en')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}
