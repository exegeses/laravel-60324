<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('idProducto');
            $table->string('prdNombre', 50);
            $table->float('prdPrecio', 9,2);
            $table->tinyInteger('idMarca')->unsigned();
            $table->tinyInteger('idCategoria')->unsigned();
            $table->text('prdDescripcion');
            $table->string('prdImagen', 50);
            $table->boolean('prdActivo')->default(1);
            /* foreign keys */
            $table->foreign('idMarca')
                    ->references('idMarca')->on('marcas');
            $table->foreign('idCategoria')
                    ->references('idCategoria')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
