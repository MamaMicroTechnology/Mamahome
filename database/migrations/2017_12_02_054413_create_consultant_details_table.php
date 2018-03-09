<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultantDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultant_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->string('consultant_name')->nullable();
            $table->string('consultant_contact_no')->nullable();
            $table->string('consultant_email')->nullable();
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
        Schema::dropIfExists('consultant_details');
    }
}
