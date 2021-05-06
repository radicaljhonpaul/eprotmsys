<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsStatusLogsTable extends Migration {

	public function up()
	{
		// Schema::create('documents_status_logs', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('document_status');
		// $table->string('dtrack_id_fk' ,50);
		// 	$table->string('doc_notes', 500);
		// 	$table->integer('division');
		// 	$table->integer('section');
		// 	$table->integer('cluster');
		// 	$table->string('forwarded_to', 20);
		// 	$table->softDeletes();
		// });

		// Schema::create('documents_mutation_status_logs', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('document_status',50);
		// 	$table->string('dtrack_id_fk' ,50);
		// 	$table->string('doc_notes', 500);
		// 	$table->integer('division');
		// 	$table->integer('section');
		// 	$table->integer('cluster');
		// 	$table->string('forwarded_to', 20);
		// 	$table->integer('receiver_id');
		// 	$table->string('status', 20);
		// 	$table->softDeletes();
		// });

		// Schema::create('img_logs', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('filename');
		// 	$table->string('path');
		// 	$table->integer('document_status_logs_id_fk');
		// 	$table->integer('user_id_fk');
		// 	$table->softDeletes();
		// });
	}

	public function down()
	{
		Schema::drop('documents_status_logs');
	}
}