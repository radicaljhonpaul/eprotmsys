<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('notifications', function (Blueprint $table) {
        // 	$table->increments('id');
        //     $table->timestamps();
		// 	$table->string('dtrack_id_fk',50);
		// 	$table->integer('from');
		// 	$table->integer('to');
		// 	$table->integer('event_id_fk');
		// 	$table->string('is_open', 50);
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
