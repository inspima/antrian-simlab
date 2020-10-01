<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id');
            $table->string('id_type', 50)->default('KTP')->nullable();
            $table->string('id_number', 50);
            $table->string('name');
            $table->string('age');
            $table->string('gender');
            $table->date('born_date');
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('address');
            $table->string('phone')->nullable();
            $table->string('mobile', 50)->nullable();
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
        Schema::dropIfExists('patients');
    }
}
