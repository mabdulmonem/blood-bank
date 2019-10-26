<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBloodTypesTable extends Migration {

	public function up()
	{
		Schema::create('blood_types', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->string('name', 100);
			$table->timestamps();
		});
		\Illuminate\Support\Facades\DB::table('blood_types')->insert([
            ['name' => "A+"],
            ['name' => "A-"],
            ['name' => "B+"],
            ['name' => "B-"],
            ['name' => "AB+"],
            ['name' => "O+"],
            ['name' => "O-"]
        ]);
	}

	public function down()
	{
		Schema::drop('blood_types');
	}
}
