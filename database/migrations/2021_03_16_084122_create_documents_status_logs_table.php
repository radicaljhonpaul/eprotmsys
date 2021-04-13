<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDocumentsStatusLogsTable extends Migration {

	public function up()
	{
		// Schema::create('documents_status_logs', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('document_status');
		// 	$table->integer('document_id_fk');
		// 	$table->string('doc_notes', 500);
		// 	$table->integer('division');
		// 	$table->integer('section');
		// 	$table->integer('cluster');
		// 	$table->string('forwarded_to', 20);
		// 	$table->integer('img_log_id_fk');
		// });

		// Schema::create('img_logs', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('filename');
		// 	$table->string('path');
		// 	$table->integer('user_id_fk');
		// });
	}

	public function down()
	{
		Schema::drop('documents_status_logs');
	}
}