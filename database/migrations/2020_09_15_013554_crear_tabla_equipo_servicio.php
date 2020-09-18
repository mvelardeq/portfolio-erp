<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaEquipoServicio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipo_servicio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('servicio_id');
            $table->foreign('servicio_id','fk_equiposervicio_servicio')->references('id')->on('servicio')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id','fk_equiposervicio_empresa')->references('id')->on('empresa')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('equipo_id');
            $table->foreign('equipo_id','fk_equiposervicio_equipo')->references('id')->on('equipo')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('horas');
            $table->unsignedBigInteger('costo_sin_igv');
            $table->date('fecha_inicio',12);
            $table->date('fecha_fin',12)->nullable();
            $table->string('estado',20);
            $table->string('observacion',300)->nullable();
            $table->timestamps();
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_spanish_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipo_servicio');
    }
}
