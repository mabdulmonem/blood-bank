<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->string('site_name', 191);
			$table->string('logo', 191)->nullable();
			$table->string('icon', 191) ->nullable();
			$table->string('email', 191)->nullable();
			$table->string('phone', 191)->nullable();
			$table->integer('paginate')->nullable()->default(10);
			$table->text('description')->nullable();
			$table->text('keywords')->nullable();
			$table->enum('status', ['open', 'close'])->default('open')->nullable();
			$table->string('fb', 191)->nullable();
			$table->string('tw', 191)->nullable();
			$table->string('youtube', 191)->nullable();
			$table->string('in', 191)->nullable();
			$table->string('whats_app', 191)->nullable();
			$table->text('notification_settings_text')->nullable();
			$table->string('android_app_link')->nullable();
			$table->string('ios_app_link')->nullable();
			$table->timestamps();
		});

		\Illuminate\Support\Facades\DB::table('settings')->insert([
		    'site_name' => config('app.name'),
            'paginate' => 10,
            'email' => config('app.name') .'@example.com',
        ]);
	}

	public function down()
	{
		Schema::drop('settings');
	}
}
