<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaFactura extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('concepto_pago_id');
            $table->foreign('concepto_pago_id','fk_factura_conceptopago')->references('id')->on('concepto_pago')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('estado_factura_id')->default(1);
            $table->foreign('estado_factura_id','fk_factura_estadofactura')->references('id')->on('estado_factura')->onDelete('restrict')->onUpdate('restrict');
            $table->string('numero',6);
            $table->date('fecha_facturacion');
            $table->double('subtotal',8,2);
            $table->double('total_con_igv',8,2);
            $table->double('pago_sin_detraccion',8,2);
            $table->text('observacion')->nullable();
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
        Schema::dropIfExists('factura');
    }
}
