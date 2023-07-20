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
        Schema::dropIfExists('log_data_security');
        Schema::dropIfExists('log_data_sensor');
        Schema::dropIfExists('log_data_ups');
        Schema::dropIfExists('log_maintenance_security');
        Schema::dropIfExists('log_maintenance_sensor');
        Schema::dropIfExists('log_maintenance_ups');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
