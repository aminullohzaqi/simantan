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
        Schema::create('log_data_sensor', function (Blueprint $table) {
            $table->id('id_log_data');
            $table->integer('id_param');
            $table->date('maintenance_date');
            $table->float('check_in')->nullable(true);
            $table->float('check_out')->nullable(true);
            $table->boolean('tf_passed')->nullable(true);
            $table->boolean('tf_not_passed')->nullable(true);
            $table->boolean('tf_chk')->nullable(true);
            $table->boolean('tf_clg')->nullable(true);
            $table->boolean('tf_rpr')->nullable(true);
            $table->boolean('tf_rplt')->nullable(true);
            $table->string('note')->nullable(true);
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
        Schema::dropIfExists('log_data_sensor');
    }
};
