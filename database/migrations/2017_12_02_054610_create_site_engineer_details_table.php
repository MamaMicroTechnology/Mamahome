<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteEngineerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_engineer_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->string('site_engineer_name')->nullable();
            $table->string('site_engineer_contact_no')->nullable();
            $table->string('site_engineer_email')->nullable();
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
        Schema::dropIfExists('site_engineer_details');
    }
}
