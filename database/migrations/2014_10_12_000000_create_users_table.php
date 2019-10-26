<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('username')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->string('email')->unique();
            $table->string('picture')->nullable();
            $table->integer('blood_type_id')->unsigned()->nullable();
            $table->integer('rest_code')->nullable()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name' => config('app.name') . ' Admin',
            'username' => 'admin',
            'email' => config('app.name') . '@admin.com',
            'rest_code' => rand(1000,9000),
            'password' => \Illuminate\Support\Facades\Hash::make('admin')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
