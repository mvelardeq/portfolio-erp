<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaAsientoCuenta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asiento_cuenta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cuenta_contable_id');
            $table->foreign('cuenta_contable_id','fk_asientocuenta_cuentacontable')->references('id')->on('cuenta_contable')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('asiento_contable_id');
            $table->foreign('asiento_contable_id','fk_asientocuenta_asientocontable')->references('id')->on('asiento_contable')->onDelete('restrict')->onUpdate('restrict');
            $table->double('debe',6,2)->nullable();
            $table->double('haber',6,2)->nullable();
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
        Schema::dropIfExists('asiento_cuenta');
    }
}