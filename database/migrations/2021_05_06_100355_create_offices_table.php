<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices_division', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->bigInteger('signatory');
            $table->bigInteger('has_cluster');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('offices_cluster', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('offices_division_id_fk');
            $table->string('name', 50);
            $table->bigInteger('signatory');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('offices_division_id_fk');
            $table->bigInteger('offices_cluster_id_fk');
            $table->string('name', 50);
            $table->bigInteger('signatory');
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offices');
    }
}
