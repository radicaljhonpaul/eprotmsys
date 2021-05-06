<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration {

	public function up()
	{
		// Schema::create('documents', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('dtrack_no' ,50);
		// 	$table->string('doc_type', 50);
		// 	$table->integer('doc_end_user');
		// 	$table->string('doc_current_status', 50);
		// 	$table->string('doc_current_location', 50);
		// 	$table->string('forwarded_to', 50);
		// 	$table->integer('is_received');
		// 	$table->integer('final_status');
		// 	$table->softDeletes();
		// });

		// Schema::create('documents_mutation', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('dtrack_no' ,50);
		// 	$table->string('doc_type', 50);
		// 	$table->integer('doc_end_user');
		// 	$table->string('doc_current_status', 50);
		// 	$table->string('doc_current_location', 50);
		// 	$table->string('forwarded_to', 50);
		// 	$table->integer('is_received');
		// 	$table->integer('final_status');
		// 	$table->softDeletes();
		// });

		// Schema::create('documents_mutation_logs', function(Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->timestamps();
		// 	$table->string('dtrack_no_id' ,50);
		// 	$table->string('doc_type_from', 50);
		// 	$table->string('doc_type_to', 50);
		// 	$table->softDeletes();
		// });
	}

	public function down()
	{
		Schema::drop('documents');
	}
}