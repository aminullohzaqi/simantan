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
        Schema::create('equipment_metadata', function (Blueprint $table) {
            $table->id('id_equipment_metadata');
            $table->integer('id_equipment_type');
            $table->string('equipment', 100);
            $table->string('model', 100);
            $table->string('serial_number', 100)->nullable(true);
            $table->date('installation_date');
            $table->integer('life_time');
            $table->date('last_maintenance')->nullable(true);
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
        Schema::dropIfExists('equipment_metadata');
    }
};
