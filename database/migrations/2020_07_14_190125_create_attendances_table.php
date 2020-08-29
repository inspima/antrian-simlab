<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('work_time_id')->nullable();
            $table->string('shift_name')->nullable();
            $table->timestamp('in_time')->nullable();
            $table->string('in_pict')->nullable();
            $table->string('in_lat')->nullable();
            $table->string('in_lng')->nullable();
            $table->timestamp('out_time')->nullable();
            $table->string('out_pict')->nullable();
            $table->string('out_lat')->nullable();
            $table->string('out_lng')->nullable();
            $table->date('date');
            $table->integer('status')->default(0)->comment("0:attendance,1:late,2:absent");
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('attendances');
    }
}
