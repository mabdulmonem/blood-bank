<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDonationRequestsTable extends Migration {

	public function up()
	{
		Schema::create('donation_requests', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->string('name', 191);
			$table->string('phone', 191);
			$table->string('hospital_name', 191);
			$table->text('hospital_address');
			$table->integer('patient_age');
			$table->smallInteger('blood_bags_count');
			$table->text('details')->nullable();
			$table->decimal('latitude', 10,8)->nullable();
			$table->decimal('longitude', 10,8)->nullable();
			$table->integer('blood_type_id')->unsigned();
			$table->integer('city_id');
			$table->integer('client_id')->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('donation_requests');
	}
}
