<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_details', function (Blueprint $table) {
            $table->increments('project_id');
            $table->string('sub_ward_id');
            $table->string('project_name');
            $table->string('road_name');
            $table->string('municipality_approval')->nullable();
            $table->string('other_approvals')->nullable();
            $table->string('project_status');
            $table->string('basement');
            $table->string('ground');
            $table->string('project_type');
            $table->string('project_size');
            $table->string('budget');
            $table->string('image');
            $table->text('remarks');
            $table->integer('listing_engineer_id');
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
        Schema::dropIfExists('project_details');
    }
}
