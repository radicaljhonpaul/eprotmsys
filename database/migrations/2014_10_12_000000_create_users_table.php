<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('users', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('username');
        //     $table->string('email')->unique();
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('password');
        //     $table->string('role');
        //     $table->rememberToken();
        //     $table->foreignId('current_team_id')->nullable();
        //     $table->text('profile_photo_path')->nullable();
        //     $table->timestamps();
        // });

        // Schema::create('users_details', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('user_id_fk');
        //     $table->string('fname');
        //     $table->string('mname');
        //     $table->string('lname');
        //     $table->string('gender');
        //     $table->string('contact');
        //     $table->string('office');
        //     $table->string('office_unit');
        //     $table->string('position');
        //     $table->timestamps();
        // });

        // Schema::create('division', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name', 50);
        //     $table->bigInteger('signatory');
        //     $table->timestamps();
        // });

        // Schema::create('section', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('division_id_fk');
        //     $table->string('name', 50);
        //     $table->bigInteger('signatory');
        //     $table->timestamps();
        // });

        // Schema::create('cluster', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('section_id_fk');
        //     $table->string('name', 50);
        //     $table->bigInteger('signatory');
        //     $table->timestamps();
        // });
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
