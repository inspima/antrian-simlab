<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('registration_id');
            $table->string('id_type', 50)->default('KTP')->nullable();
            $table->string('id_number', 50);
            $table->string('name');
            $table->string('age');
            $table->string('gender');
            $table->date('born_date');
            $table->text('address');
            $table->string('phone')->nullable();
            $table->string('mobile', 50)->nullable();
            $table->integer('test_loop')->default(0);
            $table->integer('sync_status')->default(0)->comment("0=Belum Sync,1= Proses Pengujian, 2=Keluar Hasil");
            $table->string('simlab_reg_code')->nullable();
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
        Schema::dropIfExists('registration_patients');
    }
}
