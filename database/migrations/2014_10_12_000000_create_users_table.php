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
        //     $table->string('user_role');
        //     $table->rememberToken();
        //     $table->foreignId('current_team_id')->nullable();
        //     $table->text('profile_photo_path')->nullable();
        //     $table->softDeletes();
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
        //     $table->string('office', 50);
        //     $table->string('cluster', 50);
        //     $table->string('section', 50);
        //     $table->string('division', 50);
        //     $table->string('position');
        //     $table->softDeletes();
        //     $table->timestamps();
        // });

        // Schema::create('division', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name', 50);
        //     $table->bigInteger('signatory');
        //     $table->softDeletes();
        //     $table->timestamps();
        // });

        // Schema::create('section', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('division_id_fk');
        //     $table->string('name', 50);
        //     $table->bigInteger('signatory');
        //     $table->softDeletes();
        //     $table->timestamps();
        // });

        // Schema::create('cluster', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('section_id_fk');
        //     $table->string('name', 50);
        //     $table->bigInteger('signatory');
        //     $table->softDeletes();
        //     $table->timestamps();
        // });

        // INSERT INTO `users_details` (`fname`, `mname`, `lname`, `gender`, `contact`, `cluster`, `section`, `division`, `position`, `created_at`, `updated_at`) VALUES
        // ('JP', 'Amper', 'Quiñal', 'Male', '09272677689', '4', '17', '4', 'ePROTrailmis', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('div_rd', 'div_rd', 'office', 'Male', '09272677689', '0', '0', '1', 'Regional Director', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('div_ard', 'div_ard', 'office', 'Male', '09272677689', '0', '0', '2', 'Assistant Regional Director', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('div_lhsd', 'div_lhsd', 'office', 'Male', '09272677689', '0', '0', '3', 'Division Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('div_msd', 'div_msd', 'office', 'Male', '09272677689', '0', '0', '4', 'Division Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('div_rled', 'div_rled', 'office', 'Male', '09272677689', '0', '0', '5', 'Division Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_nnc', 'sec_nnc', 'office', 'Male', '09272677689', '0', '1', '1', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_pheath', 'sec_pheath', 'office', 'Male', '09272677689', '0', '2', '1', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_adelasiera', 'sec_adelasiera', 'office', 'Male', '09272677689', '0', '3', '1', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_crh', 'sec_crh', 'office', 'Male', '09272677689', '0', '4', '1', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_dtr', 'sec_dtr', 'office', 'Male', '09272677689', '0', '5', '1', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_osm', 'sec_osm', 'office', 'Male', '09272677689', '0', '6', '1', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_pdoads', 'sec_pdoads', 'office', 'Male', '09272677689', '0', '7', '1', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_pdoadn', 'sec_pdoadn', 'office', 'Male', '09272677689', '0', '8', '1', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_pdosdn', 'sec_pdosdn', 'office', 'Male', '09272677689', '0', '9', '1', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_pdosds', 'sec_pdosds', 'office', 'Male', '09272677689', '0', '10', '1', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_pdopdi', 'sec_pdopdi', 'office', 'Male', '09272677689', '0', '11', '1', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_ressuhems', 'sec_ressuhems', 'office', 'Male', '09272677689', '0', '12', '2', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_planning', 'sec_planning', 'office', 'Male', '09272677689', '0', '13', '2', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_research', 'sec_research', 'office', 'Male', '09272677689', '0', '14', '2', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_legal', 'sec_legal', 'office', 'Male', '09272677689', '0', '15', '2', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_finance', 'sec_finance', 'office', 'Male', '09272677689', '0', '16', '4', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_hrmds', 'sec_hrmds', 'office', 'Male', '09272677689', '0', '17', '4', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_hfacility', 'sec_hfacility', 'office', 'Male', '09272677689', '0', '18', '5', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_hprogram', 'sec_hprogram', 'office', 'Male', '09272677689', '0', '19', '5', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_procurement', 'sec_procurement', 'office', 'Male', '09272677689', '0', '20', '4', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_materialmgt', 'sec_materialmgt', 'office', 'Male', '09272677689', '0', '21', '4', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_governance', 'sec_governance', 'office', 'Male', '09272677689', '0', '22', '3', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_famhealth', 'sec_famhealth', 'office', 'Male', '09272677689', '0', '23', '3', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_infectious', 'sec_infectious', 'office', 'Male', '09272677689', '0', '24', '3', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('sec_noncomdiseases', 'sec_noncomdiseases', 'office', 'Male', '09272677689', '0', '25', '3', 'Section Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('clus_personnel', 'clus_personnel', 'office', 'Male', '09272677689', '1', '17', '4', 'Cluster Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('clus_training', 'clus_training', 'office', 'Male', '09272677689', '2', '17', '4', 'Cluster Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('clus_healthpromotion', 'clus_healthpromotion', 'office', 'Male', '09272677689', '3', '17', '4', 'Cluster Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('clus_knowledgemanagement', 'clus_knowledgemanagement', 'office', 'Male', '09272677689', '4', '17', '4', 'Cluster Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('clus_deploymentprogram', 'clus_deploymentprogram', 'office', 'Male', '09272677689', '5', '17', '4', 'Cluster Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('clus_budget', 'clus_budget', 'office', 'Male', '09177094848', '6', '16', '4', 'Cluster Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('clus_accounting', 'clus_accounting', 'office', 'Male', '09272677689', '7', '16', '4', 'Cluster Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('clus_cashier', 'clus_cashier', 'office', 'Male', '09272677689', '8', '16', '4', 'Cluster Head', '2021-03-21 21:51:22', '2021-03-21 21:51:22');

        // INSERT INTO `users` (`email`, `email_verified_at`, `password`, `role`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
        // ('radicaljhonpaul@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-03-21 21:51:22', '2021-03-21 21:51:22'),
        // ('div_rd_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-04 00:40:27', '2021-04-16 06:27:24'),
        // ('div_ard_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-05 19:02:22', '2021-04-16 07:07:02'),
        // ('div_lhsd_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 06:23:27', '2021-04-16 06:23:27'),
        // ('div_msd_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 06:29:27', '2021-04-16 06:33:48'),
        // ('div_rled_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:20:03', '2021-04-16 07:23:03'),
        // ('sec_nnc_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_pheath_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_adelasiera_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_crh_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_dtr_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_osm_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_pdoads_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_pdoadn_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_pdosdn_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_pdosds_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_pdopdi_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_ressuhems_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_planning_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_research_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_legal_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_finance_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_hrmds_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_hfacility_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_hprogram_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_procurement_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_materialmgt_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_governance_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_famhealth_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_infectious_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('sec_noncomdiseases_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('clus_personnel_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('clus_training_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('clus_healthpromotion_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('clus_knowledgemanagement_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('clus_deploymentprogram_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('clus_budget_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('clus_accounting_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53'),
        // ('clus_cashier_office@gmail.com', NULL, '$2y$10$kmi5XgpcJfAjUy1W.WaWfuXvIMh5A9.cWmExQb8bNcSno5xH1oHee', 'office', NULL, NULL, NULL, NULL, NULL, '2021-04-16 07:40:53', '2021-04-16 07:40:53');

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
