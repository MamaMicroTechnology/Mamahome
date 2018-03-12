<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractor_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->string('contractor_name')->nullable();
            $table->string('contractor_contact_no')->nullable();
            $table->string('contractor_email')->nullable();
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
        Schema::dropIfExists('contractor_details');
    }
}
