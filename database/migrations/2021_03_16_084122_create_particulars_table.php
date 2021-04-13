<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateParticularsTable extends Migration {

	public function up()
	{
		// Schema::create('particulars', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('Item', 100);
		// 	$table->integer('item_qty');
		// 	$table->string('item_unit', 50);
		// 	$table->float('item_amount');
		// 	$table->integer('dtrack_id_fk');
		// 	$table->string('purpose', 200);
		// });
	}

	public function down()
	{
		Schema::drop('particulars');
	}
}