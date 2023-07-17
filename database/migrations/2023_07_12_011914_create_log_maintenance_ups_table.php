<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_maintenance_ups', function (Blueprint $table) {
            $table->id('id_log_maintenance');
            $table->integer('id_equipment_metadata');
            $table->date('maintenance_date');
            $table->dateTime('arrival_time')->nullable(true);
            $table->dateTime('finish_time')->nullable(true);
            $table->string('work_done')->nullable(true);
            $table->integer('id_technician');
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
        Schema::dropIfExists('log_maintenance_ups');
    }
};
