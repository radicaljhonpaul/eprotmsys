<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
		// 	$table->string('dtrack_id_fk', 50);
		// 	$table->string('purpose', 200);
		// 	$table->softDeletes();
		// });
	}

	public function down()
	{
		Schema::drop('particulars');
	}
}