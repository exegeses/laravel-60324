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
        Schema::create('clientes', function (Blueprint $table) {
            $table->smallIncrements('idCliente');// idCliente smallint primary key auto_increment
            $table->string('nombre', 150); // nombre varchar(150) not null
            $table->integer('dni'); // dni int not null
            $table->timestamps(); // updated_at created_at  timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
