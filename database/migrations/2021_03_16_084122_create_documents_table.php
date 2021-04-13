<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDocumentsTable extends Migration {

	public function up()
	{
		// Schema::create('documents', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->integer('dtrack_no')->unsigned();
		// 	$table->string('doc_type', 50);
		// 	$table->integer('doc_end_user');
		// 	$table->string('doc_current_status', 50);
		// 	$table->string('doc_current_location', 50);
		// });
	}

	public function down()
	{
		Schema::drop('documents');
	}
}