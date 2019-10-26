<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitiesTable extends Migration {

	public function up()
	{
		Schema::create('cities', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->string('name', 191);
			$table->integer('governorate_id')->unsigned();
			$table->timestamps();
		});

		\Illuminate\Support\Facades\DB::table('cities')->insert([
            [ 'id' => 1,  'governorate_id' =>1, 'name' =>'لقاهره'],
            [ 'id' => 2,  'governorate_id' =>2, 'name'  =>'الجيزة'],
            [ 'id' => 10, 'governorate_id' => 2,  'name' => 'الباويطي'],
            [ 'id' => 11, 'governorate_id' => 2,  'name' => 'منشأة القناطر'],
            [ 'id' => 12, 'governorate_id' => 2,  'name' => 'أوسيم'],
            [ 'id' => 13, 'governorate_id' => 2,  'name' => 'كرداسة'],
            [ 'id' => 14, 'governorate_id' => 2,  'name' => 'أبو النمرس'],
            [ 'id' => 15, 'governorate_id' => 2,  'name' => 'كفر غطاطي'],
            [ 'id' => 16, 'governorate_id' => 2,  'name' => 'منشأة البكاري'],
            [ 'id' => 17, 'governorate_id' => 3,  'name' => 'الأسكندرية'],
            [ 'id' => 18, 'governorate_id' => 3,  'name' => 'برج العرب'],
            [ 'id' => 19, 'governorate_id' => 3,  'name' => 'برج العرب الجديدة'],
            [ 'id' => 20, 'governorate_id' => 12, 'name' =>  'بنها'],
            [ 'id' => 21, 'governorate_id' => 12, 'name' =>  'قليوب'],
            [ 'id' => 22, 'governorate_id' => 12, 'name' =>  'شبرا الخيمة'],
            [ 'id' => 23, 'governorate_id' => 12, 'name' =>  'القناطر الخيرية'],
            [ 'id' => 24, 'governorate_id' => 12, 'name' =>  'الخانكة'],
            [ 'id' => 25, 'governorate_id' => 12, 'name' =>  'كفر شكر'],
            [ 'id' => 26, 'governorate_id' => 12, 'name' =>  'طوخ'],
            [ 'id' => 27, 'governorate_id' => 12, 'name' =>  'قها'],
            [ 'id' => 28, 'governorate_id' => 12, 'name' =>  'العبور'],
            [ 'id' => 29, 'governorate_id' => 12, 'name' =>  'الخصوص'],
            [ 'id' => 30, 'governorate_id' => 12, 'name' =>  'شبين القناطر'],
            [ 'id' => 31, 'governorate_id' => 6,  'name' => 'دمنهور'],
            [ 'id' => 32, 'governorate_id' => 6,  'name' => 'كفر الدوار'],
            [ 'id' => 33, 'governorate_id' => 6,  'name' => 'رشيد'],
            [ 'id' => 34, 'governorate_id' => 6,  'name' => 'إدكو'],
            [ 'id' => 35, 'governorate_id' => 6,  'name' => 'أبو المطامير'],
            [ 'id' => 36, 'governorate_id' => 6,  'name' => 'أبو حمص'],
            [ 'id' => 37, 'governorate_id' => 6,  'name' => 'الدلنجات'],
            [ 'id' => 38, 'governorate_id' => 6,  'name' => 'المحمودية']
        ]);
	}

	public function down()
	{
		Schema::drop('cities');
	}
}
