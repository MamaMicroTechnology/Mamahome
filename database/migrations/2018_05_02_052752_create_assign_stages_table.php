<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_stages', function (Blueprint $table) {
            $table->increments('id');
             $table->String('user_id');
              $table->String('ward');
               $table->String('subward');
              $table->String('stage');
               $table->String('project_type');
              $table->String('project_size');
               $table->String('budget');
                $table->String('contract_type');
              $table->String('constraction_type');
              $table->String('rmc');
               $table->String('budget_type');
               $table->String('assigndate');
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
        Schema::dropIfExists('assign_stages');
    }
}
